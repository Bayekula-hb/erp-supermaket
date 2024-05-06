<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Succursale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuccursaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $establishment = Establishment::where('user_id', $request->user()->id)->first();
            
        if($establishment){
            $succursales = Succursale::where('establishment_id', $establishment->id)->get();

            return response()->json([
                'error'=>false,
                'message'=> 'The establishment are created with successfully', 
                'data' => $succursales
            ], 200); 
        }else {
            return response()->json([
                'error'=>false,
                'message'=> 'You are not an etablishement', 
                'data' => []
            ], 400); 
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $establishment = Establishment::where('user_id', $request->user()->id)->first();
            
            if($establishment){

                $succursale = Succursale::create([
                    'nameSuccursale' => $request->nameSuccursale,
                    'latitudeSuccursale' => $request->latitudeSuccursale,
                    'address' => $request->address,
                    'longitudeSuccursale' => $request->longitudeSuccursale,
                    'establishment_id' => $establishment->id,
                    'workers' => $request->workers ? json_encode([$request->workers]) : json_encode([]),
                    'workingDays' => $request->workingDays ? json_encode($request->workingDays) : json_encode(['Lundi', 'Mardi', 'Mercredi', 'Jeudi','Vendredi', 'Samedi', 'Dimanche']),
                ]);

                DB::commit();
                return response()->json([
                    'error'=>false,
                    'message'=> 'The Succurale are created with successfully', 
                    'data' => $succursale
                ], 200); 
            }else {
                return response()->json([
                    'error'=>false,
                    'message'=> 'You are not an etablishement', 
                    'data' => []
                ], 400); 
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'data' => $th,
            ], 400);     
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
