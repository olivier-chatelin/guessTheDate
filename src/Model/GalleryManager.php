<?php

namespace App\Model;

class GalleryManager extends AbstractManager
{
    public const TABLE = 'painting';

    public function insert(array $galleryData)
    {
        $query = "INSERT INTO " . self::TABLE .
            " (image, artist_name, end_date, title) VALUES (:image, :artist_name, :end_date, :title)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('image', $galleryData['image'], \PDO::PARAM_STR);
        $statement->bindValue('artist_name', $galleryData['artist_name'], \PDO::PARAM_STR);
        $statement->bindValue('end_date', $galleryData['end_date'], \PDO::PARAM_INT);
        $statement->bindValue('title', $galleryData['title'], \PDO::PARAM_STR);
        return $statement->execute();
    }
}
