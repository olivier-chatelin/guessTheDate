<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use App\Entity;

class ConnexionAPI
{
    public const A = 97;
    public const Z = 122;
    public const TOLERABLE_TOTAL_OF_SELECTABLE_OBJECT = 10;
    public function showRandArtPiece(int $departmentId): Entity\PickedObject
    {
        $isAnAvailableLetter = false;
        while (!$isAnAvailableLetter) {
            $randLetter = chr(rand(self::A, self::Z));
            $isAnAvailableLetter =
                $this->selectObjectsByLetter($departmentId, $randLetter)['total'] >
                self::TOLERABLE_TOTAL_OF_SELECTABLE_OBJECT;
        }

        $allObjectIds = $this->selectObjectsByLetter($departmentId, $randLetter);
        $selectedObjectId = $allObjectIds['objectIDs'][rand(1, $allObjectIds['total'])];
        $pickedObjectData = $this->showObjectById($selectedObjectId);
        $pickedObject = new Entity\PickedObject(
            $pickedObjectData['primaryImageSmall'],
            $pickedObjectData['additionalImages'],
            $pickedObjectData['department'],
            $pickedObjectData['title'],
            $pickedObjectData['artistDisplayName'],
            $pickedObjectData['artistBeginDate'],
            $pickedObjectData['artistEndDate'],
            $pickedObjectData['objectEndDate'],
            $selectedObjectId
        );
        return  $pickedObject;
    }
    public function showObjectById(int $objectId): array
    {
        $client = HttpClient::create([
            'headers' => [
                'User-Agent' => 'Wild Code School',
            ]]);
        $requestURL = 'https://collectionapi.metmuseum.org/public/collection/v1/objects/' . $objectId;
        $response = $client -> request('GET', $requestURL);
        return  $response->toArray();
    }
    public function selectObjectsByLetter(int $departmentId, string $letter): array
    {
        $client = HttpClient::create([
            'headers' => [
                'User-Agent' => 'Wild Code School',
            ]]);
        $requestURL = 'https://collectionapi.metmuseum.org/public/collection/v1/search';
        $response = $client->request('GET', $requestURL, [
            'query' => [
                'departmentId' => $departmentId,
                'hasImages' => 'true',
                'q' => $letter,
            ],
        ]);
        return $response->toArray();
    }
}
