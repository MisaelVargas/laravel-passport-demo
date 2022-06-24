<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CEO;
use Illuminate\Http\Request;

class CEOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ceos = CEO::all();

        return response([
            'ceos' => CEOResource::collection($ceos),
            'message' => 'Successfully retrieved CEOs',
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'year' => 'required|string|max:255',
            'company_headquarters' => 'required|string|max:255',
            'what_company_does' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $ceo = CEO::create($data);

        return response([
            'message' => 'Successfully created CEO',
            'ceo' => new CEOResource($ceo),
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function show(CEO $ceo)
    {
        return response()->json([
            'ceo' => new CEOResource($ceo),
            'message' => 'Successfully retrieved CEO',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CEO $ceo)
    {
        $ceo->update($request->all());

        return response()->json([
            'message' => 'Successfully updated CEO',
            'ceo' => new CEOResource($ceo),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CEO  $cEO
     * @return \Illuminate\Http\Response
     */
    public function destroy(CEO $ceo)
    {
        $ceo->delete();

        return response()->json([
            'message' => 'Successfully deleted CEO',
        ], 200);
    }
}
