<?php

namespace App\Model;

class UserDepartmentManager
{
    public const TABLE = 'user_department';

    /*public function findScoreByUserDept(int $userId, int $deptId, int $bestScore): bool
    {
        $query = "UPDATE " . user_department . " SET `user_id` = :title WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    public function updateBestScoreByUserDept(int $userId, int $deptId, int $bestScore): bool
    {
        $query = "UPDATE " . user_department . " SET `user_id` = :title WHERE id=:id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }*/
}
