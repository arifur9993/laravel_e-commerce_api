<?php

namespace App\Modules\Admin\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use Carbon\Carbon;
use GetResponses;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;

class ProductHandler
{

    /**
     * Create Product Category
     */
    public function createProduct($request)
    {

        $createProduct = Product::create([
            'cat_id' => $request->catId,
            'sub_cat_id' => $request->subCatId,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $request->image->getClientOriginalName(),
            'image2' => $request->image2->getClientOriginalName(),
            'image3' => $request->image3->getClientOriginalName(),
        ]);
        if ($createProduct) {
            $id = $createProduct->id;
            if (isset($request->image)) {
                $this->processImage($request->image, $id);
            }
            if (isset($request->image2)) {
                $this->processImage($request->image2, $id);
            }
            if (isset($request->image3)) {
                $this->processImage($request->image3, $id);
            }
            return GetResponses::postSuccess();
        }
        return GetResponses::inputValidationError();
    }

    /**
     * Process Image
     */
    public function processImage($file, $id)
    {
        if (!empty($file)) {
            $path = public_path() . '/resources/product/' . $id;
            if (!FacadesFile::isDirectory($path)) {
                Storage::makeDirectory($path, $mode = 0777, true, true);
            }
            $imageName = $file->getClientOriginalName();
            $file->move($path, $imageName);
            // dd($imageName);
        }
    }
    /***
     * Update Category
     */

    public function updateProduct($request, $id)
    {
        //Find Product
        $findProduct = Product::find($id);

        if ($findProduct != null) {
            //Isset Name to update
            if (isset($request->catId)) {
                // dd($findProduct->catId);
                $findProduct->cat_id = $request->catId;
            }
            if (isset($request->subCatId)) {
                // dd($findProduct->subCatId);
                $findProduct->sub_cat_id = $request->subCatId;
            }
            if (isset($request->name)) {
                // dd($findProduct->name);
                $findProduct->name = $request->name;
            }
            if (isset($request->description)) {
                // dd($findProduct->description);
                $findProduct->description = $request->description;
            }
            if (isset($request->price)) {
                // dd($findProduct->price);
                $findProduct->price = $request->price;
            }

            //Image to update
            if (isset($request->image)) {
                $findProduct->image = $request->image->getClientOriginalName();
                $this->processImage($request->image, $id);
            }
            if (isset($request->image2)) {
                $findProduct->image2 = $request->image2->getClientOriginalName();

                $this->processImage($request->image2, $id);
            }
            if (isset($request->image3)) {
                $findProduct->image3 = $request->image3->getClientOriginalName();

                $this->processImage($request->image3, $id);
            }
            $findProduct->update();
            return GetResponses::updateSuccess();
        }
        return GetResponses::inputValidationError();
    }

    /**
     * List of Product
     */
    public function productList($request, $pageNo)
    {
        //Global Pagination Limit
        $perPage = config('globalvariables.paginationLimit');
        $getProduct = Product::with('hasCat', 'hasSubCat')->orderBy('name', 'asc')->paginate($perPage);
        return GetResponses::returnData($getProduct);
    }
}
