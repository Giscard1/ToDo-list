<?php

namespace App\Tests\Entity;
 

use App\Entity\Task;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @covers Class UserTest
 * @package App\Tests\Entity
 */
class UserTest extends KernelTestCase
{


    public function testValidUser()
    {
        // fonctionnel

        $user = new User();
        $user->setEmail('user@email.fr');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('password');
        $user->setUsername('username');

        self::bootKernel();
        $error = self::$container->get('validator')->validate($user);
        $this->assertCount(0, $error);
    }

    public function testInvalidUser()
    {
        // fonctionnel

        $user = new User();
        $user->setEmail('user@email.fr');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('password');
        $user->setUsername('');

        self::bootKernel();
        $error = self::$container->get('validator')->validate($user);
        $this->assertCount(1, $error);
    }


    public function testUser()
    {
        // fonctionnel


        $task = new Task();
        $user = new User();

        $this->assertNull($user->getId());

        $user->setUsername('username');

        $this->assertSame('username', $user->getUsername());

        $user->setPassword('password');

        $this->assertSame('password', $user->getPassword());

        $user->setEmail('user@email.fr');

        $this->assertSame('user@email.fr', $user->getEmail());

        $user->setRoles(['ROLE_USER']);

        $this->assertSame(['ROLE_USER'], $user->getRoles());

        $task->setContent('test content');

        $task->setTitle('test titre');

        $task->setUsers($user);

        $this->assertSame($task->getUsers(), $user);

        $this->assertNotEmpty($task->getUsers());

        $this->assertNull($user->getSalt());
    }
}