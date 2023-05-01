<?php

namespace App\Action\Contact;

use App\Domain\Contact\Service\ContactListerService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ContactListerAction
{
    private $contactService;

    public function __construct(ContactListerService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupérer tous les contacts
        $contacts = $this->contactService->listerContacts();

        // Vérification de la récupération des contacts
        if ($contacts === false) {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500)
                ->withJson(['message' => "Une erreur est survenue lors de la récupération des contacts."]);
        }

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($contacts));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
