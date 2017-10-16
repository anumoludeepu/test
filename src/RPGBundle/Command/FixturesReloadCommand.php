<?php

namespace RPGBundle\Command;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class FixturesReloadCommand extends Command
{
    protected function configure()
    {
        $this->setName('app:fixtures:reload')
            ->setDescription('Drop/Create Database and load Fixtures ....')
            ->setHelp('This command allows you to load dummy data by recreating database and loading fixtures...');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $application = $this->getApplication();
        $application->setAutoExit(false);

        $output->writeln([
                             '===================================================',
                             '*********        Dropping DataBase        *********',
                             '===================================================',
                             '',
                         ]);

        $options = array('command' => 'doctrine:database:drop', "--force" => true);
        $application->run(new ArrayInput($options));


        $output->writeln([
                             '===================================================',
                             '*********        Creating DataBase        *********',
                             '===================================================',
                             '',
                         ]);

        $options = array('command' => 'doctrine:database:create', "--if-not-exists" => true);
        $application->run(new ArrayInput($options));

        $output->writeln([
                             '===================================================',
                             '*********         Updating Schema         *********',
                             '===================================================',
                             '',
                         ]);

        //Create de Schema
        $options = array('command' => 'doctrine:schema:update', "--force" => true);
        $application->run(new ArrayInput($options));

        $output->writeln([
                             '===================================================',
                             '*********          Load Fixtures          *********',
                             '===================================================',
                             '',
                         ]);

        //Loading Fixtures
        $options = array('command' => 'doctrine:fixtures:load', "--no-interaction" => true);
        $application->run(new ArrayInput($options));

    }
}