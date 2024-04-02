<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventory = Inventory::all();

        return response()->json($inventory);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function find($id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inventory = Inventory::create([
            'user_id' => $request->input('UID'),
            'Name' => $request->input('name'),
            'Description' => $request->input('description'),
            'Date' => $request->input('date'),
            'Status' => $request->input('status'),
        ]);

        $response = [
            'success' => true,
            'message'  => 'Successfully inserted'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $inventory = Inventory::find($id);

        return response()->json($inventory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $store = Inventory::find($id);
        $store->update([
            'Name' => $request->input('name'),
            'Description' => $request->input('description'),
            'Date' => $request->input('date'),
            'Status' => $request->input('status'),
        ]);

        $response = [
            'success' => true,
            'message'  => 'Updated Successfully'
        ];

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
