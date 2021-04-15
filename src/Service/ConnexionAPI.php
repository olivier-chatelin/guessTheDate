<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class ConnexionAPI
{

    public function showRandArtPiece(int $departmentNb): array
    {
        $randLetter = chr(rand(97, 122));
        $pickedObjectData = [];

        $client = HttpClient::create([
            'headers' => [
                'User-Agent' => 'Wild Code School',
            ]]);
        $requestURL = 'https://collectionapi.metmuseum.org/public/collection/v1/search';
        $response = $client->request('GET', $requestURL, [
            'query' => [
                'departmentId' => $departmentNb,
                'hasImages' => 'true',
                'q' => $randLetter,
            ],
        ]);
        $allObjectIds = $response->toArray();

        $selectedObjectId = $allObjectIds['objectIDs'][rand(1, $allObjectIds['total'])];

        $requestURL = 'https://collectionapi.metmuseum.org/public/collection/v1/objects/';
        $response = $client->request('GET', $requestURL . $selectedObjectId);
        $pickedObject = $response->toArray();


        $pickedObjectData['primaryImageSmall'] = $pickedObject['primaryImageSmall'];
        $pickedObjectData['additionalImages'] = $pickedObject['additionalImages'];
        $pickedObjectData['department'] = $pickedObject['department'];
        $pickedObjectData['title'] = $pickedObject['title'];
        $pickedObjectData['artistDisplayName'] = $pickedObject['artistDisplayName'];
        $pickedObjectData['artistBeginDate'] = $pickedObject['artistBeginDate'];
        $pickedObjectData['artistEndDate'] = $pickedObject['artistEndDate'];
        $pickedObjectData['objectEndDate'] = $pickedObject['objectEndDate'];
        $pickedObjectData['objectId'] = $selectedObjectId;
        return  $pickedObjectData;
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
}
