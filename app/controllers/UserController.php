<?php

namespace Controllers;

use Models\Participating;
use Phalcon\Mvc\Model\Criteria;
use Models\User;

class UserController extends ControllerBase
{
    //CREATED FUNCTIONS
    public function getUserById()
    {
        $response = $this->response;
        try {
            $id = $this->getJsonParameterFromPost('user_id', 'int', true);

            $user = User::findFirst(
                [
                    "id = :id:",
                    "bind" => [
                        "id" => $id
                    ]
                ]
            );

            if ($user) {
                $response->setStatusCode(200, "OK");
                $response->setJsonContent($user);
            } else {
                $response->setStatusCode(404, "Not found");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "User you are looking for doesn't exist"));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

    public function getUsersByLink(){
        $response = $this->response;
        try {
            $link = $this->getJsonParameterFromPost('link', 'string', true);
            $tournament_id = $this->getJsonParameterFromPost('tournament_id','string',true);

            $participating = Participating::find(
                [
                    "link = :link: AND tournament_id = :tournament_id:",
                    "bind" => [
                        "link" => $link,
                        "tournament_id" => $tournament_id
                    ]
                ]
            );

            if (sizeof($participating)>0) {
                $users = [];
                $does_participate = true;
                foreach ($participating as $participant){
                    $user = User::findFirst(
                        [
                            "id = :user_id:",
                            "bind" => [
                                "user_id" => $participant->user_id
                            ]
                        ]
                    );

                    if(!$user){
                        $response->setStatusCode(404, "Not found");
                        $response->setJsonContent(array('status' => 'ERROR', 'messages' => "User who is trying to enter this tournament doesn't participate at this tournament!"));
                        $does_participate = false;
                    }else{
                        $result["user"] = $user;
                        $result["role"] = $participant->role;

                        array_push($users,$result);
                    }
                }

                if($does_participate == true) {
                    $response->setStatusCode(200, "OK");
                    $response->setJsonContent($users);
                }
            } else {
                $response->setStatusCode(404, "Not found");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "Users you are looking for with that link on this tournament don't exist"));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

    public function registerNewUser()
    {
        $response = $this->response;
        try {
            $name = $this->getJsonParameterFromPost('name', 'string', true);
            $university_id = $this->getJsonParameterFromPost('university_id', 'int', true);
            $link = $this->getJsonParameterFromPost('link', 'string', true);

            $user = User::findFirst(
                [
                    "name = :name: AND link=:link:",
                    "bind" => [
                        "name" => $name,
                        "link" => $link
                    ]
                ]
            );

            if ($user) {
                $response->setStatusCode(409, "Conflict");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => 'Such user already exists!'));
                return;
            }

            $user = new User();
            $user->name = $name;
            $user->link = $link;
            $user->university_id = $university_id;

            if ($user->save()) {
                $response->setStatusCode(201, "Created");
                $response->setJsonContent(array(
                    'status' => 'SUCCESS',
                    'messages' => 'Successfully registered a new user!',
                    'user'=>$user));
            } else {
                $response->setStatusCode(500, "Unexpected error");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => 'Something went wrong, user not registered!'));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

}
