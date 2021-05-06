<?php

namespace App\Service;

use App\Entity\Log;

class PublicLogRecorder extends LogRecorder
{
    public function __construct()
    {
        parent::__construct();
        $this->log->setIsPublic(true);
    }

    public function recordLastStage()
    {
        $this->log->setLogName(Log::LAST_STAGE);
        $department = $this->departmentManager->selectOneByDeptId($_SESSION['deptId']);
        $this->log->setAssociatedText("est arrivé au dernier niveau du département " . $department['title']);
        $this->logManager->insertNewLog($this->log);
    }
    public function recordIsCheating()
    {
        $this->log->setLogName(Log::CHEAT);
        $department = $this->departmentManager->selectOneByDeptId($_SESSION['deptId']);
        $this->log->setAssociatedText("a tenté de tricher dans le département " . $department['title']);
        $this->logManager->insertNewLog($this->log);
    }
    public function recordNewFirst()
    {
        $this->log->setLogName(Log::NEW_FIRST);
        $department = $this->departmentManager->selectOneByDeptId($_SESSION['deptId']);
        $this->log->setAssociatedText("est le nouveau boss du département " . $department['title']);
        $this->logManager->insertNewLog($this->log);
    }
    public function recordPerfectAnswer()
    {
        $this->log->setLogName(Log::PERFECT_ANSWER);
        $department = $this->departmentManager->selectOneByDeptId($_SESSION['deptId']);
        $this->log->setAssociatedText("a fait un perfect dans le département " . $department['title']);
        $this->logManager->insertNewLog($this->log);
    }

    public function recordNewBadgeGiven($badgeName)
    {
        $this->log->setLogName(Log::NEW_BADGE);
        $department = $this->departmentManager->selectOneByDeptId($_SESSION['deptId']);
        $this->log->setAssociatedText("vient d'obtenir le badge "
            . $badgeName . ' dans le département ' . $department['title']);
        $this->logManager->insertNewLog($this->log);
    }
}
