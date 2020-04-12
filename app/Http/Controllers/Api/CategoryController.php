<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', config('app.per_page', 20));
        $title = $request->query('title', '');
        $type = $request->query('type', '');

        $queryBuilder = Category::query();
        if ($title) {
            $queryBuilder->where('title', 'like', "{$title}%");
        }
        if (in_array($type, Category::$types)) {
            $queryBuilder->where('type', $type);
        }
        return CategoryResource::collection($queryBuilder->paginate($perPage));
    }

    public function store(CategoryRequest $request)
    {
        $this->authorize('create', Category::class);
        Category::create($request->all());
        return $this->created();
    }

    public function show($id)
    {
        $area = Category::find($id);
        return new CategoryResource($area);
    }

    public function update(CategoryRequest $request, $id)
    {
        $this->authorize('update', Category::class);
        $area = Category::findOrFail($id);
        $area->fill($request->all());
        $area->save();
        return $this->updated();
    }

    public function delete($id)
    {
        $this->authorize('delete', Category::class);
        $area = Category::findOrFail($id);
        $area->delete();
        return $this->deleted();
    }
}
