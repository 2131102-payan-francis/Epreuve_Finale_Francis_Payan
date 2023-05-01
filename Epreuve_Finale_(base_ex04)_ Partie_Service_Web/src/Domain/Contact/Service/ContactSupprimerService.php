<?php

namespace App\Domain\Contact\Service;

use App\Domain\Contact\Repository\ContactRepository;

class ContactSupprimerService
{
    private $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    public function supprimerContact(int $id): bool
    {
        // Supprimer le contact
        $contactSupprime = $this->repository->deleteContact($id);

        // Retourner la suppression réussie
        return $contactSupprime;
    }
}
