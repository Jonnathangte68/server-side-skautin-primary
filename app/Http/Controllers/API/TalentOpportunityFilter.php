<?php

namespace App\Http\Controllers\api;

use App\Utils\Logger;
use App\Talent;
use App\Vacant;
use App\Recruiter;
use Illuminate\Http\Request;

class TalentOpportunityFilter extends \App\Http\Controllers\Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $userId = $request->user()->id; // Replace
        $limit = 10;
        $start = 0;
        $talent = Talent::where('user_id', $userId)->firstOrFail();
        $results = array();
        $startCount = 0;
        $subcategories = $talent->subcategories->toArray();
        $subcategories_ids = array_map(
            function($subcategory) {
                return $subcategory['id'];
            },
            $subcategories
        );
        new Logger("Im working!");
        foreach (Recruiter::all() as $recruiter) {
            if(count($results) > $limit) {
                break;
            }
            $recruiterSubcategories = $this->getMapSubcategoriesIds($recruiter);
            if(empty(array_intersect($recruiterSubcategories, $subcategories_ids))) {
                // Do not check anything else just go to next iteration
                continue;
            }
            foreach(Vacant::where('recruiter_id', $recruiter->id)->get() as $vacant) {
                $recruiter = Recruiter::where('id', $vacant->recruiter_id)->firstOrFail();
                $recSubcategs = $recruiter->subcategories->toArray();
                if(!in_array($vacant, $results) 
                    && array_intersect(
                        $this->transformToIndexes($recSubcategs), 
                        $this->transformToIndexes($subcategories))
                    ) 
                    {
                        if($startCount >= $start) {
                            array_push($results, $vacant);
                        }
                        $startCount++;
                        // break: because we don't want to add all the vacants of the same recruiter
                        // on another request we another limit another vacant could be possible added.
                        break;
                }
            }
        }
        return json_encode(array('status' => true, 'message' => $results));
    }

    protected function getMapSubcategoriesIds(Recruiter $recruiter) {
        $subcategories = $recruiter->subcategories->toArray();
        $subcategories_ids = array_map(
            function($subcategory) {
                return $subcategory['id'];
            },
            $subcategories
        );
        return $subcategories_ids;
    }

    protected function transformToIndexes(Array $arrayToTransform) {
        $maptoId = array();
        foreach($arrayToTransform as $simpleObject) {
            array_push($maptoId, $simpleObject['id']);
        }
        return $maptoId;
    }
}

