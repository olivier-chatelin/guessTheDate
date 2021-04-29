<?php

namespace App\Model;

class ScoreManager extends AbstractManager
{
    public const MAXDISPLAY = 50;
    public const TABLE = 'user_department';

    public function getScoresByDepartment(int $idDepartment): array
    {
        $query = "SELECT u.pseudo ,  ud.best_score , u.avatar_id FROM user u
            JOIN user_department ud ON u.id = ud.user_id
            JOIN department d ON ud.department_id = d.dept_nb
            WHERE d.id = :id
            ORDER BY ud.best_score DESC LIMIT " . self::MAXDISPLAY;
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $idDepartment, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function checkScoreAlreadyExists(int $userId, int $deptId): array
    {
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE user_id=:userId AND department_id=:deptId ';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':deptId', $deptId, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function updateBestScoreByUserDept(int $userId, int $deptId, int $bestScore): bool
    {
        $query = 'UPDATE ' . self::TABLE . ' SET best_score=:bestScore WHERE user_id=:userId AND department_id=:deptId';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':bestScore', $bestScore, \PDO::PARAM_INT);
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':deptId', $deptId, \PDO::PARAM_STR);
        $statement->bindValue(':bestScore', $bestScore, \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function insertNewBestScoreOnDept(int $userId, int $deptId, int $bestScore): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (user_id, department_id, best_score) 
        VALUES (:userId, :deptId, :bestScore)");
        $statement->bindValue(':userId', $userId, \PDO::PARAM_INT);
        $statement->bindValue(':deptId', $deptId, \PDO::PARAM_STR);
        $statement->bindValue(':bestScore', $bestScore, \PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
