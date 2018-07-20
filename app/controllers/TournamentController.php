<?php

namespace Controllers;

use Exceptions\RestParameterException;
use Models\Tournament;

class TournamentController extends ControllerBase
{

    public function getTournamentById()
    {
        $response = $this->response;
        try {
            $id = $this->getJsonParameterFromPost('tournament_id', 'int', true);

            $tournament= Tournament::findFirst(
                [
                    "id = :id:",
                    "bind" => [
                        "id" => $id
                    ]
                ]
            );

            if ($tournament) {
                $response->setStatusCode(200, "OK");
                $response->setJsonContent($tournament);
            } else {
                $response->setStatusCode(404, "Not found");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "Tournament you are looking for doesn't exist"));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

    public function getAllTournaments(){
        $response = $this->response;
        try {
            $tournaments = Tournament::find(
                [
                    "order" => "date_start DESC"
                ]
            );

            if (sizeof($tournaments) > 0) {
                $response->setStatusCode(200, "OK");
                $response->setJsonContent($tournaments);
            } else {
                $response->setStatusCode(404, "Not found");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "There are no tournaments!"));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

//    public function createNewTournament(){
//        $response = $this->response;
//        try {
//            $name = $this->getJsonParameterFromPost('name', 'string', true);
//            $type = $this->getJsonParameterFromPost('type', 'string', true);
//            $cap = $this->getJsonParameterFromPost('cap', 'int', true);
//            $date_start = $this->getJsonParameterFromPost('date_start', 'string', true);
//            $date_end = $this->getJsonParameterFromPost('date_end', 'string', true);
//            //USER VERIFICATION
//            $user_id = $this->getJsonParameterFromPost('user_id', 'int', true);
//
//            $result = $this->isAdmin($user_id,$response);
//
//            if(!is_int($result)){
//                $response = $result;
//                return;
//            }
//
//            if($result == 0){
//                $response->setStatusCode(403, "Forbidden");
//                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "This user doesn't have the permission to create the tournament!"));
//                return;
//            }
//
//            $tournament = Tournament::findFirst(
//                [
//                    "name = :name: AND type = :type: AND date_start = :date_start:",
//                    "bind" => [
//                        "name" => $name,
//                        "type" => $type,
//                        "date_start" => $date_start
//                    ]
//                ]
//            );
//
//            if ($tournament) {
//                $response->setStatusCode(409, "Conflict");
//                $response->setJsonContent(array('status' => 'ERROR', 'messages' => 'Such tournament already exists!'));
//                return;
//            }
//
//            $tournament = new Tournament();
//            $tournament->name = $name;
//            $tournament->type = $type;
//            $tournament->cap = $cap;
//            $tournament->date_start = $date_start;
//            $tournament->date_end = $date_end;
//
//            if ($tournament->save()) {
//                $response->setStatusCode(201, "Created");
//                $response->setJsonContent(array('status' => 'SUCCESS', 'messages' => 'Successfully created a new tournament!'));
//            } else {
//                $response->setStatusCode(500, "Unexpected error");
//                $response->setJsonContent(array('status' => 'ERROR', 'messages' => 'Something went wrong, tournament not registered!'));
//            }
//        } catch (\Exception $e) {
//            $response = $this->getExceptionResponse($e);
//        } finally {
//            return $response;
//        }
//    }


    //PRIVATE FUNCTIONS

//    private function isAdmin($user_id,$response){
//        $user = User::findFirst([
//            "id = :id:",
//            "bind" => [
//                "id" => $user_id
//            ]
//        ]);
//
//        if(!$user){
//            $response->setStatusCode(404, "Not found");
//            $response->setJsonContent(array('status' => 'ERROR', 'messages' => "User you are looking for doesn't exist"));
//            return $response;
//        }
//
//        $user_roles = UserRole::find(
//            [
//                "user_id = :id:",
//                "bind" => [
//                    "id" => $user_id
//                ]
//            ]
//        );
//
//        if(sizeof($user_roles) == 0){
//            $response->setStatusCode(404, "Not found");
//            $response->setJsonContent(array('status' => 'ERROR', 'messages' => "User you are looking doesn't have any role and cannot create a new tournament!"));
//            return $response;
//        }
//
//        foreach ($user_roles as $role){
//            if($role->role_id == 1){
//                return 1;
//            }
//        }
//
//        return 0;
//    }
}


