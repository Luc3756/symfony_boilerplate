<?php

namespace App\Tests\Service;

use App\Service\ProductCsvExporte;
use App\Repository\ProductRepository;
use App\Entity\Product;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProductCsvExporteTest extends TestCase
{
    public function testExport()
    {
        $productRepositoryMock = $this->createMock(ProductRepository::class);

        $product1 = $this->createMock(Product::class);
        $product1->method('getName')->willReturn('Product 1');
        $product1->method('getDescription')->willReturn('Description 1');
        $product1->method('getPrice')->willReturn('10.99');

        $product2 = $this->createMock(Product::class);
        $product2->method('getName')->willReturn('Product 2');
        $product2->method('getDescription')->willReturn('Description 2');
        $product2->method('getPrice')->willReturn('19.99');

        $productRepositoryMock->method('findAll')->willReturn([$product1, $product2]);

        $csvExporter = new ProductCsvExporte($productRepositoryMock);

        $response = $csvExporter->export();
        $this->assertInstanceOf(StreamedResponse::class, $response);

        ob_start();
        $response->sendContent();
        $output = ob_get_clean();

        $expectedCsv = "Name,Description,Price\n\"Product 1\",\"Description 1\",10.99\n\"Product 2\",\"Description 2\",19.99\n";

        $this->assertEquals($expectedCsv, $output);
    }
}
