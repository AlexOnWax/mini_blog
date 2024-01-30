<?php

namespace App\Tests;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PostTest extends KernelTestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    //Créer un post
    public function testValidPost(): void
    {
        $post = new Post();
        $post->setTitle('titre')
            ->setContent('contenu')
            ->setDraft(false)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUser($this->entityManager
                ->getRepository(User::class)
                ->findOneBy(['id' => 1]));

        $this->entityManager->persist($post);
        $this->entityManager->flush();

        $this->assertSame('titre', $post->getTitle());
        $newPostId = $post->getId();

        //Nous testons dans la foulé la suppression du post
        $this->entityManager->remove($post);
        $this->entityManager->flush();
        $this->assertNull(
            $this->entityManager
                ->getRepository(Post::class)
                ->findOneBy(['id' => $newPostId])
        );

    }


    //Edition d'un post
    public function testEditPost(): void
    {
        $post = $this->entityManager
            ->getRepository(Post::class)
            ->findOneBy(['id' => 2])
        ;

        $post->setTitle('titre modifié');
        $post->setContent('contenu modifié');
        $post->setDraft(true);


        $this->entityManager->flush();

        $this->assertSame('titre modifié', $post->getTitle());
    }

    //Ajout d'une image dans un post
    public function testAddImage(): void
    {
        $post = $this->entityManager
            ->getRepository(Post::class)
            ->findOneBy(['id' => 2])
        ;

        $post->setImageFilename('image.jpg');
        $post->setImageSize(100);

        $this->entityManager->flush();

        $this->assertSame('image.jpg', $post->getImageFilename());
    }

    //Suppression d'une image dans un post
    public function testDeleteImage(): void
    {
        $post = $this->entityManager
            ->getRepository(Post::class)
            ->findOneBy(['id' => 2])
        ;

        $post->setImageFilename(null);
        $post->setImageSize(null);

        $this->entityManager->flush();

        $this->assertNull($post->getImageFilename());
    }
}
