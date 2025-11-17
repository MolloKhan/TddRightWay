<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AsCommand(
    'app:debug-db-url',
    'Displays the database URL from environment variables'
)]
class DebugDbUrlCommand extends Command
{
    public function __construct(
        #[Autowire('%env(DATABASE_URL)%')]
        private readonly string $dbUrl,
    )
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln($this->dbUrl);

        return Command::SUCCESS;
    }
}
