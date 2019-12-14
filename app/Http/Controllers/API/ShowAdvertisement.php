<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Advertisement;
use App\GeneralApplicationSettings;
use App\Utils\Logger;
use App\Utils\Util;
use App\AdvertisementGroupInterval;

class ShowAdvertisement extends \App\Http\Controllers\Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $managementType = GeneralApplicationSettings::find(1);
        if($managementType->deactivate_adds===true) {
            return json_encde(array('status' => false, 'message' => 'Functionality disabled'));
        }
        if($managementType->publicity_management_type===1) {
            return $this->getStaticAdvertisement($managementType);
        }
        if($managementType->publicity_management_type===2) {
            return $this->getDynamicDateAdvertisement();
        }
        if($managementType->publicity_management_type===3) {
            return $this->getPercentAdvertisement();
        }
        return json_encde(array('status' => false, 'message' => 'No method provided.'));
    }

    protected function getStaticAdvertisement(GeneralApplicationSettings $settings) {
        $static_advertisement_id = $settings->static_add;
        if(!$static_advertisement_id) {
            return json_encde(array('status' => false, 'message' => 'Any Static advertise selected'));
        }
        $result = Advertisement::find($static_advertisement_id);
        if(!$result) {
            return json_encde(array('status' => false, 'message' => 'No advertise found')); 
        }
        return json_encde(array('status' => true, 'message' => $result)); 
    }

    protected function getDynamicDateAdvertisement() {
        $gmt = gmdate('H:i:s', strtotime('now'));
        $advers = json_decode($this->getOverlappingInterval($gmt)->advertisements);
        $randomPos = array_rand($advers, 1);
        return Advertisement::find($advers[$randomPos]);
    }

    protected function getOverlappingInterval($gmt) {
        foreach(AdvertisementGroupInterval::all() as $intvl) {
            if(strtotime($intvl->start_time) < strtotime($gmt) && strtotime($intvl->end_time) > strtotime($gmt)) {
                return $intvl;
            }
        }
        return NULL;
    }

    protected function getPercentAdvertisement() {
        $util = new Util;
        $ponderations = $this->getPercentageMap();
        $rand = $util->getRandomNumberBetweenValues(0, 100);
        foreach($ponderations as $p) {
            if($p[1][0] <= $rand && $rand <= $p[1][1]) {
                return $p[0];
            }
        }
        return NULL;
    }

    protected function getPercentageMap() {
        $ponderations = [];
        $ponderationAccumulator = 0;
        $allLoaded = false;
        $lastTail = 0;
        while($ponderationAccumulator!==100) {
            if(!$allLoaded) {
                $arrAdvers = Advertisement::all();
                foreach($arrAdvers as $a) {
                    $tmpSum = $a->perc + $lastTail;
                    $moreOnehundred = ($lastTail + ($a->perc + 1));
                    $amount = ($moreOnehundred >= 100) 
                        ? ($tmpSum  - 1) : $tmpSum;
                    $lpr = [$lastTail, $amount];
                    $iut = array(
                        0 => $a,
                        1 => $lpr
                    );
                    array_push($ponderations, $iut);
                    $lastTail += ($a->perc + 1);
                    if($lastTail>100) {
                        return $ponderations;
                    }
                }
                $allLoaded=true;
                continue;
            }
            if(empty($ponderations)) {
                break;
            }
            // If not empty increment by one each perc till 100
            foreach($ponderations as $p) {
                if (current($p) == $ponderations[0]) {
                    $iag = $p[1];
                    $iag[1] = $iag[1] + 1;
                    $p[1] = [0, $iag[1]];
                }
                else if (current($p) == $ponderations[count($ponderations)-1]) {
                    $iag = $p[1];
                    $iag[0] = $iag[0] + 1;
                    $p[1] = [$iag[0], 100];
                }
                else {
                    $iag = $p[1];
                    $iag[0] = $iag[0] + 1;
                    $iag[1] = $iag[1] + 1;
                    $p[1] = $iag;
                }
            }
            foreach($ponderations as $p) {
                $iag = $p[1];
                $ponderationAccumulator += ($iag[1]-$iag[0]);
            }
        }
        return $ponderations;
    }
}
