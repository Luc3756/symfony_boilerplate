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
            ['name' => 'Ordinateur Portable', 'description' => 'Un ordinateur performant pour le travail et le jeu.', 'price' => 999.99],
            ['name' => 'Smartphone', 'description' => 'Un smartphone avec un écran OLED et une caméra 108MP.', 'price' => 699.99],
            ['name' => 'Casque Audio', 'description' => 'Un casque sans fil avec réduction de bruit.', 'price' => 199.99],
            ['name' => 'Montre Connectée', 'description' => 'Suivi de la santé et notifications en temps réel.', 'price' => 249.99],
            ['name' => 'Clavier Mécanique', 'description' => 'Un clavier RGB avec switches ultra-réactifs.', 'price' => 129.99],
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
