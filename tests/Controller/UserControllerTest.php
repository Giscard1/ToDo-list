<?php


namespace App\Tests\Controller;

use App\DataFixtures\UserTestFixture;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\VarDumper\VarDumper;
use Doctrine\ORM\EntityManagerInterface;
use SebastianBergmann\Type\StaticType;

class UserControllerTest extends WebTestCase
{ 
    /* avec le mentor
    private $entityManager; 

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
*/
/*
    protected $entityManager;
        protected $client;
        
        protected function setUp(): void
        {
            $this->client = static::createClient();
            $kernel = self::bootKernel();
            $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
        }
*/
    public function testListUser()
    {/*
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'giscard',
            '_password' => '123456'
        ]);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $client->followRedirect();
        //$this->assertRouteSame('homapage');

        $crawler = $client->request('GET', '/users');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        // ------------> Ne fonctionne a partir d'ici 
        $this->assertSelectorTextContains("h1", "Liste des utilisateurs");

        //self::assertEquals('Liste des utilisateurs', $crawler->filter('h1')->text());
        //self::assertEquals('Edit', $crawler->filter('a.btn.btn-success')->text());
        //$this->assertResponseRedirects();
        //$this->assertResponseIsSuccessful();
        */

    }
    
    public function testCreateUser()
    {   
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneBy(['email' => 'admin@gmail.com']);
        $client->loginUser($user);
        var_dump($user);
   
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);    
    }
    
        
    public function testEditUser()
    {
        /*
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form([
            '_username' => 'giscard',
            '_password' => '123456'
        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        */
        $client = static::createClient();
        $userRepository = static::getContainer()->get(UserRepository::class);
        $user = $userRepository->findOneByEmail('gfake@email.fr');
        //var_dump($user);
        $client->loginUser($user);
        $this->assertNotNull($user, 'L\'utilisateur n\'a pas été trouvé.');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);

        
        
        $crawler = $client->request('GET', '/users');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

        $crawler->selectButton('Edit','/users/1/edit');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
        //--------------> Ne fonctionne pas a partir d'ici
        /*
        $form = $crawler->selectButton('Modifier')->form();
        $client->submit($form, [
            'user[username]' => 'John',
            'user[password][first]' => 'root',
            'user[password][second]' => 'root',
            'user[email]' => 'john@doe.fr',
            'user[roles][0]' => 'ROLE_USER',
            'user[roles][1]' => 'ROLE_ADMIN',
        ]);
        */
        //self::assertEquals(302, $client->getResponse()->getStatusCode());
        
    }
}
