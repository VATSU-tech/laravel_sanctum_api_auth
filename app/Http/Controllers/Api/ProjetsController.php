<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetsController extends Controller
{
    //
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'duree' => 'required|integer|min:0',
            'description' => 'required|string',
        ]);
        $projet = new Projet();
        $projet->name = $request->name;
        $projet->duree = $request->duree;
        $projet->etudiant_id = Auth::user()->id;
        $projet->description = $request->description;
        $projet->save();
        return response()->json([
            'status' => 1,
            'message' => 'Projet created successfully',
            'projet' => $projet
        ], 201);
    }
    public function delete( $id){

    }
    public function list( $id){

    }
    public function details( $id){

    }
    public function register(Request $request){

    }
}
