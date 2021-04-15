<?php
namespace App\Service;
use Symfony\Component\HttpClient\HttpClient;

class connexionAPI
{

    public function showRandArtPiece(int $department_nb): array
    {
        $randLetter = chr(rand(97, 122));
        $pickedObjectData = [];

        $client = HttpClient::create([
            'headers' => [
                'User-Agent' => 'Wild Code School',
            ]]);

        $response = $client->request('GET', 'https://collectionapi.metmuseum.org/public/collection/v1/search', [
            'query' => [
                'departmentId' => $department_nb,
                'hasImages' => 'true',
                'q' => $randLetter,
            ],
        ]);
        $allObjectIds = $response->toArray();

        $selectedObjectId = $allObjectIds['objectIDs'][rand(1, $allObjectIds['total'])];

        $response = $client->request('GET', 'https://collectionapi.metmuseum.org/public/collection/v1/objects/' . $selectedObjectId);
        $pickedObject = $response->toArray();


        $pickedObjectData['primaryImageSmall'] = $pickedObject['primaryImageSmall'];
        $pickedObjectData['additionalImages'] = $pickedObject['additionalImages'];
        $pickedObjectData['department'] = $pickedObject['department'];
        $pickedObjectData['title'] = $pickedObject['title'];
        $pickedObjectData['artistDisplayName'] = $pickedObject['artistDisplayName'];
        $pickedObjectData['artistBeginDate'] = $pickedObject['artistBeginDate'];
        $pickedObjectData['artistEndDate'] = $pickedObject['artistEndDate'];
        $pickedObjectData['objectEndDate'] = $pickedObject['objectEndDate'];

        return  $pickedObjectData;
    }
}



?>