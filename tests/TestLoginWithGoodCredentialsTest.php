<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TestLoginWithGoodCredentialsTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Sign in')->form([
            'email' => 'phamon@hardy.com',
            'password' => 'password'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects('/');
        $client->followRedirect();


    }
}
