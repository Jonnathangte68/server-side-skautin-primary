<?php

namespace App\Searches;

use Illuminate\Support\Facades\DB;

class RecruiterSearch
{
    public function search(String $termToSearch) {
        $safeTerm = DB::connection()->getPdo()->quote('%'.$termToSearch.'%');
        $sqlQuery = "SELECT DISTINCT recruiters.id, recruiters.name, assets.file_uri as profile_picture, recruiters.created_at
                    FROM recruiters 
                    INNER JOIN users ON recruiters.user_id = users.id 
                    INNER JOIN recruiter_subcategory ON recruiter_subcategory.recruiter_id = recruiters.id 
                    INNER JOIN subcategories ON subcategories.id = recruiter_subcategory.subcategory_id 
                    INNER JOIN categories ON categories.id = subcategories.category_id 
                    INNER JOIN assets ON assets.id = recruiters.profile_picture 
                    WHERE recruiters.name LIKE ".$safeTerm 
                    ." OR users.email LIKE ".$safeTerm
                    ." OR categories.name LIKE ".$safeTerm 
                    ." OR subcategories.name LIKE ".$safeTerm
                    ." ORDER BY recruiters.created_at DESC";
        $result = DB::select($sqlQuery);
        return $result;
    }
}
