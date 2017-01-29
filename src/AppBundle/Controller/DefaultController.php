<?php

namespace AppBundle\Controller;

use AppBundle\Controller\AlexaRequest\LaunchRequest;
use AppBundle\ValueObject\AlexaSessionInfo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $payload = json_decode($request->getContent());

        if ($payload === null) {
            throw new BadRequestHttpException('Unable to decode JSON Payload');
        }

        if (!isset($payload->request) || !isset($payload->request->type)) {
            throw new BadRequestHttpException('Invalid JSON Payload, payload->request->type not defined');
        }

        switch ($payload->request->type) {
            case 'LaunchRequest':
                $handler = new LaunchRequest();
                break;

            case 'IntentRequest':
                throw new \RuntimeException('Not yet implemented');

            default:
                throw new BadRequestHttpException('Unsupported payload->request->type');
        }

        return $handler->run(AlexaSessionInfo::createFromServiceRequest($payload));
    }
}
