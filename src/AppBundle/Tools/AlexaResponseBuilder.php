<?php

namespace AppBundle\Tools;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AlexaResponseBuilder
{
    /**
     * @var string
     */
    private $outputSpeech;

    /**
     * @var string
     */
    private $repromptSpeech;

    /**
     * @var bool
     */
    private $shouldEndSession = false;

    /**
     * Factory method for chainability.
     *
     * @return AlexaResponseBuilder
     */
    public static function create(): AlexaResponseBuilder
    {
        return new self();
    }

    public function toResponse(): Response
    {
        return JsonResponse::create($this->buildServiceResponse());
    }

    private function buildServiceResponse(): \stdClass
    {
        $jsonObj = new \stdClass();
        $jsonObj->version = '1.0';
        $jsonObj->response = $this->buildResponseObject();
        $jsonObj->sessionAttributes = new \stdClass();

        return $jsonObj;
    }

    private function buildResponseObject(): \stdClass
    {
        $jsonObj = new \stdClass();
        $jsonObj->outputSpeech = $this->outputSpeech($this->outputSpeech);

        if ($this->repromptSpeech) {
            $jsonObj->reprompt = new \stdClass();
            $jsonObj->reprompt->outputSpeech = $this->outputSpeech($this->repromptSpeech);
        }

        $jsonObj->shouldEndSession = $this->shouldEndSession;

        return $jsonObj;
    }

    private function outputSpeech(string $speech): \stdClass
    {
        $jsonObj = new \stdClass();
        $jsonObj->type = 'SSML';
        $jsonObj->ssml = sprintf('<speak> %s </speak>', $speech);

        return $jsonObj;
    }

    /**
     * @param string $outputSpeech
     * @return AlexaResponseBuilder
     */
    public function setOutputSpeech(string $outputSpeech): AlexaResponseBuilder
    {
        $this->outputSpeech = $outputSpeech;
        return $this;
    }

    /**
     * @param string $repromptSpeech
     * @return AlexaResponseBuilder
     */
    public function setRepromptSpeech(string $repromptSpeech): AlexaResponseBuilder
    {
        $this->repromptSpeech = $repromptSpeech;
        return $this;
    }

    /**
     * @param bool $shouldEndSession
     * @return AlexaResponseBuilder
     */
    public function setShouldEndSession(bool $shouldEndSession): AlexaResponseBuilder
    {
        $this->shouldEndSession = $shouldEndSession;
        return $this;
    }
}