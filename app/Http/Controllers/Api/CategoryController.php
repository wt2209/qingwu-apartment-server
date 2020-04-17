<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *  name="category",
 *  description="居住的类型"
 * )
 */
class CategoryController extends Controller
{
    public function getAllCategories()
    {
        return CategoryResource::collection(Category::all());
    }
    /**
     * @OA\Get(
     *      path="api/categories",
     *      operationId="getCategoriesList",
     *      tags={"category"},
     *      summary="获取居住类型",
     *      @OA\Response(
     *          response=200,
     *          description="获取成功"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of categories
     */
    public function index(Request $request)
    {
        $perPage = $request->query('pageSize', config('app.pageSize', 20));
        $title = $request->query('title', '');
        $type = $request->query('type', '');
        $status =  $request->query('status', Category::STATUS_ALL);

        $queryBuilder = Category::query();
        if ($title) {
            $queryBuilder->where('title', 'like', "{$title}%");
        }
        if (in_array($type, Category::$types)) {
            $queryBuilder->where('type', $type);
        }
        switch ($status) {
            case Category::STATUS_DELETED:
                $queryBuilder->onlyTrashed();
                break;
            case Category::STATUS_ALL:
                $queryBuilder->withTrashed();
                break;
        }
        return CategoryResource::collection($queryBuilder->paginate($perPage));
    }

    /**
     * @OA\Post(
     *     path="api/categories",
     *     tags={"category"},
     *     summary="创建一个类型",
     *     operationId="addCategory",
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     security={
     *         {"petstore_auth": {"write:pets", "read:pets"}}
     *     },
     *     requestBody={"$ref": "#/components/requestBodies/Category"}
     * )
     */
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
        $category = Category::findOrFail($id);
        $category->delete();
        return $this->deleted();
    }

    public function restore($id)
    {
        $this->authorize('restore', Category::class);
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return $this->ok();
    }
}
