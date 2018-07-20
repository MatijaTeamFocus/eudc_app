<?php

namespace Controllers;

use Models\Event;
use Models\Venue;
use Exceptions\RestParameterException;

class EventController extends ControllerBase
{

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
                $result = [];
                $result["event"] = $event;
                $result["venue"] = $event->Venue;

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
                    "limit" => 2
                ]
            );


            if (sizeof($events) > 0) {
                $results = [];

                if(sizeof($events) == 2) {
                    $results[0]["event"] = $events[0];
                    $results[0]["venue"] = $events[0]->Venue;


                    $results[1]["event"] = $events[1];
                    $results[1]["venue"] = $events[1]->Venue;

//                    $result["venues"] = [$events[0]->Venue, $events[1]->Venue];
                }else if(sizeof($events) == 1){
                    $events[0]->venue = $events[0]->Venue;

//                    $result["venues"] = [$events[0]->Venue];
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
                $i = 0;

                foreach ($events as $e){
                    $results[$i]["event"] = $e;
                    $results[$i]["venue"] = $e->Venue;
                    $i++;
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

}

