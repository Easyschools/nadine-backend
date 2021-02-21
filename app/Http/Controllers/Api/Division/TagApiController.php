<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 18/02/21
 * Time: 11:57 ص
 */

namespace App\Http\Controllers\Api\Division;


use App\Http\Controllers\Controller;
use App\Http\Requests\Division\CategoryRequest;
use App\Services\Dashboard\Division\TagApiService;

class TagApiController extends Controller
{

    private $tagService;

    public function __construct(TagApiService $tagService)
    {
//        $this->middleware('auth:api');
//        $this->middleware('check.role:1,2 ')
//            ->only(['index','read']);
        $this->tagService = $tagService;
    }


    public function read(CategoryRequest $request)
    {
        $process = $this->tagService->get($request);
        return $this->sendResponse($process);
    }


    public function all(CategoryRequest $request)
    {
        $process = $this->tagService->index($request);
        return $this->sendResponse($process);
    }
}
