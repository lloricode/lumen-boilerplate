<?php

namespace App\Repositories;

use Serializable;

class Serializer implements Serializable
{
    private $prop;

    public function __construct($prop)
    {
        $this->prop = $prop;
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        // TODO: Implement serialize() method.
    }

    /**
     * @inheritDoc
     */
    public function unserialize($serialized)
    {
        // TODO: Implement unserialize() method.
    }
}