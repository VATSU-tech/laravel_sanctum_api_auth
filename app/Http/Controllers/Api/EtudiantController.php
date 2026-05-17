<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    //
    public function register(Request $request)
    {
        //validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:etudiants',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $etudiant = Etudiant::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => isset($request->phone) ? $request->phone : '',
            'password' => Hash::make($request->password),
        ]);
        //response
        return response()->json([
            'status' => 1,
            'message' => 'Etudiant registered successfully',
            'etudiant' => $etudiant
        ], 201);
        //enregistrement dans la base de données
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $etudiant = Etudiant::where('email', '=', $request->email)->first();

        if ($etudiant) {

            if ($etudiant && Hash::check($request->password, $etudiant->password)) {
                $token = $etudiant->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 1,
                    'message' => 'Etudiant logged in successfully',
                    'etudiant' => $etudiant,
                    'token' => $token,
                ], 200);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'Invalid email or password',
                ], 401);
            }
        } else {
            return response()->json([
                'status' => 0,
                'message' => 'Etudiant not found',
            ], 404);

        }
    }
    public function logout(Request $request)
    {

    }
    public function profile(Request $request)
    {

    }
}
