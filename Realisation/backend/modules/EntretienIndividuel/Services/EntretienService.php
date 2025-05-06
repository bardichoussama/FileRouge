<?php

namespace Modules\EntretienIndividuel\Services;

use Modules\EntretienIndividuel\Domain\Repositories\Interfaces\EntretienRepositoryInterface;

class EntretienService
{
    protected $entretienRepository;

    public function __construct(EntretienRepositoryInterface $entretienRepository)
    {
        $this->entretienRepository = $entretienRepository;
    }

    public function getAll()
    {
        // Implementation will go here
    }

    public function create(array $data)
    {
        // Implementation will go here
    }

    public function find($id)
    {
        // Implementation will go here
    }

    public function update($id, array $data)
    {
        // Implementation will go here
    }

    public function delete($id)
    {
        // Implementation will go here
    }
} 