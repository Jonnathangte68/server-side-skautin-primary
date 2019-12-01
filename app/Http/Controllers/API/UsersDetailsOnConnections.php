<?php

namespace App\Http\Controllers\API;

use App\Talent;
use App\Recruiter;
use App\Connection;
use App\User;
use App\DataMap\TalentDataMap;
use App\DataMap\RecruiterDataMap;

use Illuminate\Http\Request;

class UsersDetailsOnConnections extends \App\Http\Controllers\Controller
{
    /**
     * Retrieve users connections for example to be show on a list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public $user = NULL;

    public function __invoke(Request $request)
    {
        $this->user = $request->user()->id;
        // First this was going to be implemented to get all records.
        // But All right now returns an error requesting to specify category.
        $connectionType = $request->query('type', 'All');
        $from = $request->query('start', -1);
        $limitResults = $request->query('limit', 10);
        return $this->getDataFromUsers($connectionType, $from, $limitResults);
    }

    protected function getDataFromUsers(String $type, int $start, int $limit) {
        switch($type) {
            case 'viewers':
                return json_encode($this->getData('viewers', $start, $limit));
                break;
            case 'followers':
                return json_encode($this->getData('followers', $start, $limit));
                break;
            case 'connections':
                return json_encode($this->getData('connections', $start, $limit));
                break;
            case 'following':
                return json_encode($this->getData('following', $start, $limit));
                break;
            case 'All':
                return json_encode(array('status' => false, 'message' => 'error: specify type of connection'));
                break;
            }
        }

        protected function getData(String $type, int $start, int $limit) {
            $resultStatus = false;
            $start = $start !== -1 ? $start : 0;
            $results = array();
            $index = 0;
            foreach (Connection::where([['follower_id', $this->user], ['type', $type]])->cursor() as $connection) {
                if($index > $limit) {
                    // Break the loop inmediatlly to improve measure.
                    break;
                }
                if($index >= $start) {
                    $objectResponse = array('id' => $connection->following_id);
                    $user = User::find($connection->following_id);
                    $talent = Talent::where('user_id', $user->id)->first();
                    $recruiter = Recruiter::where('user_id', $user->id)->first();
                    $element = NULL;
                    if($talent) {
                        $talentData = new TalentDataMap;
                        $element = $talentData->getInfo($talent);
                    }
                    if($recruiter) {
                        $recruiterData = new RecruiterDataMap;
                        $element = $recruiterData->getInfo($recruiter);
                    }
                    if ($element) {
                        array_push($results, $element);
                    }
                }
                $index++;
            }
            if(count($results) > 0) {
                $resultStatus = true;
            }
            return array(
                'status' => $resultStatus, 
                'message' => $results
            );
        }
}
