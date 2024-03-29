<?php


namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    private $client;
    
    protected function setUp(): void
    {
        $this->client = static::createClient();    
    }
    
    public function testLogin(): void
    {

        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $this->client->loginUser($testUser);
        
        
        $crawler = $this->client->request('GET', '/');
        $this->assertSelectorExists('a[href="/logout"]');

    }

    public function testLogout()
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', '/logout');

        //$this->assertResponseRedirects('/', Response::HTTP_FOUND);

        $this->client->followRedirect();

        $this->assertRouteSame('homepage');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

    }
    
}
