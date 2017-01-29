<?php

namespace AppBundle\ValueObject;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AlexaSessionInfo
{
    /**
     * @var string
     */
    private $sessionId;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var bool
     */
    private $new;


    /**
     * @param \stdClass $serviceRequest Service Request Payload as decoded JSON object
     * @return AlexaSessionInfo
     * @throws \InvalidArgumentException
     */
    public static function createFromServiceRequest($serviceRequest): AlexaSessionInfo
    {
        self::checkServiceRequestForRequiredProperties($serviceRequest);

        $inst = new static();
        $inst->sessionId = $serviceRequest->session->sessionId;
        $inst->userId = $serviceRequest->session->user->userId;
        $inst->new = $serviceRequest->session->new;

        return $inst;
    }

    /**
     * @param \stdClass $serviceRequest Service Request Payload as decoded JSON object
     * @throws \InvalidArgumentException
     */
    private static function checkServiceRequestForRequiredProperties($serviceRequest)
    {
        if (!isset($serviceRequest->session)) {
            throw new \InvalidArgumentException('ServiceRequest lacks session property');
        }

        if (!isset($serviceRequest->session->sessionId)) {
            throw new \InvalidArgumentException('ServiceRequest lacks session->sessionId property');
        }

        if (!isset($serviceRequest->session->user)) {
            throw new \InvalidArgumentException('ServiceRequest lacks session->user property');
        }

        if (!isset($serviceRequest->session->user->userId)) {
            throw new \InvalidArgumentException('ServiceRequest lacks session->user->userId property');
        }

        if (!isset($serviceRequest->session->new)) {
            throw new \InvalidArgumentException('ServiceRequest lacks session->new property');
        }
    }

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function setUserId(string $userId)
    {
        $this->userId = $userId;
    }

    public function isNew(): bool
    {
        return $this->new;
    }

    public function setNew(bool $new)
    {
        $this->new = $new;
    }
}