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
            // $file_path = $request->file('file')->storeAs('public/image/', $file_name, 'local');
        }

        $item = Item::create([
            'inventory_id' => $request->input('inventoryId'),
            'Name' => $request->input('name'),
            'Description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
            'image_url' => '/storage'.$file_path,
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
    public function show($id)
    {
        $item = item::where('inventory_id', $id)->get();
        return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Item::find($id);

        return response()->json($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $store = Item::find($id);
        $store->update([
            'Name' => $request->input('name'),
            'Description' => $request->input('description'),
            'quantity' => $request->input('quantity'),
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
    public function destroy($id)
    {
        $record = Item::find($id);
        $record->delete();
        return response()->json(['message' => 'Inventory deleted successfully']);
    }
}
