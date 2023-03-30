<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers Class TaskTest
 * @package App\Tests\Entity
 */
class TaskTest extends KernelTestCase
{

    public function testValidTask()
    {
    // fonctionnel
    // Créer une nouvelle tâche avec l'utilisateur créé
    $task = new Task();
    $task->setCreatedAt(new DateTime('Now'));
    $task->setTitle('titre de test');
    $task->setContent('task');
    //$task->setIsDone(0);
    //$task->setUser($user);

    // Valider la tâche
    self::bootKernel();
    $error = self::$container->get('validator')->validate($task);
    $this->assertCount(0, $error);
    }

  
    public function testInvalidTask()
    {
    // fonctionnel
    $task = new Task();
    $task->setCreatedAt(new DateTime('Now'));
    $task->setTitle('');
    $task->setContent('task');
    //$task->setIsDone(0);
    //$task->setUser($user);

    // Valider la tâche
    self::bootKernel();
    $error = self::$container->get('validator')->validate($task);
    $this->assertCount(1, $error);
    }

    public function testCreatedAt()
    {
        // fonctionnel
        $task = new Task();
        $date = new DateTime('Now');
        $task->setCreatedAt($date);
        $this->assertSame($date, $task->getCreatedAt());
    }

    public function testId()
    {
        // fonctionnel
        $task = new Task();
        $this->assertNull($task->getId());
    }

  
    public function testTitle()
    {
        // fonctionnel
        $task = new Task();
        $task->setTitle('Test du titre');
        $this->assertSame($task->getTitle(), 'Test du titre');
    }


    public function testContent()
    {
        // fonctionnel
        $task = new Task();
        $task->setContent('Test du contenu');
        $this->assertSame($task->getContent(), 'Test du contenu');
    }

   
    public function testIsDone()
    {
        // fonctionnel
        $task = new Task();
        $task->toggle(true);
        $this->assertEquals($task->isDone(), true);
    }

    public function testUser()
    {
        // fonctionnel
        $task = new Task();
        $task->setUsers(new User());
        $this->assertInstanceOf(User::class, $task->getUsers());
    }

}