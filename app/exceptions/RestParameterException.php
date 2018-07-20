<?php

namespace Exceptions;

class RestParameterException extends \Exception implements CustomExceptionInterface
{

    private $response_message; // Server is in maintenance
    private $parameter_name; // parameter that is missing

    /**
     * RestParameterException constructor.
     * @param string $parameter_name var missing
     * @param string $response_message response_message
     */
    public function __construct($parameter_name, $response_message = null)
    {
        $this->parameter_name = $parameter_name;
        if (empty($response_message)) {
            $this->response_message = "Nije ispravano polje $parameter_name.";
            parent::__construct("[Greška] Nedostaje ili nije validan REST parametar : $parameter_name");
        } else {
            $this->response_message = $response_message;
            parent::__construct("[Greška] " . $response_message);
        }
    }

    /**
     * Returns status code for HTTP Response
     *
     * @return int
     */
    public function getStatusCode()
    {
        return 400;
    }

    /**
     * Returns message of http status code
     *
     * @return string
     */
    public function getStatusCodeMessage()
    {
        return "Bad Request";
    }

    /**
     * Returns custom message
     *
     * @return string
     */
    public function getCustomMessage()
    {
        return $this->response_message;
    }

    /**
     * Returns log file name
     *
     * @return string
     */
    public function getLoggerFileName()
    {
        return "application_rest_parameter_exception.log";
    }

    /**
     * Returns Exception name
     *
     * @return string
     */
    public function getExceptionName()
    {
        return "REST Parameter Exception";
    }
}