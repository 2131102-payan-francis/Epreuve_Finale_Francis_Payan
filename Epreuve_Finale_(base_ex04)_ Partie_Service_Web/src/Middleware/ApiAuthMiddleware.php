<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Domain\User\UserRepository;

final class ApiAuthMiddleware implements MiddlewareInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function process(
        ServerRequestInterface $request, 
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $token = $request->getHeaderLine('Autorisation');
        $apiKey = str_replace('Bearer ', '', $token);

        if ($this->userRepository->isValidApiKey($apiKey)) {
            $response = new \Slim\Psr7\Response();
            $response->getBody()->write('Non autorisé');
            return $response->withStatus(401);
        }

        return $handler->handle($request);
    }
}
