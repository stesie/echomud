<?php

namespace MudlibBridgeBundle\Command;

use stesie\mudlib\Command\CreateMazeTileCommand;
use stesie\mudlib\ValueObject\Point;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MudlibCreateMazeTileCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mudlib:create-maze-tile')
            ->setDescription('Create a new maze tile')
            ->addArgument('point', InputArgument::REQUIRED, 'Point, where the maze tile shall be located (like 3,3)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($x, $y) = [null, null];

        if (sscanf($input->getArgument('point'), '%d,%d', $x, $y) != 2) {
            $output->writeln('Failed to parse point format');
        }

        $command = new CreateMazeTileCommand($this->getContainer()->get('mudlib_bridge.event_store'));
        $room = $command->run(Point::create($x, $y));

        $output->writeln('Maze tile created, id=' . $room->getId());
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }
}
