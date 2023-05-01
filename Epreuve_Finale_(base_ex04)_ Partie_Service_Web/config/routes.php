<?php

use Slim\App;
use Slim\Routing\RouteCollectorProxy; 
use App\Controller\UserController;

header("Access-Control-Allow-Origin: *"); // autoriser l'accès à l'API depuis n'importe quelle origine ( '*' ) 
header("Access-Control-Allow-Headers: Content-Type, Authorization"); // autoriser les en-têtes Content-Type et Authorization 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE"); // autoriser les méthodes GET, POST, PUT, DELETE 


return function (App $app) {

    // Afficher la page d'accueil (Home) de l'application web (API) : http://127.0.0.1/Epreuve_Finale_(base_ex04)/
    $app->get('/', \App\Action\HomeAction::class);

    // Documentation de l'api
    $app->get('/docs', \App\Action\Docs\SwaggerUiAction::class);

    // Lister tous les contacts : http://127.0.0.1/Epreuve_Finale_(base_ex04)/contacts/lister 
    $app->get('/contacts/lister', \App\Action\Contact\ContactListerAction::class)->add(\App\Middleware\ApiAuthMiddleware::class);
    
    // Récupérer un contact par ID : http://127.0.0.1/Epreuve_Finale_(base_ex04)/contacts/recuperer/1
    $app->get('/contacts/recuperer/{id}', \App\Action\Contact\ContactRecupererAction::class)->add(\App\Middleware\ApiAuthMiddleware::class);

    // Ajouter un contact
    $app->post('/contacts/ajouter', \App\Action\Contact\ContactAjouterAction::class)->add(\App\Middleware\ApiAuthMiddleware::class);

    // Supprimer un contact
    $app->delete('/contacts/supprimer/{id}', \App\Action\Contact\ContactSupprimerAction::class)->add(\App\Middleware\ApiAuthMiddleware::class);

    // Mettre à jour un contact
    $app->put('/contacts/mettreajour/{id}', \App\Action\Contact\ContactMettreAJourAction::class)->add(\App\Middleware\ApiAuthMiddleware::class);

    // Route pour se connecter et générer une clé API pour les utilisateurs valides
    $app->post('/login', UserController::class);
};