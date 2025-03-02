<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $products = [
            ['name' => 'Poule pondeuse', 'description' => 'Poule pondeuse productive', 'price' => 14.50],
            ['name' => 'Tracteur Porsche', 'description' => 'Tracteur agricole robuste et fiable de la série Porsche', 'price' => 33000.00],
            ['name' => 'Poules Araucana', 'description' => 'Poule Araucana célèbre pour ses œufs bleu-vert uniques.', 'price' => 25.10],
            ['name' => 'Oie cendrée', 'description' => 'Oie cendrée rustique, parfaite pour l’élevage et l’entretien des espaces.', 'price' => 45],
            ['name' => 'Canard colvert', 'description' => 'Le Canard colvert, col-vert, ou Canard malard au Canada, est une espèce d’oiseaux de l’ordre des Ansériformes, de la famille des Anatidés et de la sous-famille des Anatinés.', 'price' => 30],
        ];

        foreach ($products as $data) {
            $product = new Product();
            $product->setName($data['name']);
            $product->setDescription($data['description']);
            $product->setPrice($data['price']);

            $manager->persist($product);
        }

        $manager->flush();
    }
}
