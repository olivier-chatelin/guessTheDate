<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'user';

    public function insert(array $user)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (pseudo, 
             password, 
             avatar_id, 
             count_game, 
             created_at, 
             updated_at, 
             is_admin )
            VALUES (:pseudo, :password, :avatar_id, :count_game, :created_at, :updated_at, :is_admin)"
        );
        $statement->bindValue('pseudo', $user['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('avatar_id', $user['avatar_id'], \PDO::PARAM_INT);
        $statement->bindValue('count_game', $user['count_game'], \PDO::PARAM_INT);
        $statement->bindValue('created_at', $user['created_at'], \PDO::PARAM_STR);
        $statement->bindValue('updated_at', $user['updated_at'], \PDO::PARAM_STR);
        $statement->bindValue('is_admin', $user['is_admin'], \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function update($user)
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET 
            pseudo = :pseudo, 
            password = :password, 
            avatar_id = :avatar_id, 
            count_game = :count_game, 
            created_at = :created_at,
             updated_at = :updated_at,
             is_admin = :is_admin
             WHERE id = :id"
        );
        $statement->bindValue('id', $user['id'], \PDO::PARAM_INT);
        $statement->bindValue('pseudo', $user['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('avatar_id', $user['avatar_id'], \PDO::PARAM_INT);
        $statement->bindValue('count_game', $user['count_game'], \PDO::PARAM_INT);
        $statement->bindValue('created_at', $user['created_at'], \PDO::PARAM_STR);
        $statement->bindValue('updated_at', $user['updated_at'], \PDO::PARAM_STR);
        $statement->bindValue('is_admin', $user['is_admin'], \PDO::PARAM_INT);
        $statement->execute();
    }
    public function getInfosByPseudo($pseudo)
    {
        $query1 =
            "SELECT u.id, u.pseudo, a.image, u.count_game, u.created_at, updated_at, is_admin 
            FROM user u 
            LEFT JOIN avatar a ON u.avatar_id = a.id
            WHERE u.pseudo = :pseudo";
        $statement = $this->pdo->prepare($query1);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        $profileInfos = $statement->fetch(\PDO::FETCH_ASSOC);
        $query2 =
            "SELECT b.image FROM user u 
            LEFT JOIN user_badge ub ON u.id = ub.user_id
            LEFT JOIN badge b ON ub.badge_id = b.id
            WHERE u.pseudo = :pseudo;";
        $statement = $this->pdo->prepare($query2);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        $badgeInfos = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $badges = [];
        foreach ($badgeInfos as $badgeInfo) {
            $badges[] = $badgeInfo['image'];
        }
        $query3 =
            "SELECT d.title, ud.best_score FROM user u
            LEFT JOIN user_department ud ON u.id = ud.user_id
            LEFT JOIN department d ON ud.department_id = d.id
            WHERE u.pseudo = :pseudo";
        $statement = $this->pdo->prepare($query3);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        $scoreInfos = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $scores = [];
        foreach ($scoreInfos as $score) {
            $scores[$score['title']] =  $score['best_score'];
        }
        return ['profileInfo' => $profileInfos,
                'badges' => $badges,
                'scores' => $scores
                ];
    }
    public function getNames()
    {
        $statement = $this->pdo->query('SELECT pseudo FROM user');
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
}
