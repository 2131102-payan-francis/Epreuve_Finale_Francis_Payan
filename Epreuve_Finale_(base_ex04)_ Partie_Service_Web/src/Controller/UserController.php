<?php

namespace App\Controller;

use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Factory\LoggerFactory;
use Slim\Psr7\Response;

class UserController
{
    private $userRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(UserRepository $userRepository, LoggerFactory $loggerFactory)
    {
        $this->userRepository = $userRepository;

        $this->logger = $loggerFactory
        // Le nom de fichier de log utilisé
        ->addFileHandler('hello.log')
        // On peut passer du texte en parametre ici qui identifiera
        // la ligne de log, sinon un UUID sera utilisé
        ->createLogger('MessagePourDeboguer');
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        $this->logger->info($data['password']);

        // On récupère l'utilisateur en fonction du code d'usager et du mot de passe fournis dans la requête :
        $user = $this->userRepository->login($data['username'] ?? '', $data['password'] ?? '');  
        $this->logger->info($user);

        if (empty($user)) {
            $response->getBody()->write(json_encode(['message' => 'Code d\'usager ou mot de passe incorrect.']));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }

        $apiKey = $this->userRepository->generateApiKey($user['id']);
        $response->getBody()->write(json_encode(['api_key' => $apiKey])); // On retourne la clé API générée pour l'utilisateur connecté dans la réponse : 

        return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
    }
}
