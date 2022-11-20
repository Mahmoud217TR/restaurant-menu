<?php

namespace App\Http\Controllers;

use App\Actions\API\CreateMenuAction;
use App\Actions\API\DeleteMenuAction;
use App\Actions\API\UpdateMenuAction;
use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use App\Http\Resources\MenuResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'menus' => MenuResource::collection(Menu::all()),
        ],200);
    }

    public function manage()
    {
        return response()->json([
            'menus' => MenuResource::collection(auth()->user()->menus),
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CreateMenuAction $action)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'description' => 'required',
            'discount' => 'nullable|numeric|max:100|min:0',
        ]);
        
        if(!$validator->passes()){
            return response()->json([
                'errors' => $validator->errors()->toArray(),
            ],422);
        }
        
        $menu = $action->execute($request->all());

        return response()->json([
            'menu' => new MenuResource($menu),
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        return response()->json([
            'menu' => new MenuResource($menu->load('mainCategories')),
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $edit_menu = Gate::inspect('update', $menu);

        if($edit_menu->allowed()){
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
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMenuRequest  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu, UpdateMenuAction $action)
    {
        $edit_menu = Gate::inspect('update', $menu);
        
        if($edit_menu->allowed()){
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'description' => 'required',
                'discount' => 'nullable|numeric|max:100|min:0',
            ]);

            if(!$validator->passes()){
                return response()->json([
                    'errors' => $validator->errors()->toArray(),
                ],422);
            }
            
            $menu = $action->execute($menu, $request->all());
            
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu, DeleteMenuAction $action)
    {
        $delete_menu = Gate::inspect('delete', $menu);
        if($delete_menu->allowed()){
            $action->execute($menu);
            return response()->json([
                'menus' => MenuResource::collection(auth()->user()->menus),
            ],200);
        }else{
            return response()->json([
                'message' => 'Unauthorized Action',
            ],403);
        }
        
    }
}
