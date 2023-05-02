<?php


namespace App\Tests\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Flex\Response as FlexResponse;

class TaskControllerTest extends WebTestCase
{
    public function testTaskList()
    {
        $client = static::createClient();   
        $client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }

    public function testTaskCreat()
    {
        $client = static::createClient();   
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form(['_username' => 'admin',
        '_password' => '123456']);
        $client->submit($form);

        
        $this->assertResponseRedirects();

        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form(['task[title]' => 'Titre de la tâche 2',
        'task[content]' => 'Description de la tâche 2']);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }
    
    public function testEditTask()
    {   
        $client = static::createClient();   

        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $client->request('GET', '/tasks/3/edit');
        $this->assertRouteSame('task_edit');

        $client->submitForm('Modifier', [
            'task[title]' => 'Modification',
            'task[content]' => 'Modification'
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }   
    

    public function testDeleteTask()
    {
        $client = static::createClient();   

        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $client->request('Supprimer', '/tasks/3/delete');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
    }
}
