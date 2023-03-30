<?php


namespace App\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Flex\Response as FlexResponse;

class TaskControllerTest extends WebTestCase
{
    /* fonctionne bien 
    public function testTaskList()
    {
        $client = static::createClient();   
        $client->request('GET', '/tasks');
        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }*/

    
    /* finctionne bien 
    public function testTaskCreat()
    {
        $client = static::createClient();   
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form(['_username' => 'giscard',
        '_password' => '123456']);
        $client->submit($form);
        $this->assertResponseRedirects();

        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form(['task[title]' => 'Titre de la tâche 2',
        'task[content]' => 'Description de la tâche 2']);
        $client->submit($form);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);

    }
    */
    /* ne fonctionne pas 
    public function testEditTask()
    {   
        $client = static::createClient();   
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form(['_username' => 'giscard',
        '_password' => '123456']);
        $client->submit($form);
        $this->assertResponseRedirects();

        $crawler = $client->request('GET', '/tasks/3/edit');
        $form = $crawler->selectButton('btn btn-success pull-right')->form(['task[title]' => 'Titre de la tâche 2',
        'task[content]' => 'Description de la tâche 2']);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        */

       /* self::assertCount(2, $crawler->filter('input'));
        self::assertEquals('Modifier', $crawler->filter('btn btn-success pull-right')->text());

        $buttonCrawlerMode = $crawler->filter('form');
        $form = $buttonCrawlerMode->form([      
            'task[title]' => 'Titre de la tâche',
            'task[content]' => 'Description de la tâche']);
        $client->submit($form);
    }   */
    /*
        $crawler = $client->request('GET','/tasks/6/edit');
        $form = $crawler->selectButton('Modifier')->form(['task[title]' => 'Titre de la tâche 2',
        'task[content]' => 'Description de la tâche 2']);
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);*/
        
    

/* ne fonctionne pas 

    public function testDeleteTask()
    {
        $client = static::createClient();   
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form(['_username' => 'giscard',
        '_password' => '123456']);
        $client->submit($form);
        $this->assertResponseRedirects();

        
        $crawler->$client->request('Supprimer', '/tasks/3/delete');
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        
    }
*/
}
