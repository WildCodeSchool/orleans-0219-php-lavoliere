<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setFirstname('Vincent');
        $admin->setLastname('Lecomte-Fousset');
        $admin->setEmail('admin@gmail.com');
        $admin->setPhone('0660391318');
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'voliere'
        ));

        $manager->persist($admin);

        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->setFirstname('Georges');
        $user->setLastname('Wisley');
        $user->setEmail('user@gmail.com');
        $user->setPhone('0739545415');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'nimbus2000'
        ));

        $manager->persist($user);

        $manager->flush();
    }
}
