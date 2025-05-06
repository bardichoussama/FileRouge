<?php

namespace Modules\EntretienIndividuel\Http\Controllers;

use Illuminate\Http\Request;
use Modules\EntretienIndividuel\Services\FormulaireService;
use App\Http\Controllers\Controller;
class FormulaireController extends Controller
{
    protected $formulaireService;

    public function __construct(FormulaireService $formulaireService)
    {
        $this->formulaireService = $formulaireService;
    }

    public function getAll()
    {
        $formulaire = $this->formulaireService->getAll();
        return response()->json([
            'message' => 'Formulaire récupéré avec succès',
            'data' => $formulaire
        ], 201);
    }
    
}
