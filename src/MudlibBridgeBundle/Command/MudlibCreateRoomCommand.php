<?php

namespace MudlibBridgeBundle\Command;

use stesie\mudlib\Command\CreateRoomCommand;
use stesie\mudlib\ValueObject\Area;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MudlibCreateRoomCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('mudlib:create-room')
            ->setDescription('Create a new room')
            ->addArgument('area', InputArgument::REQUIRED, 'Area, where the new room shall be located (like 3x3+0+0)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        list($w, $h, $x, $y) = [null, null, null, null];

        if (sscanf($input->getArgument('area'), '%ux%u%d%d', $w, $h, $x, $y) != 4) {
            $output->writeln('Failed to parse area format');
        }

        $command = new CreateRoomCommand($this->getContainer()->get('mudlib_bridge.event_store'));
        $room = $command->run(Area::createFromCoordinates($x, $y, $w, $h));

        $output->writeln('Room created, id=' . $room->getId());
        $this->getContainer()->get('doctrine.orm.entity_manager')->flush();
    }

}
