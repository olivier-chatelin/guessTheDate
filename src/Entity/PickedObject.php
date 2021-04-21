<?php

namespace App\Entity;

class PickedObject
{
    private string $primaryImageSmall;
    private array $additionalImages;
    private string $department;
    private string $title;
    private string $artistDisplayName;
    private string $artistBeginDate;
    private string $artistEndDate;
    private string $objectEndDate;
    private string $objectId;

    public function __construct(
        $primaryImageSmall,
        $additionalImages,
        $department,
        $title,
        $artistDisplayName,
        $artistBeginDate,
        $artistEndDate,
        $objectEndDate,
        $objectId
    ) {
        $this->primaryImageSmall = $primaryImageSmall;
        $this->additionalImages = $additionalImages;
        $this->department = $department;
        $this->title = $title;
        $this->artistDisplayName = $artistDisplayName;
        $this->artistBeginDate = $artistBeginDate;
        $this->artistEndDate = $artistEndDate;
        $this->objectEndDate = $objectEndDate;
        $this->objectId = $objectId;
    }

    public function getPrimaryImageSmall(): string
    {
        return $this->primaryImageSmall;
    }
    public function setPrimaryImageSmall(string $primaryImageSmall): void
    {
        $this->primaryImageSmall = $primaryImageSmall;
    }
    public function getAdditionalImages(): array
    {
        return $this->additionalImages;
    }
    public function setAdditionalImages(array $additionalImages): void
    {
        $this->additionalImages = $additionalImages;
    }
    public function getDepartment(): string
    {
        return $this->department;
    }
    public function setDepartment(string $department): void
    {
        $this->department = $department;
    }
    public function getTitle(): string
    {
        return $this->title;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function getArtistDisplayName(): string
    {
        return $this->artistDisplayName;
    }
    public function setArtistDisplayName(string $artistDisplayName): void
    {
        $this->artistDisplayName = $artistDisplayName;
    }
    public function getArtistBeginDate(): string
    {
        return $this->artistBeginDate;
    }
    public function setArtistBeginDate(string $artistBeginDate): void
    {
        $this->artistBeginDate = $artistBeginDate;
    }
    public function getArtistEndDate(): string
    {
        return $this->artistEndDate;
    }
    public function setArtistEndDate(string $artistEndDate): void
    {
        $this->artistEndDate = $artistEndDate;
    }
    public function getObjectEndDate(): string
    {
        return $this->objectEndDate;
    }
    public function setObjectEndDate(string $objectEndDate): void
    {
        $this->objectEndDate = $objectEndDate;
    }
    public function getObjectId(): string
    {
        return $this->objectId;
    }
    public function setObjectId(string $objectId): void
    {
        $this->objectId = $objectId;
    }
}
