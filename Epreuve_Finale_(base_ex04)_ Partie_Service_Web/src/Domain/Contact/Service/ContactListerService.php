<?php

namespace App\Domain\Contact\Service;

use App\Domain\Contact\Repository\ContactRepository;

final class ContactListerService
{
    private $repository;

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Récupère la liste de tous les contacts.
     *
     * @return array La liste des contacts
     */
    public function listerContacts(): array
    {
        $contacts = $this->repository->selectAllContacts();

        return $contacts;
    }
}
