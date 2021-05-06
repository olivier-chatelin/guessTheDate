<?php

namespace App\Model;

use App\Entity\Log;

class LogManager extends AbstractManager
{
    public const TABLE = 'log';

    public function insertNewLog(Log $log): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (

        log_name, pseudo, dept_nb, is_anomaly, created_at, is_public, associated_text) VALUES (
        :logName, :pseudo, :deptNb, :isAnomaly, NOW(), :isPublic, :associatedText)");
        $statement->bindValue(':logName', $log->getLogName(), \PDO::PARAM_STR);
        $statement->bindValue(':pseudo', $log->getUserName(), \PDO::PARAM_STR);
        $statement->bindValue(':deptNb', $log->getDepartmentNumber(), \PDO::PARAM_INT);
        $statement->bindValue(':isAnomaly', $log->isAnomaly(), \PDO::PARAM_BOOL);
        $statement->bindValue(':isPublic', $log->isPublic(), \PDO::PARAM_BOOL);
        $statement->bindValue(':associatedText', $log->getAssociatedText(), \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    public function countByLogNameAndByPeriod(string $logName, string $startDate, string $endDate): array
    {
        $query =
            "SELECT  DATE_FORMAT(created_at,\"%d/%m/%Y\") AS `date`, COUNT(*) AS total FROM log 
            WHERE log_name = :logName AND created_at 
            BETWEEN :startDate AND :endDate 
            GROUP BY `date`";
        $statement = $this->pdo->prepare($query);
        $statement-> bindValue('logName', $logName, \PDO::PARAM_STR);
        $statement-> bindValue('startDate', $startDate, \PDO::PARAM_STR);
        $statement-> bindValue('endDate', $endDate, \PDO::PARAM_STR);
        $statement->execute();
        return  $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getLogsALl(): array
    {
        $query = "SELECT DISTINCT log_name FROM log";
        $statement = $this->pdo->query($query);
        return  $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function getLogsbyLogNamesInAPeriod(array $parameters)
    {
        $whereCondition = "";
        $logsLength = count($parameters['logsToFollow']);
        foreach ($parameters['logsToFollow'] as $index => $logName) {
            $whereCondition .= "log_name = :logNAme" . $index;
            if ($index < $logsLength - 1) {
                $whereCondition .= " OR ";
            }
        }
        $query = "SELECT * FROM log 
                WHERE " . $whereCondition . " 
                AND created_at BETWEEN :startDate 
                AND :endDate ORDER BY created_at DESC";
        $statement = $this->pdo->prepare($query);
        foreach ($parameters['logsToFollow'] as $index => $logName) {
            $statement->bindValue("logNAme" . $index, $logName, \PDO::PARAM_STR);
        }
            $statement->bindValue("startDate", $_POST['startDate'], \PDO::PARAM_STR);
            $statement->bindValue("endDate", $_POST['endDate'], \PDO::PARAM_STR);

        $statement->execute();
        return  $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLast5PublicLogs(): array
    {
        $query = "SELECT pseudo, associated_text FROM log
                   WHERE is_public = 1 ORDER BY created_at DESC LIMIT 5";
        $statement = $this->pdo->query($query);
        return $statement->fetchAll();
    }
}
