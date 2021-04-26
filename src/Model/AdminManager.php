<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'user';

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
            "SELECT b.id, b.image FROM user u 
            LEFT JOIN user_badge ub ON u.id = ub.user_id
            LEFT JOIN badge b ON ub.badge_id = b.id
            WHERE u.pseudo = :pseudo;";
        $statement = $this->pdo->prepare($query2);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        $badgeInfos = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $badges = [];
        foreach ($badgeInfos as $badgeInfo) {
            $badges[$badgeInfo['id']] = $badgeInfo['image'];
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
        $query4 =
            "SELECT id,image FROM badge
            WHERE image NOT IN(
            SELECT  b.image FROM user u
            JOIN user_badge ub ON u.id = ub.user_id 
            JOIN badge b ON ub.badge_id = b.id
            WHERE u.pseudo = :pseudo)";
        $statement = $this->pdo->prepare($query4);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        $badgesLeft = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $availableBadges = [];
        foreach ($badgesLeft as $badgeLeft) {
            $availableBadges[$badgeLeft['id']] = $badgeLeft['image'];
        }
        return ['profileInfo' => $profileInfos,
                'badges' => $badges,
                'scores' => $scores,
                'availableBadges' => $availableBadges
                ];
    }
    public function getNames(): array
    {
        $statement = $this->pdo->query('SELECT pseudo FROM user');
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    public function deleteBadge(string $pseudo, string $id)
    {
        $query = "DELETE  ub FROM user_badge ub
                JOIN user u ON ub.user_id = u.id
                JOIN badge b ON ub.badge_id = b.id
                WHERE u.pseudo = :pseudo AND b.id = :id";
        $statement = $this->pdo->prepare($query);

        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->bindValue('id', $id, \PDO::PARAM_STR);
        $statement->execute();
    }
    public function addBadge(string $idUser, string $idBadge)
    {
        $query = "INSERT INTO user_badge (user_id, badge_id) VALUES (:idUser,:idBadge)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('idUser', $idUser, \PDO::PARAM_STR);
        $statement->bindValue('idBadge', $idBadge, \PDO::PARAM_STR);
        $statement->execute();
    }
}
