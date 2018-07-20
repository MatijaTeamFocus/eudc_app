<?php

namespace Models;

class Participating extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var integer
     */
    public $user_id;

    /**
     *
     * @var integer
     */
    public $tournament_id;

    /**
     *
     * @var string
     */
    public $role;

    /**
     *
     * @var string
     */
    public $link;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("debate");
        $this->setSource("participating");
        $this->belongsTo('user_id', 'Models\User', 'id', ['alias' => 'User']);
        $this->belongsTo('tournament_id', 'Models\Tournament', 'id', ['alias' => 'Tournament']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'participating';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Participating[]|Participating|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Participating|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
