<?php

namespace Models;

class Tournament extends \Phalcon\Mvc\Model
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
    public $type;

    /**
     *
     * @var integer
     */
    public $cap;

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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("debate");
        $this->setSource("tournament");
        $this->hasMany('id', 'Models\Event', 'tournament_id', ['alias' => 'Event']);
        $this->hasMany('id', 'Models\Participating', 'tournament_id', ['alias' => 'Participating']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'tournament';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tournament[]|Tournament|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Tournament|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
