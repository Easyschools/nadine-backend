<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Services\Dashboard\CategoryApiService;

class CategoryApiController extends Controller
{

    private $categoryService;

    public function __construct(CategoryApiService $categoryService)
    {
        $this->middleware('auth:api');
        $this->middleware('check.role:1,2 ')
            ->only(['index','read']);
        $this->categoryService = $categoryService;
    }


    public function read(CategoryRequest $request)
    {
        $process = $this->categoryService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CategoryRequest $request)
    {
        $process = $this->categoryService->index($request);
        return $this->sendResponse($process);
    }
}
