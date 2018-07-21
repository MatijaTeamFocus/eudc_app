<?php

namespace Controllers;

use Models\Event;
use Models\Venue;
use Models\Room;
use Models\Round;
use Exceptions\RestParameterException;

class EventController extends ControllerBase
{

    /*
     *  1   -   Registration    -   Room
     *  2   -   Round           -   Room
     *  3   -   Socials
     *  4   -   Workshop        -   Room
     *  5   -   Meal            -   Room
     *  6   -   Transport
     *  7   -   Briefing        -   Room
     *  8   -   Misc(Council, Pre Council, Caucus, All day departures) - Room
     * */

    public function getEventById()
    {
        $response = $this->response;
        try {
            $id = $this->getJsonParameterFromPost('event_id', 'int', true);

            $event= Event::findFirst(
                [
                    "id = :id:",
                    "bind" => [
                        "id" => $id
                    ]
                ]
            );

            if ($event) {
                $result["event"] = $event;
                if($event->type == 2){
                    $result["round"] = ($event->Round)[0];
                }
                $result["venue"] = $event->Venue;
                $result["room"] = $this->eventRoom($event);

                $response->setStatusCode(200, "OK");
                $response->setJsonContent($result);
            } else {
                $response->setStatusCode(404, "Not found");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "Event you are looking for doesn't exist"));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

    public function getHomepage()
    {
        $response = $this->response;
        try {
            $id = $this->getJsonParameterFromPost('tournament_id', 'int', true);
            $current_time = $this->getJsonParameterFromPost('current_time', 'string', true);

            $events = Event::find(
                [
                    "tournament_id = :id: AND date_end > :date:",
                    "bind" => [
                        "id" => $id,
                        "date" => $current_time
                    ],
                    "order" => "date_start ASC",
                    "limit" => 3
                ]
            );

            if (sizeof($events) > 0) {
                $results = [];

                foreach ($events as $event){
                    $result["event"] = $event;
                    if($event->type == 2){
                        $result["round"] = ($event->Round)[0];
                    }
                    $result["venue"] = $event->Venue;
                    $result["room"] = $this->eventRoom($event);

                    array_push($results,$result);
                }

                $response->setStatusCode(200, "OK");
                $response->setJsonContent($results);
            } else {
                $response->setStatusCode(404, "Not found");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "All of the events have finished"));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

    public function getScheduleObserver(){
        $response = $this->response;
        try {
            $id = $this->getJsonParameterFromPost('tournament_id', 'int', true);

            $events = Event::find(
                [
                    "tournament_id = :id:",
                    "bind" => [
                        "id" => $id
                    ],
                    "order" => "date_start ASC"
                ]
            );

            if (sizeof($events) > 0) {
                $results = [];

                foreach ($events as $e){
                    $result["event"] = $e;
                    if($e->type == 2){
                        $result["round"] = ($e->Round)[0];
                    }
                    $result["venue"] = $e->Venue;
                    $result["room"] = $this->eventRoom($e);

                    array_push($results,$result);
                }

                $response->setStatusCode(200, "OK");
                $response->setJsonContent($results);
            } else {
                $response->setStatusCode(404, "Not found");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "Event you are looking for doesn't exist"));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

    //PRIVATE FUNCTIONS
    private function eventRoom($event){
        switch ($event->type){
            case 1:
                if($event->room_id){
                    return $event->Room;
                }else{
                    return "";
                }
            case 2:
                if($event->room_id){
                    return $event->Room;
                }else{
                    return "";
                }
            case 4:
                if($event->room_id){
                    return $event->Room;
                }else{
                    return "";
                }
            case 5:
                if($event->room_id){
                    return $event->Room;
                }else{
                    return "";
                }
            case 7:
                if($event->room_id){
                    return $event->Room;
                }else{
                    return "";
                }
            case 8:
                if($event->room_id){
                    return $event->Room;
                }else{
                    return "";
                }
            default:
                return "";
        }
    }

}

