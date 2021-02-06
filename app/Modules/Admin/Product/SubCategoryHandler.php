<?php

namespace App\Modules\Admin\Product;

use App\Models\Product\ProductCategory;
use App\Models\Product\ProductSubCategory;
use GetResponses;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;

class SubCategoryHandler
{
    /**
     * Create Product Category
     */
    public function createSubCategory($request)
    {
        $subCatImage = $request->image;
        $imageName = null;
        //Process Image
        if (!empty($subCatImage)) {
            $path = public_path() . '/resources/product/subcategory';
            if (!FacadesFile::isDirectory($path)) {
                Storage::makeDirectory($path, $mode = 0777, true, true);
            }
            $imageName = $subCatImage->getClientOriginalName();
            $subCatImage->move($path, $imageName);
            // dd($imageName);
        }

        $createSubCat = ProductSubCategory::create([
            'cat_id' => $request->catId,
            'name' => $request->name,
            'image' => $imageName
        ]);
        if ($createSubCat) {
            return GetResponses::postSuccess();
        }
        return GetResponses::inputValidationError();
    }
    /***
     * Update Sub Category
     */

    public function updateSubCategory($request, $id)
    {
        //Find Sub Category
        $findSubCat = ProductSubCategory::find($id);

        if ($findSubCat != null) {
            $subCatImage = $request->image;

            if (!empty($subCatImage)) {
                $path = public_path() . '/resources/product/subcategory';
                if (!FacadesFile::isDirectory($path)) {
                    Storage::makeDirectory($path, $mode = 0777, true, true);
                }
                $imageName = $subCatImage->getClientOriginalName();
                $subCatImage->move($path, $imageName);
                // dd($imageName);
            }
            //Category Update
            if (isset($request->catId)) {
                // dd($findSubCat->name);
                $findSubCat->cat_id = $request->catId;
            }
            //Isset Name to update
            if (isset($request->name)) {
                // dd($findSubCat->name);
                $findSubCat->name = $request->name;
            }
            //Image to update
            if (isset($imageName)) {
                $findSubCat->image = $imageName;
            }
            $findSubCat->update();
            return GetResponses::updateSuccess();
        }
        return GetResponses::inputValidationError();
    }

    /***
     * List Sub Category
     */
    public function subCategoryList($request)
    {
        $getSubCat = ProductSubCategory::with('hasCategory', 'hasProduct')->orderBy('name', 'asc')->get();
        return GetResponses::returnData($getSubCat);
    }
}
