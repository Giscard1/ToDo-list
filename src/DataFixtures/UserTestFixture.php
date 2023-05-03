<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserTestFixture extends Fixture
{
    public const User_REF_ADMIN = 'user-ref-admin';
    public const User_REF_USER = 'user-ref-user';
    public const User_REF_USER_2 = 'user-ref-user-2';
    public const User_REF_ANONYM = 'user-ref-anonym';
                    
    private $userPasswordHasher; 

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $userAdmin = new User();
        $userAdmin->setUsername('admin');
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin,"123456"));
        $userAdmin->setEmail('admin@gmail.com');
        $userAdmin->setRoles(['ROLE_ADMIN']);


        $user = new User();
        $user->setUsername('user');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "123456"));
        $user->setEmail('user@gmail.com');
        $user->setRoles(['ROLE_USER']);

        $user2 = new User();
        $user2->setUsername('user2');
        $user2->setPassword($this->userPasswordHasher->hashPassword($user2, "123456"));
        $user2->setEmail('user2@gmail.com');
        $user2->setRoles(['ROLE_USER']);
        

        $userAnonym = new User();
        $userAnonym->setUsername('anonym');
        $userAnonym->setPassword($this->userPasswordHasher->hashPassword($userAnonym, "123456"));
        $userAnonym->setEmail('anonym@gmail.com');
        $userAnonym->setRoles(['ROLE_ANONYME']);

        $manager->persist($userAdmin);
        $manager->persist($user);
        $manager->persist($user2);
        $manager->persist($userAnonym);

        /*$this->addReference(self::User_REF_ADMIN, $userAdmin);
        $this->addReference(self::User_REF_USER, $user);
        $this->addReference(self::User_REF_USER_2, $user2);
        $this->addReference(self::User_REF_ANONYM, $userAnonym);
        */
        $this->addReference(self::User_REF_ADMIN, $userAdmin);
        $this->addReference(self::User_REF_USER_2, $user2);
        $this->addReference(self::User_REF_ANONYM, $userAnonym);
        $this->addReference(self::User_REF_USER, $user);
       
        $manager->flush();
    }
}
