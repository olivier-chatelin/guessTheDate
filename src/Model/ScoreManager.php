<?php

namespace App\Model;

class ScoreManager extends AbstractManager
{
    public function getScoresByDepartment(int $idDepartment): array
    {
        $query = "SELECT u.pseudo ,  ud.best_score , u.avatar_id FROM user u
            JOIN user_department ud ON u.id = ud.user_id
            JOIN department d ON ud.department_id = d.id
            WHERE d.id = :id
            ORDER BY ud.best_score DESC LIMIT 50";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $idDepartment, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
