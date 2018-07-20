<?php

namespace Models;

class Venue extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     *
     * @var string
     */
    public $about;

    /**
     *
     * @var string
     */
    public $location;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("debate");
        $this->setSource("venue");
        $this->hasMany('id', 'Models\Event', 'venue_id', ['alias' => 'Event']);
        $this->hasMany('id', 'Models\Room', 'venue_id', ['alias' => 'Room']);
        $this->hasMany('id', 'Models\Round', 'venue_id', ['alias' => 'Round']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'venue';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Venue[]|Venue|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Venue|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
