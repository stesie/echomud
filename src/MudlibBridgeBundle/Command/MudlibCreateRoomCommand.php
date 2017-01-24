<?php

namespace MudlibBridgeBundle\Command;

use stesie\mudlib\Command\CreateRoomCommand;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MudlibCreateRoomCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mudlib:create-room')
            ->setDescription('Create a new room')
            //->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            //->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = new CreateRoomCommand($this->getContainer()->get('mudlib_bridge.event_store'));
        $room = $command->run();

        $output->writeln('Room created, id=' . $room->getId());

        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }

}
