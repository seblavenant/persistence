<?php

namespace Blockos\Persistence\Fields;

use Blockos\Persistence\Field;
use Blockos\Persistence\FieldTypes;

class UnsignedInteger extends Integer implements Field
{
    public function __construct($namePath = array())
    {
        parent::__construct($namePath);

        $this->setMin(0);
    }

    public function setMin($value)
    {
        if (is_integer($value) && $value < 0)
        {
            $value = 0;
        }

        return parent::setMin($value);
    }
    
    public function getType()
    {
        return FieldTypes::INTEGER;
    }
}
