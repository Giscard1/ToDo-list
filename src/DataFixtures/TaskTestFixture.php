<?php

namespace App\DataFixtures;

use App\Entity\Task;
use DateTime;
use App\DataFixtures\UserTestFixture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TaskTestFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $admin = $this->getReference(UserTestFixture::User_REF_ADMIN);
        $user = $this->getReference(UserTestFixture::User_REF_USER);
        $user2 = $this->getReference(UserTestFixture::User_REF_USER_2);
        $anonym = $this->getReference(UserTestFixture::User_REF_ANONYM);
        $tabUsers = [$admin,$user,$user2,$anonym];

            for ($i = 0; $i < 2; $i++) {
                $task = new Task();
                if ($i == 0) {
                $task->isDone(0);
                }
                $task->setTitle('title-'.'admin-'.$i);
                $task->setContent('Content-'.$i);
                $task->setUsers($admin);
                $task->isDone(1);
                $manager->persist($task);
            }

            for ($i = 0; $i < 2; $i++) {
                $task = new Task();
                if ($i == 0) {
                $task->isDone(0);
                }
                $task->setTitle('title-'.'user-'.$i);
                $task->setContent('Content-'.$i);
                $task->setUsers($user);
                $task->isDone(1);
                $manager->persist($task);
            }

            for ($i = 0; $i < 2; $i++) {
                $task = new Task();
                if ($i == 0) {
                $task->isDone(0);
                }
                $task->setTitle('title-'.'user-2-'.$i);
                $task->setContent('Content'.$i);
                $task->setUsers($user2);
                $task->isDone(1);
                $manager->persist($task);
            }

            for ($i = 0; $i < 2; $i++) {
                $task = new Task();
                if ($i == 0) {
                $task->isDone(0);
                }
                $task->setTitle('title-'.'anonym-'.$i);
                $task->setContent('Content-'.$i);
                $task->setUsers($anonym);
                $task->isDone(1);
                $manager->persist($task);
            }
        
        
      
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserTestFixture::class,
        ];
    }
}
