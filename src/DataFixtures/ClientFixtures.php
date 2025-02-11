<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $clients = [
            [
                'firstname' => 'Jean',
                'lastname' => 'Dupont',
                'email' => 'jean.dupont@example.com',
                'phoneNumber' => '0612345678',
                'address' => '10 Rue de Paris, 75001 Paris',
            ],
            [
                'firstname' => 'Sophie',
                'lastname' => 'Martin',
                'email' => 'sophie.martin@example.com',
                'phoneNumber' => '0623456789',
                'address' => '25 Avenue des Champs, 75008 Paris',
            ],
            [
                'firstname' => 'Luc',
                'lastname' => 'Bernard',
                'email' => 'luc.bernard@example.com',
                'phoneNumber' => '0634567890',
                'address' => '5 Boulevard Haussmann, 75009 Paris',
            ],
        ];

        foreach ($clients as $data) {
            $client = new Client();
            $client->setFirstname($data['firstname']);
            $client->setLastname($data['lastname']);
            $client->setEmail($data['email']);
            $client->setPhoneNumber($data['phoneNumber']);
            $client->setAddress($data['address']);
            $client->setCreatedAt(new \DateTimeImmutable()); // Date de création automatique

            $manager->persist($client);
        }

        $manager->flush();
    }
}
