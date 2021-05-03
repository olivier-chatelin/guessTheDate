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
            JOIN user_badge ub ON u.id = ub.user_id
            JOIN badge b ON ub.badge_id = b.id
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
            JOIN user_department ud ON u.id = ud.user_id
            JOIN department d ON ud.department_id = d.id
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
        $query5 =
            "SELECT a.id,a.image FROM avatar a
            WHERE a.id NOT IN(
            SELECT  u.avatar_id FROM user u
            JOIN avatar a ON u.avatar_id = a.id
            WHERE u.pseudo = :pseudo)";
        $statement = $this->pdo->prepare($query5);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        $avatarsLeft = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $availableAvatars = [];
        foreach ($avatarsLeft as $avatarLeft) {
            $availableAvatars[$avatarLeft['id']] = $avatarLeft['image'];
        }
        return ['profileInfo' => $profileInfos,
                'badges' => $badges,
                'scores' => $scores,
                'availableBadges' => $availableBadges,
                'availableAvatars' => $availableAvatars
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

    public function changeIsAdminSatus($pseudo)
    {
        $query = "SELECT is_admin FROM user WHERE pseudo=:pseudo";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        $isAdminValue = $statement->fetch(\PDO::FETCH_COLUMN);
        $newValue = $isAdminValue ? '0' : '1';
        $query = "UPDATE user SET is_admin = " . $newValue . " WHERE pseudo=:pseudo";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
    }
    public function changeAvatar(string $pseudo, string $idAvatar)
    {
        $query = "UPDATE user SET avatar_id = :idAvatar WHERE pseudo = :pseudo";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->bindValue('idAvatar', $idAvatar, \PDO::PARAM_STR);
        $statement->execute();
    }
    public function getAvatarbiId(string $idAvatar): array
    {
        $query = "SELECT * FROM avatar WHERE id = :idAvatar";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('idAvatar', $idAvatar, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }
    public function getNextBadgeId(): int
    {
        $query = "SELECT id FROM badge ORDER BY id DESC LIMIT 1";
        $statement = $this->pdo->query($query);
        $lastId = $statement->fetch(\PDO::FETCH_COLUMN);
        return $lastId + 1;
    }
    public function getBadgesGroup(): array
    {
        $query =
            "SELECT b.id, count(*) as total FROM badge b
            JOIN user_badge ub ON ub.badge_id = b.id 
            GROUP BY b.id 
            ORDER BY b.id ASC ";
        $statement = $this->pdo->query($query);
        $badgeGroup =  $statement->fetchAll(\PDO::FETCH_ASSOC);
        $badges = [];
        foreach ($badgeGroup as $badge) {
            $badges[$badge['id']] = $badge['total'];
        }
        return $badges;
    }

    public function getBadgesDistributionbyId($badgeId)
    {
        $query =
            "SELECT u.pseudo FROM badge b
            JOIN user_badge ub ON b.id = ub.badge_id
            JOIN user u ON ub.user_id = u.id
            WHERE b.id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('id', $badgeId, \PDO::PARAM_STR);
        $statement->execute();
        return   $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
    public function getBadges()
    {
        $query = "SELECT * FROM badge";
        $statement = $this->pdo->query($query);
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function showAllbadgesAndUsers()
    {
        $result = [];
        $badges = $this->getBadges();
        foreach ($badges as $badge) {
            $result[$badge['id']]['image'] = $badge['image'];
        }
        $badgesGrouped = $this->getBadgesGroup();
        foreach ($badgesGrouped as $id => $total) {
            $result[$id]['total'] = $total;
            $result[$id]['givenTo'] = $this->getBadgesDistributionbyId($id);
        }

        return $result;
    }
    public function insertBadge(string $name)
    {
        $query = "INSERT INTO badge (image) VALUES (:image)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('image', $name, \PDO::PARAM_STR);
        $statement->execute();
    }

    public function getBadgeImagebyId(string $badgeId): string
    {
        $statement = $this->pdo->prepare("SELECT image FROM badge WHERE id=:id");
        $statement->bindValue('id', $badgeId, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch(\PDO::FETCH_COLUMN);
    }
    public function deleteBadgebyImage(string $image)
    {
        $statement = $this->pdo->prepare("DELETE  FROM badge WHERE image =:image");
        $statement->bindValue('image', $image, \PDO::PARAM_STR);
        $statement->execute();
    }
}
