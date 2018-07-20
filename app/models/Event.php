<?php

namespace Models;

class Event extends \Phalcon\Mvc\Model
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
    public $date_start;

    /**
     *
     * @var string
     */
    public $date_end;

    /**
     *
     * @var integer
     */
    public $tournament_id;

    /**
     *
     * @var integer
     */
    public $type;

    /**
     *
     * @var integer
     */
    public $venue_id;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("debate");
        $this->setSource("event");
        $this->belongsTo('tournament_id', 'Models\Tournament', 'id', ['alias' => 'Tournament']);
        $this->belongsTo('venue_id', 'Models\Venue', 'id', ['alias' => 'Venue']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'event';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event[]|Event|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Event|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
