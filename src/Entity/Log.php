<?php

namespace App\Entity;

class Log
{
    public const UNKNOWN_LOG = 'Unknown';
    public const LOGIN_LOG = 'login';
    public const GAME_END_LOG = 'End of Game';
    public const CHANGE_AVATAR_LOG = 'Avatar Changed';
    public const EASTER_EGG = 'Ester_egg found';
    public const PERFECT_ANSWER = 'Perfect answer!!';
    public const NEW_LOG = 'New signup';

    private string $logName;
    private ?string $pseudo;
    private ?int $departmentNumber;
    protected bool $isAnomaly = false;

    public function __construct($logName = self::UNKNOWN_LOG)
    {
        $this->logName = $logName;
        $this->pseudo = $_SESSION['pseudo'] ?? null;
        $this->departmentNumber = $_SESSION['deptId'] ?? null;
    }

    public function getLogName(): string
    {
        return $this->logName;
    }
    public function setLogName(string $logName): Log
    {
        $this->logName = $logName;
        return $this;
    }

    public function getUserName(): ?string
    {
        return $this->pseudo;
    }

    public function setUserName(string $pseudo): Log
    {
        $this->pseudo = $pseudo;
        return $this;
    }

    public function getDepartmentNumber(): ?int
    {
        return $this->departmentNumber;
    }

    public function setDepartmentNumber(?int $departmentNumber): Log
    {
        $this->departmentNumber = $departmentNumber;
        return $this;
    }

    public function isAnomaly(): bool
    {
        return $this->isAnomaly;
    }

    public function setIsAnomaly(bool $isAnomaly): Log
    {
        $this->isAnomaly = $isAnomaly;
        return $this;
    }
}
