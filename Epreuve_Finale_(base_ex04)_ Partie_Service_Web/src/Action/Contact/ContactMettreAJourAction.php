<?php

namespace App\Action\Contact;

use App\Domain\Contact\Service\ContactMettreAJourService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ContactMettreAJourAction
{
    private $contactService;

    public function __construct(ContactMettreAJourService $contactService)
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

        // Récupération des données du corps de la requête
        $data = (array)$request->getParsedBody();

        // Vérification des données fournies
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email']) || empty($data['message'])) {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(400)
                ->withJson(['message' => "Les données fournies sont invalides ou manquantes."]);
        }

        // Mettre à jour le contact
        $contactMiseAJour = $this->contactService->mettreAJourContact($id, $data);

        // Vérification de la mise à jour du contact
        if ($contactMiseAJour === false) {
            return $response
                ->withHeader('Content-Type', 'application/json')
                ->withStatus(500)
                ->withJson(['message' => "Une erreur est survenue lors de la mise à jour du contact."]);
        }

        // Construit la réponse HTTP
        $response->getBody()->write((string)json_encode($contactMiseAJour));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}
