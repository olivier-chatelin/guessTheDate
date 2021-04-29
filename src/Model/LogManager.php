<?php

namespace App\Model;

use App\Entity\Log;

class LogManager extends AbstractManager
{
    public const TABLE = 'log';

    public function insertNewLog(Log $log): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (

        log_name, pseudo, dept_nb, is_anomaly, created_at) VALUES (
        :logName, :pseudo, :deptNb, :isAnomaly, NOW())");
        $statement->bindValue(':logName', $log->getLogName(), \PDO::PARAM_STR);
        $statement->bindValue(':pseudo', $log->getUserName(), \PDO::PARAM_STR);
        $statement->bindValue(':deptNb', $log->getDepartmentNumber(), \PDO::PARAM_INT);
        $statement->bindValue(':isAnomaly', $log->isAnomaly(), \PDO::PARAM_BOOL);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
