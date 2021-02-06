<?php

namespace App\Modules\Admin\Product;

use App\Models\Product\ProductCategory;
use Carbon\Carbon;
use GetResponses;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;

class CategoryHandler
{

    /**
     * Create Product Category
     */
    public function createCategory($request)
    {
        $catImage = $request->image;
        $imageName = null;
        //Process Image
        if (!empty($catImage)) {
            $path = public_path() . '/resources/product/category';
            if (!FacadesFile::isDirectory($path)) {
                Storage::makeDirectory($path, $mode = 0777, true, true);
            }
            $imageName = $catImage->getClientOriginalName();
            $catImage->move($path, $imageName);
            // dd($imageName);
        }

        $createCat = ProductCategory::create([
            'name' => $request->name,
            'image' => $imageName
        ]);
        if ($createCat) {
            return GetResponses::postSuccess();
        }
        return GetResponses::inputValidationError();
    }
    /***
     * Update Category
     */

     public function updateCategory($request,$id){
        //Find Category
        $findCat = ProductCategory::find($id);
  
        if($findCat!=null){
            $catImage = $request->image;

            if (!empty($catImage)) {
                $path = public_path() . '/resources/product/category';
                if (!FacadesFile::isDirectory($path)) {
                    Storage::makeDirectory($path, $mode = 0777, true, true);
                }
                $imageName = $catImage->getClientOriginalName();
                $catImage->move($path, $imageName);
                // dd($imageName);
            }  
            //Isset Name to update
            if (isset($request->name)) {
                // dd($findCat->name);
                $findCat->name = $request->name;
            }
            //Image to update
            if (isset($imageName)) {
                $findCat->image = $imageName;
            }
            $findCat->update();
            return GetResponses::updateSuccess();

        }
        return GetResponses::inputValidationError();
     }

     /***
      * List Category
      */
      public function categoryList($request){
          $getCat = ProductCategory::with('hasSubCat')->orderBy('name','asc')->get();
          return GetResponses::returnData($getCat);

      }


}
