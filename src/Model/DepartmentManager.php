<?php

namespace App\Model;

class DepartmentManager extends AbstractManager
{
    public const TABLE = 'department';

    public function updateGameParameters($deptId, $pointUnit, $initialErrorMargin): bool
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET 
            'point_unit' = :point_unit, 
            'initial_error_margin' = :initial_error_margin
             WHERE id = :id"
        );
        $statement->bindValue('point_unit', $pointUnit, \PDO::PARAM_INT);
        $statement->bindValue('initial_error_margin', $initialErrorMargin, \PDO::PARAM_INT);
        $statement->bindValue('id', $deptId, \PDO::PARAM_INT);
        return $statement->execute();
    }
}
