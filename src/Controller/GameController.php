<?php

namespace App\Controller;
use App\Model\GameManager;
use App\Model\DepartmentManager;
use App\Service\connexionAPI;

class GameController extends AbstractController
{
    public function department()
    {
        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAll();
        return $this->twig->render('Game/department.html.twig', ['departments' => $departments]);
    }

    public function quizz()
    {
        $connexionAPI = new connexionAPI();
        $pickedObjectData = $connexionAPI->showRandArtPiece(1);


        return $this->twig->render('Game/quizz.html.twig',
            ['primaryImg'=> $pickedObjectData['primaryImageSmall'],
        'additionalImages' => $pickedObjectData['additionalImages'],
        'department' => $pickedObjectData['department'],
        'title' => $pickedObjectData['title'],
        'artistDisplayName' => $pickedObjectData['artistDisplayName'],
        'artistBeginDate' => $pickedObjectData['artistBeginDate'],
        'artistEndDate' => $pickedObjectData['artistEndDate'],
        'objectEndDate' => $pickedObjectData['objectEndDate']]);
    }

    public function rules()
    {
        return $this->twig->render('Game/rules.html.twig');
    }

    public function score()
    {
        return $this->twig->render('Game/score.html.twig');
    }

    public function solution()
    {
        return $this->twig->render('Game/solution.html.twig');
    }
}
