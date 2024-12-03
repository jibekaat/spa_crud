<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Sale::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);
        $sale = Sale::create($request->all());
        return response()->json($sale, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        return response()->json($sale);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'item_name' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
        ]);
        $sale->update($request->all());
        return response()->json($sale);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
    return response()->json(null, 204);
    }
}
