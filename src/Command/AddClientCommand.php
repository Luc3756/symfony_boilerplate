<?php
namespace App\Command;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

#[AsCommand(name: 'app:add-client', description: 'Ajoute un nouveau client')]
class AddClientCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $helper = $this->getHelper('question');

        $questions = [
            'firstname' => new Question('Prénom du client : '),
            'lastname' => new Question('Nom du client : '),
            'email' => new Question('Email du client : '),
            'phoneNumber' => new Question('Numéro de téléphone du client : '),
            'address' => new Question("Adresse du client : "),
        ];

        $client = new Client();
        foreach ($questions as $property => $question) {
            $value = $helper->ask($input, $output, $question);
            if ($property === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $output->writeln('<error>Email invalide.</error>');
                return Command::FAILURE;
            }
            $setter = 'set' . ucfirst($property);
            $client->$setter($value);
        }

        $client->setCreatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        $output->writeln('<info>Client ajouté avec succès !</info>');
        return Command::SUCCESS;
    }
}