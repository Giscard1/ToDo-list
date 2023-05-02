<?php


namespace App\Tests\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;
use Symfony\Component\HttpKernel\Event\RequestEvent;

class DefaultControllerTest extends WebTestCase
{ 
    
    
    public function testIndexActionAdmin()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $this->assertSelectorTextContains("h1", "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
        $client->request('GET', '/login');

        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);
        $client->loginUser($testUser);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
    
    
    public function testIndexActionUser()
    {
        //fonctionnelle
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testLogout()
    {   
        $client = static::createClient();

        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $client->request('GET', '/logout');
        return $this->assertSame(302, $client->getResponse()->getStatusCode());
    }
    
}
