<?php

namespace App\Http\Controllers;

use App\Actions\API\CreateCategoryAction;
use App\Actions\API\DeleteCategoryAction;
use App\Actions\API\UpdateCategoryAction;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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

    public function store(Menu $menu, Request $request, CreateCategoryAction $action)
    {
        $edit_menu = Gate::inspect('update', $menu);

        if($edit_menu->allowed()){
            $validator = Validator::make($request->all(),[
                'title' => 'required',
                'discount' => 'nullable|numeric|max:100|min:0',
                'category_id' => 'nullable|exists:categories,id',
            ]);
            
            if(!$validator->passes()){
                $errors = collect($validator->errors()->toArray())->mapWithKeys(function($value,$key) use ($request){
                    return [$request->type.$key=>$value];
                });
                return response()->json([
                    'errors' => $errors,
                ],422);
            }
            
            $category = $action->execute($menu, $request->all(), $request->category_id);
    
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
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, UpdateCategoryAction $action)
    {
        $edit_category = Gate::inspect('update', $category);

        if($edit_category->allowed()){
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
            
            $category = $action->execute($category, $request->all());
    
            return response()->json([
                'menu' => new MenuResource($category->menu->load('mainCategories')),
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, DeleteCategoryAction $action)
    {
        $delete_category = Gate::inspect('delete', $category);
        if($delete_category->allowed()){
            $menu = $category->menu;
            $action->execute($category);
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
