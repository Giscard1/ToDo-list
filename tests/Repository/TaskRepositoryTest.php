<?php

namespace App\Tests\Repository;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Persistence\ManagerRegistry;

class TaskRepositoryTest extends KernelTestCase
{
    public function testAddTask()
    {
        self::bootKernel();

        $taskRepository = new TaskRepository(static::getContainer()->get(ManagerRegistry::class));

        $task = new Task();
        $task->setTitle('Test Task');
        $task->setContent('This is a test task.');

        $taskRepository->add($task, true);

        $this->assertNotNull($task->getId());
    }

    public function testRemoveTask(): void
    {
        self::bootKernel();

        $taskRepository = new TaskRepository(static::getContainer()->get(ManagerRegistry::class));

        $task = $taskRepository->findOneBy(['title' => 'title-admin-0']);
        $this->assertInstanceOf(Task::class, $task);

        $taskRepository->remove($task, true);

        $this->assertNull($taskRepository->findOneBy(['title' => 'title-admin-0']));
    }
}