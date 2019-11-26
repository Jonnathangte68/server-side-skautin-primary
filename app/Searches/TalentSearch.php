<?php

namespace App\Searches;

use Illuminate\Support\Facades\DB;

class TalentSearch
{
    public function search(String $termToSearch) {
        $safeTerm = DB::connection()->getPdo()->quote('%'.$termToSearch.'%');
        $sqlQuery = "SELECT DISTINCT talents.id, talents.name, assets.file_uri as profile_picture, 
                    talents.created_at 
                    FROM talents 
                    INNER JOIN users ON talents.user_id = users.id 
                    INNER JOIN subcategory_talent ON subcategory_talent.talent_id = talents.id 
                    INNER JOIN subcategories ON subcategories.id = subcategory_talent.subcategory_id 
                    INNER JOIN categories ON categories.id = subcategories.category_id 
                    INNER JOIN assets ON assets.id = talents.profile_picture 
                    WHERE talents.name LIKE ". $safeTerm
                    ." OR users.email LIKE ". $safeTerm
                    ." OR categories.name LIKE ". $safeTerm
                    ." OR subcategories.name LIKE ". $safeTerm
                    ." ORDER BY talents.created_at DESC";
        $result = DB::select($sqlQuery);
        return $result;
    }
}
