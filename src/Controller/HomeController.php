<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Repository\PostRepository;
use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ThemeRepository $themeRepository): Response
    {

        if(!$this->getUser()->isverified() === true)
        {
            $this->addFlash('warning', 'Veuillez confirmer votre adresse e-mail pour accéder à votre compte.');
        }
        $themes = $themeRepository->findAll();
        return $this->render('home/index.html.twig', [
            'themes' => $themes
        ]);
    }

    #[Route('/theme/{slug}', name: 'app_theme')]
    public function theme(Theme $theme): Response
    {
        $themeName = $theme->getNom();
        $posts = $theme->getPost();

        return $this->render('theme/theme.html.twig', [
            'theme' => $themeName,
            'posts' => $posts
        ]);
    }
}
