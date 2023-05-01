<?php

namespace App\Action\Contact;

use App\Domain\Contact\Service\ContactRecupererService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ContactRecupererAction
{
    private $contactService;

    public function __construct(ContactRecupererService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response,
        array $args
    ): ResponseInterface {

        // Récupération de l'ID du contact
        $id = $args['id'];

        // Récupérer le contact par ID
        $contact = $this->contactService->recupererContact($id);

        // Vérification de l'existence du contact
        if ($contact === null) {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404)
                ->withJson(['message' => "Le contact avec l'ID $id n'a pas été trouvé."]);
        }

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($contact));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
