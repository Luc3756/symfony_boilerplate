<?php

namespace App\Command;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Filesystem\Filesystem;
use League\Csv\Reader; 

class ImportCsvCommand extends Command
{
    private $entityManager;
    private $productRepository;
    private $filesystem;

    public function __construct(EntityManagerInterface $entityManager, ProductRepository $productRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->productRepository = $productRepository;
        $this->filesystem = new Filesystem();
    }

    protected function configure()
    {
        $this
            ->setName('app:import-csv')
            ->setDescription('Import products from a CSV file.')
            ->addArgument('file', InputArgument::REQUIRED, 'Path to the CSV file')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filePath = $input->getArgument('file');

        if (!$this->filesystem->exists($filePath)) {
            $output->writeln('<error>File does not exist!</error>');
            return Command::FAILURE;
        }

        try {
            $csv = Reader::createFromPath($filePath, 'r');
            $csv->setHeaderOffset(0); 
            $records = $csv->getRecords(); 

            foreach ($records as $record) {
                $product = new Product();
                $product->setName($record['Name']);
                $product->setDescription($record['Description']);
                $product->setPrice((float) $record['Price']);

                $this->entityManager->persist($product);
            }

            $this->entityManager->flush();

            $output->writeln('<info>Products have been imported successfully!</info>');
            return Command::SUCCESS; 

        } catch (\Exception $e) {
            $output->writeln('<error>Error while processing the CSV file: '.$e->getMessage().'</error>');
            return Command::FAILURE;
        }
    }
}
