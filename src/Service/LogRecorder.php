<?php

namespace App\Service;

use App\Entity\Anomaly;
use App\Model\LogManager;
use App\Entity\Log;

class LogRecorder
{

    private Log $log;
    private LogManager $logManager;

    public function __construct()
    {
        $this->logManager = new LogManager();
        $this->log = new Log();
    }

    public function recordLogin()
    {
        $this->log->setLogName(Log::LOGIN_LOG);
        $this->log->setUserName($_SESSION['pseudo']);
        $this->logManager->insertNewLog($this->log);
    }

    public function recordEndOfGame()
    {
        $this->log->setLogName(Log::GAME_END_LOG);
        $this->logManager->insertNewLog($this->log);
    }

    public function recordChangeAvatar()
    {
        $this->log->setLogName(Log::CHANGE_AVATAR_LOG);
        $this->logManager->insertNewLog($this->log);
    }

    public function recordWrongPseudo()
    {
        $anomaly = new Anomaly(Anomaly::WRONG_NAME_ANOMALY);
        $this->logManager->insertNewLog($anomaly);
    }
}
