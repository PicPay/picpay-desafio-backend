<?php

namespace App\DataFixtures;

use App\Entity\Customer;
use App\Entity\Wallet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        /** Common **/
        $john = (new Customer())->setName('John Doe')
            ->setType(Customer::COMMON)
            ->setEmail('john@example.com')
            ->setDocument('111.111.111-11');
        $manager->persist($john);

        $wallet = (new Wallet())->setCustomer($john)->setValue(1000.0);
        $manager->persist($wallet);

        $bob = (new Customer())->setName('Bob Doe')
            ->setType(Customer::COMMON)
            ->setEmail('bob@example.com')
            ->setDocument('222.222.222-22');
        $manager->persist($bob);

        $wallet = (new Wallet())->setCustomer($bob)->setValue(1000.0);
        $manager->persist($wallet);

        $alice = (new Customer())->setName('Alice Doe')
            ->setType(Customer::COMMON)
            ->setEmail('alice@example.com')
            ->setDocument('333.333.333-33');
        $manager->persist($alice);
        $wallet = (new Wallet())->setCustomer($alice)->setValue(1000.0);
        $manager->persist($wallet);

        /** Store */
        $apple = (new Customer())->setName('Apple Store')
            ->setType(Customer::STORE)
            ->setEmail('apple@example.com')
            ->setDocument('12.345.543/1000-34');
        $manager->persist($apple);
        $wallet = (new Wallet())->setCustomer($apple)->setValue(1000.0);
        $manager->persist($wallet);

        $banana = (new Customer())->setName('Banana Store')
            ->setType(Customer::STORE)
            ->setEmail('banana@example.com')
            ->setDocument('12.444.543/1000-44');
        $manager->persist($banana);
        $wallet = (new Wallet())->setCustomer($banana)->setValue(1000.0);
        $manager->persist($wallet);

        $orange = (new Customer())->setName('Orange Store')
            ->setType(Customer::STORE)
            ->setEmail('orange@example.com')
            ->setDocument('10.222.543/1000-22');
        $manager->persist($orange);
        $wallet = (new Wallet())->setCustomer($orange)->setValue(1000.0);
        $manager->persist($wallet);

        $manager->flush();
    }
}
