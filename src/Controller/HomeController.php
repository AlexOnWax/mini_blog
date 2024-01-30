<?php

namespace App\Controller;

use App\Entity\Like;
use App\Entity\Post;
use App\Entity\Theme;
use App\Form\PostType;
use App\Repository\LikeRepository;
use App\Repository\PostRepository;
use App\Repository\ThemeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichFileType;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ThemeRepository $themeRepository): Response
    {
        // si l'user est connecté et que son email n'est pas vérifié
        if($this->getUser() && $this->getUser()->isVerified() === false)
        {
            $this->addFlash('warning', 'Veuillez confirmer votre adresse e-mail pour accéder à votre compte.');
        }

        $themes = $themeRepository->findAll();
        return $this->render('home/index.html.twig', [
            'themes' => $themes
        ]);
    }

    #[Route('/theme/{slug}', name: 'app_theme')]
    public function theme(Theme $theme, PostRepository $postRepository): Response
    {

//        $posts = $theme->getPost();
        $posts = $postRepository->getPublishedPostsByTheme($theme);

        return $this->render('theme/theme.html.twig', [
            'theme' => $theme,
            'posts' => $posts
        ]);
    }
    #[Route('/mon-espace', name: 'app_mon_espace')]
    public function monEspace(): Response
    {
        $user = $this->getUser();
        $posts = $user->getPosts();

        return $this->render('mon_espace/mon_espace.html.twig', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    #[Route('/delete_post/{id}', name: 'app_delete_post')]
    public function deletePost(EntityManagerInterface $em, Post $post):Response
    {
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('app_mon_espace');
    }

    #[Route('/delete_image/{id}', name: 'app_remove_image')]
    public function deleteImage(EntityManagerInterface $em, Post $post):Response
    {
        //Supprimer le fichier image dans le dossier public/uploads/posts
        $file = $this->getParameter('kernel.project_dir').'/public/images/posts/'.$post->getImageFilename();
        ;
        if (file_exists($file)) {

            unlink($file);
        }

        $post->setImageFilename(null);
        $post->setImageSize(null);

        $em->persist($post);
        $em->flush();
        // Rafraîchir l'entité Post
        $em->refresh($post);

        $this->addFlash('success', 'L\'image a bien été supprimée');

        // Rediriger l'utilisateur vers le formulaire
        return $this->redirectToRoute('app_edit_post', ['id' => $post->getId()]);
    }

    #[Route('/edite_post/{id}', name: 'app_edit_post')]
    public function editePost(Request $request, EntityManagerInterface $em, Post $post):Response
    {
        $form = $this->createForm(PostType::class, $post);
        //ci-dessus, le deuxième argument permet de remplir les champs avec les données de $post

        // récupèrons les themes associés au post
        $originalThemes = $post->getThemes()->toArray();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            //Si l'user delete une image, nous traitons la suppression de l'image
            if($form->get('imageFile')->getData() === null && $form->get('imageFile')->getData() === null)
            {
                $post->setImageFilename(null);
                $post->setImageSize(null);
            }else{
                //Si l'user upload une nouvelle image, alors traitons l'upload de l'image
                $post->setImageFilename($form->get('imageFile')->getData()->getFilename());
                $post->setImageSize($form->get('imageFile')->getData()->getSize());
            }

            $selectedThemes = $form->get('themes')->getData()->toArray();
            // Nous comparons les themes originaux aux themes choisis dans notre formulaire de modification
            // S'il détecte un changement, alors nous allons effacer les anciens thèmes et les remplacer par les nouveaux.
            $themesChanged = count(array_diff($originalThemes, $selectedThemes)) > 0 || count(array_diff($selectedThemes, $originalThemes)) > 0;

            if ($themesChanged) {

                // Ici les thèmes ont changé
                // Effaçons alors les thèmes originaux (Dans les deux sens par rapport à la relation de type many to many)
                foreach ($originalThemes as $theme) {
                    $post->removeTheme($theme);
                    $theme->removePost($post);
                }

                // Puis associons les nouveaux thèmes au post
                foreach ($selectedThemes as $theme) {
                    $post->addTheme($theme);
                    $theme->addPost($post);
                }
            }
            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('app_mon_espace'); // Redirection vers la page mon espace
        }
        return $this->render('mon_espace/edite-post.html.twig',[
            'form' => $form->createView(),
            'post' => $post
        ]);

    }
    #[Route('/draft_post/{id}', name: 'app_draft_post')]
    public function draftPost(Post $post, EntityManagerInterface $em):Response
    {
        $post->setDraft(true);
        $em->flush();
        return $this->redirectToRoute('app_mon_espace');
    }
    #[Route('/publish_post/{id}', name: 'app_publish_post')]
    public function publishPost(Post $post, EntityManagerInterface $em):Response
    {
        $post->setDraft(false);
        $em->flush();
        return $this->redirectToRoute('app_mon_espace');
    }

    #[Route('/like_post/{id}/{theme}', name: 'app_like_post')]
    public function likePost(Post $post,Theme $theme, EntityManagerInterface $em, LikeRepository $likeRepository):Response
    {
        $user = $this->getUser();
        // on vérifie si l'utilisateur a liké le post

        //On tente de trouver un like avec l'utilisateur et le post
        $like = $likeRepository->findOneBy([
            'user' => $user,
            'post' => $post
        ]);

        if($like)
        {
            // Si le like existe, on supprime le like
            $em->remove($like);
            $em->flush();
            return $this->redirectToRoute('app_theme', ['slug' => $theme->getSlug()]);
        }else{
            // sinon on ajoute le like
            $like = new Like();
            $like->setUser($user);
            $like->setPost($post);
            $em->persist($like);
            $em->flush();
            return $this->redirectToRoute('app_theme', ['slug' => $theme->getSlug()]);
        }

        return $this->redirectToRoute('app_theme', ['slug' => $theme->getSlug()]);
    }

    #[Route('/create_post', name: 'app_create_post')]
    public function createPost(Request $request,EntityManagerInterface $em):Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class,$post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedThemes = $form->get('themes')->getData();

            // Associez les thèmes sélectionnés au post et gérons le ManyToMany entre Post et Theme
            foreach ($selectedThemes as $theme) {
                $post->addTheme($theme);
                $theme->addPost($post);
            }


            $post->setUser($this->getUser());
            $post->setCreatedAt(new \DateTimeImmutable());

            $em->persist($post);
            $em->flush();
            return $this->redirectToRoute('app_mon_espace');
        }
        return $this->render('mon_espace/create-post.html.twig',[
            'form' => $form->createView()
        ]);
    }

}
