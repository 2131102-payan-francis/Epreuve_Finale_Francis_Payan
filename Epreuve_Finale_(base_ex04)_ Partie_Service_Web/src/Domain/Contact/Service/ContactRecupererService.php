<?php

namespace App\Domain\Contact\Service;

use App\Domain\Contact\Repository\ContactRepository;

final class ContactRecupererService
{
    private $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Récupère un contact par son ID.
     *
     * @param int $contactId L'ID du contact à récupérer
     * @return array Les informations du contact
     */
    public function recupererContact(int $contactId): array
    {
        $contact = $this->repository->selectContactById($contactId);

        return $contact;
    }
}
