<?php

namespace App\Controller;

use App\Model\GameManager;
use App\Model\DepartmentManager;
use App\Model\ScoreManager;
use App\Service\ConnexionAPI;

class GameController extends AbstractController
{
    public function department()
    {
        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAll();
        return $this->twig->render('Game/department.html.twig', ['departments' => $departments]);
    }

    public function quizz($id)
    {
        $connexionAPI = new ConnexionAPI();

        $pickedObjectData = $connexionAPI->showRandArtPiece($id);


        return $this->twig->render(
            'Game/quizz.html.twig',
            ['primaryImg' => $pickedObjectData['primaryImageSmall'],
            'additionalImages' => $pickedObjectData['additionalImages'],
            'id' => $id,
            'department' => $pickedObjectData['department'],
            'title' => $pickedObjectData['title'],
            'artistDisplayName' => $pickedObjectData['artistDisplayName'],
            'artistBeginDate' => $pickedObjectData['artistBeginDate'],
            'artistEndDate' => $pickedObjectData['artistEndDate'],
            'objectEndDate' => $pickedObjectData['objectEndDate'],
            'objectId' => $pickedObjectData['objectId'],]
        );
    }

    public function rules()
    {
        return $this->twig->render('Game/rules.html.twig');
    }

    public function score($idSelected)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO POST data to secure
            header('Location: /Game/score/' . $_POST['idDepartmentSelected']);
        }

        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAll();
        $scoreManager = new ScoreManager();
        $scores = $scoreManager->getScoresByDepartment($idSelected);
        return $this->twig->render('Game/score.html.twig', [
            'departments' => $departments,
            'idSelected' => $idSelected,
            'scores' => $scores
        ]);
    }

    public function solution()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $connexionApi = new ConnexionAPI();
            $objectData = $connexionApi->showObjectById($_POST['objectId']);
            return $this->twig->render(
                'Game/solution.html.twig',
                ['answer' => $_POST['answer'],
                'objectData' => $objectData,
                'deptId' => $_POST['department'],
                    ]
            );
        }
        header('Location: /');
    }
}
