<?php

namespace Gerardojbaez\LaraPlans\Exceptions;

class InvalidIntervalException extends \Exception
{
    /**
     * Create a new InvalidPlanFeatureException instance.
     *
     * @param $feature
     * @return void
     */
    function __construct($interval)
    {
        $this->message = "Invalid interval \"{$interval}\".";
    }
}
