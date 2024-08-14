<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Ramsey\Uuid\v1;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::orderByDesc('id')->get();
        // dd($category);
        return view('admin.category.index',compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // dd($request->all());
        $validated = $request->validated();

        DB::transaction(function () use ($validated, $request){
            if($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons','public');
                $validated['icon'] = $iconPath;
            }else{
                $iconPath = 'images/icon-default.png';
            }
            $validated['slug'] = Str::slug($validated['name']);
            $category = Category::create($validated);
        });
        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();

        DB::transaction(function() use ($validated, $request, $category) {
            if ($request->hasFile('icon')) {
                $iconPath = $request->file('icon')->store('icons', 'public');
                $validated['icon'] = $iconPath;
            }

            $validated['slug'] = Str::slug($validated['name']);
            
            // Pastikan menggunakan method 'update' yang benar
            $category->update($validated);
        });

        return redirect()->route('admin.categories.index');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            $category->delete();
            DB::commit();
            return redirect()->route('admin.categories.index');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->route('admin.categories.index')->with('Ada Sebuah Error Disini');
        }
    }
}
