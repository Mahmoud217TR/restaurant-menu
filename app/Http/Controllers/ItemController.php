<?php

namespace App\Http\Controllers;

use App\Actions\API\CreateItemAction;
use App\Actions\API\DeleteItemAction;
use App\Actions\API\UpdateItemAction;
use App\Models\Item;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Menu $menu, CreateItemAction $action)
    {
        $edit_menu = Gate::inspect('update', $menu);

        if($edit_menu->allowed()){
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'discount' => 'nullable|numeric|max:100|min:0',
                'price' => 'required|numeric|min:0',
                'description' => 'nullable',
                'category_id' => 'required|exists:categories,id',
            ]);
            
            if(!$validator->passes()){
                $errors = collect($validator->errors()->toArray())->mapWithKeys(function($value,$key) use ($request){
                    return [$request->type.$key=>$value];
                });
                return response()->json([
                    'errors' => $errors,
                ],422);
            }
            
            $item = $action->execute($request->all());
    
            return response()->json([
                'menu' => new MenuResource($menu->load('mainCategories')),
            ],200);
        }else{
            return response()->json([
                'message' => 'Unauthorized Action',
            ],403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item, UpdateItemAction $action)
    {
        $edit_item = Gate::inspect('update', $item);

        if($edit_item->allowed()){
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'discount' => 'nullable|numeric|max:100|min:0',
            ]);
            
            if(!$validator->passes()){
                $errors = collect($validator->errors()->toArray())->mapWithKeys(function($value,$key) use ($request){
                    return [$request->type.$key=>$value];
                });
                return response()->json([
                    'errors' => $errors,
                ],422);
            }
            
            $item = $action->execute($item, $request->all());
    
            return response()->json([
                'menu' => new MenuResource($item->category->menu->load('mainCategories')),
            ],200);
        }else{
            return response()->json([
                'message' => 'Unauthorized Action',
            ],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item, DeleteItemAction $action)
    {
        $delete_item = Gate::inspect('delete', $item);
        if($delete_item->allowed()){
            $menu = $item->category->menu;
            $action->execute($item);
            return response()->json([
                'menu' => new MenuResource($menu->load('mainCategories')),
            ],200);
        }else{
            return response()->json([
                'message' => 'Unauthorized Action',
            ],403);
        }
    }
}
