<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Carbon;
use App\Http\Requests\StoreItemsRequest;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Item::where($request->all())->orderBy('date', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemsRequest $request)
    {
        $newItem = new Item;
        $newItem->title = $request->item["title"];
        $newItem->category = $request->item["category"];
        $newItem->description = $request->item["description"] ? $request->item['description'] : null;
        $newItem->cost = $request->item["cost"];
        $newItem->date = $request->item["date"];
        $newItem->save();
        return $newItem;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreItemsRequest $request, $id)
    {
        $existingItem = Item::find($id);
        if ($existingItem) {
            $existingItem->title = $request->item['title'];
            $existingItem->date = $request->item['date'];
            $existingItem->cost = $request->item['cost'];
            $existingItem->category = $request->item['category'];
            $existingItem->description = $request->item['description'] ? $request->item['description'] : null;
            $existingItem->paid = $request->item['paid'] ? true : false;
            $existingItem->paid_at = $request->item['paid'] ? Carbon::now() : null;
            $existingItem->save();
            return $existingItem;
        }

        return 'Item not found.';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingItem = Item::find($id);
        if ($existingItem) {
            $existingItem->delete();
            return 'Item successfully deleted.';
        }
        return 'Item not found.';
    }
}
