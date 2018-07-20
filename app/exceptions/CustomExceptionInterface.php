<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 4/27/2018
 * Time: 3:10 PM
 */

namespace Exceptions;


interface CustomExceptionInterface
{

    /**
     * Returns status code for HTTP Response
     *
     * @return int
     */
    public function getStatusCode();

    /**
     * Returns message of http status code
     *
     * @return string
     */
    public function getStatusCodeMessage();

    /**
     * Returns custom message
     *
     * @return string
     */
    public function getCustomMessage();

    /**
     * Returns log file name
     *
     * @return string
     */
    public function getLoggerFileName();

    /**
     * Returns Exception name
     *
     * @return string
     */
    public function getExceptionName();

}