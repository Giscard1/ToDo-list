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
    
    /*
    public function testIndexActionAdmin()
    {
        //fonctionnelle
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $this->assertSelectorTextContains("h1", "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'giscard',
            '_password' => '123456'
        ]);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }
    */
    /*
    public function testIndexActionUser()
    {
        //fonctionnelle
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $this->assertSelectorTextContains("h1", "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'bbb',
            '_password' => '123456'
        ]);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }


    public function testIndexActionWrongData()
    {
        //fonctionnelle
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        
        $this->assertSelectorTextContains("h1", "Bienvenue sur Todo List, l'application vous permettant de gérer l'ensemble de vos tâches sans effort !");
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'bbb',
            '_password' => 'aaaa'
        ]);
        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testLogout()
    {   
        //fonctionnelle
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'bbb',
            '_password' => '123456'
        ]);        
        $client->request('GET', '/logout');
        return $this->assertSame(302, $client->getResponse()->getStatusCode());
    }
    */
}
