<?php

namespace App\Http\Controllers;

use App\Models\Custodian;
use Illuminate\Http\Request;

class CustodianController extends Controller
{
    public function index()
    {
        return response()->json(Custodian::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'office' => 'nullable|string',
            'position' => 'nullable|string',
        ]);

        $custodian = Custodian::create($validated);
        return response()->json($custodian, 201);
    }
}
