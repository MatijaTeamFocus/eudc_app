<?php

namespace Controllers;

use Exceptions\RestParameterException;
use Phalcon\Exception;
use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    //Public functions
    public function getJsonParameterFromPost($name, $type, $required, $defaultValue = null, $error_message = null)
    {
        if ($this->request->isPost()) {
            //gets field from json
            $jsonField = $this->getJsonField($name, $error_message);

            //check if exists
            if ($required and empty($jsonField) and $jsonField != 0) {
                // IF DEFAULT VALUE NOT PASSED WE CONSIDER REQUIRED JSON FIELD IS MISSING
                if (func_num_args() <= 3) {
                    throw new RestParameterException($name, $error_message);
                } else {
                    // IF DEFAULT VALUE IS PASSED AS NULL WE CONSIDER IT AS MISSING FIELD
                    if ($required and $defaultValue === null) {
                        throw new RestParameterException($name, $error_message);
                    } else {
                        $jsonField = $defaultValue;
                    }
                }
            }

            switch ($type) {
                case "string":
                    return $this->filter->sanitize($jsonField, ['string', 'striptags', 'trim']);
                case "email":
                    return $this->filter->sanitize($jsonField, ['email', 'striptags', 'trim']);
                case "int":
                    return $this->filter->sanitize($jsonField, ['int']);
                case "double":
                    return $this->filter->sanitize($jsonField, ['float']);
                case "date":
                    $date = $this->filter->sanitize($jsonField, ['string', 'striptags', 'trim']);
                    if ($required) {
                        return $this->validateDate($date, $name, $error_message);
                    } else {
                        return $date;
                    }
                case "boolean":
                    if (is_bool($jsonField)) {
                        return $jsonField;
                    } else {
                        if ($jsonField == 0 || $jsonField == 1) {
                            return $jsonField;
                        } else {
                            throw new RestParameterException($name, $error_message);
                        }
                    }
                case "array":
                    if (is_array($jsonField)) {
                        return $jsonField;
                    } else {
                        throw new RestParameterException($name, $error_message);
                    }
                case "none":
                    return $this->filter->sanitize($jsonField, ['trim']);
                default:
                    throw new \Exception("Nepoznat tip parametra");
            }
        } else {
            throw new RestParameterException($name, $error_message);
        }
    }

    //Private functions
    /**
     * Gets field from json directly
     * @param $name
     * @param $error_message
     * @return array|bool|\stdClass
     * @throws RestParameterException
     */
    private function getJsonField($name, $error_message)
    {
        $jsonField = $this->request->getJsonRawBody();

        if (strpos($name, '->') !== false) {
            $split = explode('->', $name);

            foreach ($split as $property) {
                if (!isset($jsonField->$property)) {
                    return null;
                } else {
                    $jsonField = $jsonField->$property;
                }
            }
        } else {
            if (!isset($jsonField->$name)) {
                throw new RestParameterException($name, $error_message);
            } else {
                $jsonField = $jsonField->$name;
            }
        }
        return $jsonField;
    }

    private function validateDate($date, $fieldName, $error_message)
    {
        if (strpos($date, '-') === false) {
            throw new RestParameterException($fieldName, $error_message);
        } else {
            $test_date = explode('-', $date);
            if (checkdate($test_date[1], $test_date[2], $test_date[0])) {
                return $date;
            } else {
                throw new RestParameterException($fieldName, $error_message);
            }
        }
    }

}