<?php

namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\Persistence\ManagerRegistry;

class UserRepositoryTest extends KernelTestCase
{
    public function testAddUser()
    {
        self::bootKernel();

        $userRepository = new UserRepository(static::getContainer()->get(ManagerRegistry::class));

        $user = new User();
        $user->setUsername('Test_username');
        $user->setPassword('Test_password');
        $user->setEmail('testEmail@gmail.fr');
        $user->setRoles(["ROLE_USER"]);

        $userRepository->add($user, true);

        $this->assertNotNull($user->getId());
    }

    public function testRemoveUser(): void
    {
        self::bootKernel();

        $userRepository = new UserRepository(static::getContainer()->get(ManagerRegistry::class));

        $user = $userRepository->findOneBy(['username' => 'user2']);
        $this->assertInstanceOf(User::class, $user);

        $userRepository->remove($user, true);

        $this->assertNull($userRepository->findOneBy(['username' => 'user2']));
    }
}