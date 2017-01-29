<?php

namespace AppBundle\Controller\AlexaRequest;

use AppBundle\Tools\AlexaResponseBuilder;
use AppBundle\ValueObject\AlexaSessionInfo;
use Symfony\Component\HttpFoundation\Response;

class LaunchRequest
{
    public function run(AlexaSessionInfo $sessionInfo): Response
    {
        return AlexaResponseBuilder::create()
            ->setOutputSpeech('Hallo Spieler')
            ->toResponse();
    }
}