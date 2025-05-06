<?php

namespace Modules\EntretienIndividuel\Services;

use Modules\EntretienIndividuel\Domain\Interfaces\IFormulaire;

class FormulaireService
{
    protected $formulaireRepository;

    public function __construct(IFormulaire $formulaireRepository)
    {
        $this->formulaireRepository = $formulaireRepository;
    }

    public function getAll()
    {
      $formulaireRepository = $this->formulaireRepository->all();
      return $formulaireRepository;
    }

    // public function create(array $data)
    // {
    
    // }

    // public function find($id)
    // {
      
    // }

    // public function update($id, array $data)
    // {
    
    // }

    // public function delete($id)
    // {
      
    // }
} 