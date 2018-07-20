<?php

namespace Controllers;

use Models\University;

class UniversityController extends ControllerBase
{

    public function createNewUniversity()
    {
        $response = $this->response;
        try {
            $name = $this->getJsonParameterFromPost('name', 'string', true);
            $city = $this->getJsonParameterFromPost('city', 'string', true);
            $country = $this->getJsonParameterFromPost('country', 'string', true);

            $university = University::findFirst(
                [
                    "name = :name: AND city=:city: AND country=:country:",
                    "bind" => [
                        "name" => $name,
                        "city" => $city,
                        "country" => $country
                    ]
                ]
            );

            if ($university) {
                $response->setStatusCode(409, "Conflict");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => 'Such university already exists!'));
                return;
            }

            $university = new University();
            $university->name = $name;
            $university->city = $city;
            $university->country = $country;

            if ($university->save()) {
                $response->setStatusCode(201, "Created");
                $response->setJsonContent(array('status' => 'SUCCESS', 'messages' => 'Successfully created a new university!'));
            } else {
                $response->setStatusCode(500, "Unexpected error");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => 'Something went wrong, university not registered!'));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

    public function getAllUniversities(){
        $response = $this->response;
        try {
            $universities = University::find();

            if (sizeof($universities) > 0) {
                $response->setStatusCode(200, "OK");
                $response->setJsonContent($universities);
            } else {
                $response->setStatusCode(404, "Not found");
                $response->setJsonContent(array('status' => 'ERROR', 'messages' => "There are no universities"));
            }
        } catch (\Exception $e) {
            $response = $this->getExceptionResponse($e);
        } finally {
            return $response;
        }
    }

}

