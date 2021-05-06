<?php

namespace App\Model;

class GalleryManager extends AbstractManager
{
    public const TABLE = 'painting';

    public function insert(array $galleryData): int
    {
        $query = "INSERT INTO " . self::TABLE .
            " (image, artist_name, end_date, title) VALUES (:image, :artist_name, :end_date, :title)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('image', $galleryData['primaryImageSmall'], \PDO::PARAM_STR);
        $statement->bindValue('artist_name', $galleryData['artistDisplayName'], \PDO::PARAM_STR);
        $statement->bindValue('end_date', $galleryData['objectEndDate'], \PDO::PARAM_INT);
        $statement->bindValue('title', $galleryData['title'], \PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function attributePainting(string $idUser, int $paintingId)
    {
        $query = "INSERT INTO user_paint (user_id, paint_id) VALUES (:idUser, :paintingId)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('idUser', $idUser, \PDO::PARAM_STR);
        $statement->bindValue('paintingId', $paintingId, \PDO::PARAM_STR);
        $statement->execute();
    }

    public function showPaintingByPseudo($pseudo)
    {
        $query = "
                SELECT p.image, p.artist_name, p.end_date, p.title FROM painting p
                 JOIN user_paint up ON p.id = up.paint_id
                 JOIN  user u ON up.user_id = u.id
                 WHERE u.pseudo= :pseudo";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
