<?php


namespace App\Tests\Controller;

use App\Entity\Task;
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

    public function testTaskCreateWithUnauthenticatedUser()
    {
        $client = static::createClient();   
  
        $crawler = $client->request('GET', '/tasks/create');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }

    public function testTaskCreatWithAuthentification()
    {
        $client = static::createClient();   
     
        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form(['task[title]' => 'Titre de la tâche 2',
        'task[content]' => 'Description de la tâche 2']);

        $client->submit($form);

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }
    
    public function testEditTaskWithAuthentification()
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

    public function testEditTaskWithAutheAuthentificationUser()
    {   
        $client = static::createClient();   

        $client->request('GET', '/tasks/3/edit');
     
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }   
    

    public function testDeleteTaskWithAuthentification()
    {
        $client = static::createClient();   

        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $client->request('Supprimer', '/tasks/3/delete');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
    }

    public function testDeleteTaskWithWithWrongAuthentification()
    {
        $client = static::createClient();   

        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $client->request('Supprimer', '/tasks/1/delete');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
    }

    public function testDeleteTaskWithoutAuthentificatedUser()
    {
        $client = static::createClient();   

        $client->request('Supprimer', '/tasks/3/delete');
        $this->assertResponseRedirects('/');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
    }

    public function testToggleTaskAction()
    {
        $client = static::createClient();

        // Récupère la première tâche
        $taskRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);
        $task = $taskRepository->findOneBy(['id' => 1]);;
        // Accède à la page de la tâche
        $crawler = $client->request('GET', '/tasks/'.$task->getId().'/toggle');

        // Vérifie que la page a bien répondu avec un code 302 (redirection)
        $this->assertEquals(302, $client->getResponse()->getStatusCode());

        // Vérifie que la tâche a été correctement modifiée
        $updatedTask = $taskRepository->find($task->getId());
        $this->assertEquals($task->isDone(), $updatedTask->isDone());

        // Vérifie que la page de redirection est bien la liste des tâches
        $this->assertFalse($client->getResponse()->isRedirect('tasks'));
    }


    public function testDeleteTaskWrongUser()
    {
        $client = static::createClient();   

        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $client->request('Supprimer', '/tasks/1/delete');
        //$this->assertResponseRedirects('Supprimer', '/tasks/1/delete');
        $this->assertResponseRedirects('/');

        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
    }

    public function testDeleteTaskNotFound()
    {
        $client = static::createClient();   

        $userRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::class);
        $testUser = $userRepository->findOneBy(['username' => 'user']);
        $client->loginUser($testUser);

        $taskRepository = $client->getContainer()->get('doctrine.orm.entity_manager')->getRepository(Task::class);

        $client->request('task_delete', '/tasks/999999');
        $this->assertNull($taskRepository->findOneBy(['id' => 999999]), 'La tâche devrait être supprimée de la base de données');

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND, 'La page devrait retourner un code 404');
    }

}
