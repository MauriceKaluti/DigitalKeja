<?php


namespace Innox\Classes\Handlers;


class NumberShorter
{
    private $value;

    /**
     * @param mixed $value
     * @return NumberShorter
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;

    }

    private function thousand()
    {
        return ($this->value / 1000) ;
    }

    private function million()
    {
        return ($this->value / 1000000) ;

    }


    public function shortHand()
    {
        $newValue = array_map('intval', str_split($this->value));

        if (sizeof($newValue) > 3 && sizeof($newValue) < 6)
        {
            return $this->thousand();
        }
        if (sizeof($newValue) >= 6 )
        {
            return $this->million();
        }
        return $this->value;
    }
}
