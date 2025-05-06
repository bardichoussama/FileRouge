<?php

namespace Modules\EntretienIndividuel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\EntretienIndividuel\Services\EntretienService;

class EntretienController extends Controller
{
    protected $entretienService;

    public function __construct(EntretienService $entretienService)
    {
        $this->entretienService = $entretienService;
    }

    public function index()
    {
        // Implementation will go here
    }

    public function store(Request $request)
    {
        // Implementation will go here
    }

    public function show($id)
    {
        // Implementation will go here
    }

    public function update(Request $request, $id)
    {
        // Implementation will go here
    }

    public function destroy($id)
    {
        // Implementation will go here
    }
} 