<?php

namespace App\Service;

use App\Entity\Anomaly;
use App\Model\DepartmentManager;
use App\Model\LogManager;
use App\Entity\Log;

class LogRecorder
{

    private Log $log;
    private LogManager $logManager;
    private DepartmentManager $departmentManager;

    public function __construct()
    {
        $this->logManager = new LogManager();
        $this->departmentManager = new DepartmentManager();
        $this->log = new Log();
    }

    public function recordSignup()
    {
        $this->log->setLogName(Log::NEW_LOG);
        $this->log->setUserName($_SESSION['pseudo']);
        $this->logManager->insertNewLog($this->log);
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

    public function recordEasterEgg()
    {
        $this->log->setLogName(Log::EASTER_EGG);
        $this->logManager->insertNewLog($this->log);
    }

    public function recordPerfectAnswer()
    {
        $this->log->setLogName(Log::PERFECT_ANSWER);
        $this->logManager->insertNewLog($this->log);
    }
    public function recordLastStage()
    {
        $this->log->setLogName(Log::LAST_STAGE);
        $this->log->setIsPublic(true);
        $department = $this->departmentManager->selectOneByDeptId($_SESSION['deptId']);
        $this->log->setAssociatedText("est arrivé au dernier niveau du département " . $department['title']);
        $this->logManager->insertNewLog($this->log);
    }
    public function recordIsCheating()
    {
        $this->log->setLogName(Log::CHEAT);
        $this->log->setIsPublic(true);
        $department = $this->departmentManager->selectOneByDeptId($_SESSION['deptId']);
        $this->log->setAssociatedText("a tenté de tricher dans le département " . $department['title']);
        $this->logManager->insertNewLog($this->log);
    }
    public function recordNewFirst()
    {
        $this->log->setLogName(Log::NEW_FIRST);
        $this->log->setIsPublic(true);
        $department = $this->departmentManager->selectOneByDeptId($_SESSION['deptId']);
        $this->log->setAssociatedText("est le nouveau boss du département" . $department['title']);
        $this->logManager->insertNewLog($this->log);
    }
}
