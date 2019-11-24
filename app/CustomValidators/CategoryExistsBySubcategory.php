<?php

namespace App\CustomValidators;

use App\Subcategory;
use App\Utils\Logger;

class CategoryExistsBySubcategory {
    // Return: false if category doesn't exists for subcategory
    public function check(Array $categories, Array $subcategories) {
        foreach($subcategories as $idxSubcategory) {
            $subcategory = Subcategory::find($idxSubcategory);
            $categoryId  = $subcategory->category->id;
            if(!in_array($categoryId, $categories)) {
                return false;
            }
        }
        return true;
    }
}