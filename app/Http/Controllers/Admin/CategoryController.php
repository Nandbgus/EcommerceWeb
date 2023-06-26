<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\ImageUploading;
use App\Http\Requests\Admin\CategoryRequest;

class CategoryController extends Controller
{
    use ImageUploading;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all()->pluck('name', 'id');
        return view('admin.categories.create', compact('categories'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
     public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        if ($request->input('photo', false)) {
            $category->addMedia(storage_path('tmp/uploads/' . $request->input('photo')))->toMediaCollection('photo');
        }

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Succeess Created !',
            'type' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('admin.categories.index')->with([
            'message' => 'Succes Update !',
            'type' => 'info',
        ]);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->back()->with([
            'message' => 'Delete Successfully',
            'type' => 'danger',
        ]);
    }
}
