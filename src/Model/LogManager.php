<?php

namespace App\Model;

class LogManager extends AbstractManager
{
    public const TABLE = 'Logs';

    public function insertNewLog(string $logName, int $userId, int $deptId, $logValue): int
    {

        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (
        log_name, user_id, department_id, log_value, created_at) VALUES (
        :logName, :userId, :deptId, :logValue, NOW())");
        $statement->bindValue(':logName', $logName, \PDO::PARAM_INT);
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':deptId', $deptId, \PDO::PARAM_INT);
        $statement->bindValue(':logValue', $logValue, \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
