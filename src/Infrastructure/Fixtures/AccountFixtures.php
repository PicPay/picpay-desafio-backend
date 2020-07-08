<?php

declare(strict_types=1);

namespace App\Infrastructure\Fixtures;

use App\Infrastructure\ORM\Entity\Account;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use function mt_rand;

class AccountFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $faker = new \Faker\Generator();
            $faker->addProvider(
                new \Faker\Provider\pt_BR\Person($faker)
            );
            $faker->addProvider(
                new \Faker\Provider\pt_BR\Company($faker)
            );
            $faker->addProvider(
                new \Faker\Provider\Internet($faker)
            );

            $documentNumber = $faker->cpf(false);
            $documentType = 'cpf';
            if (mt_rand(0, 100) < 30) {
                $documentNumber = $faker->cnpj(false);
                $documentType = 'cnpj';
            }

            $account = new Account();
            $account->forgeUuid();
            $account->setFirstName($faker->firstName);
            $account->setLastName($faker->lastName);
            $account->setDocumentNumber($documentNumber);
            $account->setDocumentType($documentType);
            $account->setEmail($faker->email);
            $account->setPassword($faker->password);
            $account->setBalance(mt_rand(0, 99999));

            $manager->persist($account);
        }

        $manager->flush();
    }
}
