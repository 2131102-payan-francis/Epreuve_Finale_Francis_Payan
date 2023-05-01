<?php

namespace App\Action\Contact;

use App\Domain\Contact\Service\ContactAjouterService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ContactAjouterAction
{
    private $contactService;

    public function __construct(ContactAjouterService $contactService)
    {
        $this->contactService = $contactService;
    }

    public function __invoke(
        ServerRequestInterface $request, 
        ResponseInterface $response
    ): ResponseInterface {

        // Récupération des données du corps de la requête
        $data = (array)$request->getParsedBody();

        // Vérification des données fournies
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email']) || empty($data['message'])) {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400)
                ->withJson(['message' => "Les données fournies sont invalides ou manquantes."]);
        }

        // Ajouter le contact
        $nouveauContact = $this->contactService->ajouterContact($data);

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($nouveauContact));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    }
}
