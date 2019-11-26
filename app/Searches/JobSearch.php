<?php

namespace App\Searches;

use Illuminate\Support\Facades\DB;

class JobSearch
{
    public function search(String $termToSearch) {
        $safeTerm = DB::connection()->getPdo()->quote('%'.$termToSearch.'%');
        $sqlQuery = "SELECT DISTINCT vacants.id, vacants.name, assets.file_uri as profile_picture, 
                    vacants.created_at 
                    FROM vacants 
                    INNER JOIN recruiters ON recruiters.id = vacants.recruiter_id 
                    INNER JOIN recruiter_subcategory ON recruiter_subcategory.recruiter_id = recruiters.id 
                    INNER JOIN subcategories ON subcategories.id = recruiter_subcategory.subcategory_id 
                    INNER JOIN categories ON categories.id = subcategories.category_id 
                    INNER JOIN assets ON assets.id = recruiters.profile_picture 
                    WHERE vacants.name LIKE ". $safeTerm
                    ." OR recruiters.name LIKE ". $safeTerm
                    ." OR categories.name LIKE ". $safeTerm
                    ." OR subcategories.name LIKE ". $safeTerm
                    ." ORDER BY vacants.created_at DESC";
        $result = DB::select($sqlQuery);
        return $result;
    }
}
