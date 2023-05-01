<?php

namespace App\Domain\Contact\Service;

use App\Domain\Contact\Repository\ContactRepository;

class ContactAjouterService
{
    private $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    public function ajouterContact(array $data): array
    {
        // Insérer le contact
        $nouveauContact = $this->repository->insertContact($data);

        // Retourner le contact ajouté
        return $nouveauContact;
    }
}
