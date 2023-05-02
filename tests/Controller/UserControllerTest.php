<?php


namespace App\Tests\Controller;

use App\DataFixtures\UserTestFixture;
use App\Repository\UseRepository;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;    
use Symfony\Component\VarDumper\VarDumper;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\Type\StaticType;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Form\FormFactoryInterface;

class UserControllerTest extends WebTestCase
{ 
    private $client;
    private $formFactory;
    
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->formFactory = static::getContainer()->get(FormFactoryInterface::class);
    
    }

    public function testListUser()
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);
        $this->client->loginUser($testUser);
       
        $this->client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
      
        $this->assertSelectorTextContains("h1", "Liste des utilisateurs");
    }
    
    public function testCreateUserWithAuthenticatedAdmin()
    { 
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);
        $this->client->loginUser($testUser);

        $this->client->request('GET', '/users/create');
        $this->assertRouteSame('user_create');
        
        $this->client->submitForm('Ajouter', [
            'user[username]' => 'newuser',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => 'newuser@user.user',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }
    
    public function testCreateUserAnonymously()
    { 
        $this->client->request('GET', '/users/create');
        $this->assertRouteSame('user_create');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }
        
    public function testEditUser()
    {
        $userRepository = $this->client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'admin']);
        $this->client->loginUser($testUser);
        
        $this->client->request('GET', '/users');
        $this->assertRouteSame('user_list');

        $this->client->request('GET', '/users/3/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $this->client->submitForm('Modifier', [
            'user[username]' => 'newuser',
            'user[password][first]' => 'password',
            'user[password][second]' => 'password',
            'user[email]' => 'newuser@user.user',
        ]);

        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $this->assertResponseRedirects();
        $this->client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertRouteSame('user_list');
        $this->assertSelectorExists('div.alert.alert-success');
        
    }
}
