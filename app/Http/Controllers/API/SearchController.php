<?php

namespace App\Http\Controllers\api;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Searches\TalentSearch;
use App\Searches\RecruiterSearch;
use App\Searches\JobSearch;

class SearchController extends \App\Http\Controllers\Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $results = array();
        $terms = Input::get('search_terms');
        foreach($terms as $st) {
            $talentSearch = new TalentSearch;
            $recruiterSearch = new RecruiterSearch;
            $jobSearch = new JobSearch;
            $results = array_merge($recruiterSearch->search($st), $results);
            $results = array_merge($talentSearch->search($st), $results);
            $results = array_merge($jobSearch->search($st), $results);
        }
        shuffle($results);
        return json_encode($results);
    }
}
