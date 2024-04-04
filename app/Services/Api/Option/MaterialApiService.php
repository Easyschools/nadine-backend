<?php

namespace App\Services\Api\Option;

use App\Models\Product\Variant;
use App\Models\Option\Material;
use App\Repositories\AppRepository;


class MaterialApiService extends AppRepository
{

    public function __construct(Material $material)
    {
        parent::__construct($material);
    }

    /**
     * @param $request
     * @return mixed
     */
    public function index($request)
    {
        if ($request->is_paginate == 1) {
            return $this->paginate();
        }
        return $this->all();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function get($request)
    {
        return $this->find($request->id);
    }

    public function getMaterialVariants($request)
    {
        $variants = Variant::where('product_id', $request->product_id)
            ->where('material_id', $request->material_id)
            ->with('Color', 'Dimension')
            ->get();
        $dimensions = [];
        $colors = [];

        foreach ($variants as $variant) {
            if ($variant->Dimension) { // Corrected method call to use Dimension()
                $dimensions[] = $variant->Dimension; // Corrected property name to Dimension
            }

            if ($variant->Color) { // Corrected method call to use Color()
                $colors[] = $variant->Color; // Corrected property name to Color
            }
        }

        $result = [
            'dimensions' => $dimensions,
            'colors' => $colors
        ];

        return $result;
    }


    /**
     * @param $request
     * @return mixed
     */
    public function createMaterial($request)
    {
        return $this->model->create($request->only([
            'name_en',
            'name_ar',
        ]));
    }

    /**
     * @param $request
     * @return mixed
     */
    public function editMaterial($request)
    {
        $material = $this->find($request->id);
        return $material->update($request->only([
            'name_en',
            'name_ar',
        ]));
    }
}
