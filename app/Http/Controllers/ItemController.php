<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $item = Item::all();
        return response()->json($item);
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
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,xlsx,pdf|max:2048'
        ]);

        $file = new Item;
        if ($request->file()) {
            $file_name = time() . '_' . $request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');
        }

        $item = Item::create([
            'inventory_id' => $request->input('inventoryId'),
            'Name' => $request->input('name'),
            'Description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'image_url' => '/stroage/'.$file_path,
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
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $record = Item::find($id);
        $record->delete();
        return response()->json(['message' => 'Inventory deleted successfully']);
    }
}
