<?php

namespace App\Action\Contact;

use App\Domain\Contact\Service\ContactSupprimerService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ContactSupprimerAction
{
    private $contactService;

    public function __construct(ContactSupprimerService $contactService)
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

        // Supprimer le contact
        $contactSupprime = $this->contactService->supprimerContact($id);

        // Vérification de la suppression du contact
        if ($contactSupprime === false) {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(404)
                ->withJson(['message' => "Le contact avec l'ID $id n'a pas été trouvé et n'a pas pu être supprimé."]);
        }

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode(['succes' => "Contact supprimé"]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
