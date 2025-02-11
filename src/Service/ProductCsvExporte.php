<?php

namespace App\Service;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductCsvExporte
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function export(): StreamedResponse
    {
        $products = $this->productRepository->findAll();

        $response = new StreamedResponse(function () use ($products) {
            $output = fopen('php://output', 'w');

            fputcsv($output, ['Name', 'Description', 'Price']);

            foreach ($products as $product) {
                fputcsv($output, [
                    $product->getName(),
                    $product->getDescription(),
                    $product->getPrice(),
                ]);
            }

            fclose($output);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="products.csv"');

        return $response;
    }
}
