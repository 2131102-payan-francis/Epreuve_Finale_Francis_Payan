<?php

namespace App\Domain\Contact\Service;

use App\Domain\Contact\Repository\ContactRepository;

final class ContactMettreAJourService
{
    private $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Met à jour un contact dans la base de données.
     *
     * @param int $contactId L'ID du contact à mettre à jour
     * @param array $data Les données à mettre à jour
     * @return array Le contact mis à jour
     */
    public function mettreAJourContact(int $contactId, array $data): array
    {
        $contact = $this->repository->updateContact($contactId, $data);

        return $contact;
    }
}
