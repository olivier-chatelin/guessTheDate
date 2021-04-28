<?php

namespace App\Entity;

class Anomaly extends Log
{
    public const WRONG_NAME_ANOMALY = 'User tries to login with wrong pseudo';

    public function __construct($logName = self::UNKNOWN_LOG)
    {
        parent::__construct($logName);
        $this->isAnomaly = true;
    }
}
