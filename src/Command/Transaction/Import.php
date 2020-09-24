<?php

namespace App\Command\Transaction;

use App\Entity\Property;
use App\Entity\Transaction;
use App\EntityMapper\Property as PropertyMapper;
use App\EntityMapper\Transaction as TransactionMapper;
use App\Repository\PropertyRepository;
use App\Repository\TransactionRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class Import extends Command
{
    const BATCH_SIZE = 100;

    const COL_POSTCODE = 3;
    const COL_HOUSE_NUMBER = 7;
    const COL_UNIT_NAME = 8;

    protected static $defaultName = "transaction:import";

    protected $entityManager;

    protected $propertyMapper;

    protected $propertyRepository;

    protected $transactionMapper;

    protected $transactionRepository;

    public function __construct(
        PropertyRepository $propertyRepository,
        TransactionRepository $transactionRepository,
        PropertyMapper $propertyMapper,
        TransactionMapper $transactionMapper,
        EntityManagerInterface $entityManager
    )
    {
        parent::__construct();

        $this->propertyRepository = $propertyRepository;
        $this->transactionRepository = $transactionRepository;
        $this->propertyMapper = $propertyMapper;
        $this->transactionMapper = $transactionMapper;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->addOption(
                'path',
                null,
                InputOption::VALUE_REQUIRED,
                'Path to the directories containing the import file(s)'
            )
            ->setDescription('Import transaction data into the database')
            ->setHelp('This command allows new transaction data to be imported into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entityManager->getConnection()->getConfiguration()->setSQLLogger(null);

        $finder = new Finder();
        $finder->files()->in($input->getOption("path"))->name("*.txt");

        if (!$finder->hasResults()) {
            $output->writeln("Could not find any files to process");
            return Command::FAILURE;
        }

        $this->deleteAllRowsForEntity(Transaction::class);
        $this->deleteAllRowsForEntity(Property::class);

        foreach ($finder as $fileInfo) {
            $output->writeln("Processing " . $fileInfo->getRealPath());

            $csvReader = Reader::createFromPath($fileInfo->getRealPath(), "r");
            $rowIndex = 1;

            foreach ($csvReader as $record) {
                $property = $this->propertyMapper->map(new Property(), $record);

                $existingProperty = $this->propertyRepository->find($property->getId());

                if (null === $existingProperty) {
                    $this->entityManager->persist($property);
                } else {
                    $property = $existingProperty;
                }

                $transaction = $this->transactionMapper->map(new Transaction(), $record);
                $transaction->setProperty($property);

                $this->entityManager->persist($transaction);

                if (0 === ($rowIndex++ % self::BATCH_SIZE)) {
                    $this->entityManager->flush();
                    $this->entityManager->clear();

                    $output->writeln("Batch " . ($rowIndex / self::BATCH_SIZE) . " processed");
                    $output->writeln("Memory usage: " . (memory_get_usage(true) / (1024 * 1024)), OutputInterface::VERBOSITY_VERBOSE);
                }
            }

            $this->entityManager->flush();
            $this->entityManager->clear();
        }

        return Command::SUCCESS;
    }

    protected function deleteAllRowsForEntity(string $entity)
    {
        $query = $this->entityManager->createQuery("delete from " . $entity);
        $query->execute();
    }
}