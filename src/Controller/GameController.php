<?php

namespace App\Controller;

use App\Model\GameManager;
use App\Model\DepartmentManager;
use App\Model\ScoreManager;
use App\Service\ConnexionAPI;
use App\Service\GameDealer;

class GameController extends AbstractController
{
    public function department(): string
    {
        if (!isset($_SESSION['pseudo'])) {
            header('Location: /');
        }

        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAll();
        $_SESSION['numQuestion'] = 1;
        $_SESSION['currentScore'] = 0;

        return $this->twig->render('Game/department.html.twig', ['departments' => $departments]);
    }

    public function quizz($departmentId): string
    {
        $_SESSION['deptId'] = $departmentId;
        $gameDealer = new GameDealer();
        $initialErrorMargin = $gameDealer->getInitialGameErrorMargin();

   /*     if ($_SESSION['gameStatus'] === 'Game Over') {
                //TODO envoie best score

        }*/

        $connexionAPI = new ConnexionAPI();
        $pickedObject = $connexionAPI->showRandArtPiece(intval($departmentId));

        return $this->twig->render(
            'Game/quizz.html.twig',
            ['pickedObject' => $pickedObject,
                'departmentId' => $departmentId,
                'initialErrorMargin' => $initialErrorMargin]
        );
    }

    public function score($idSelected): string
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
            $objectData = $connexionApi->showObjectById(intval($_POST['objectId']));

            $gameDealer = new GameDealer();
            $questionStatus = $gameDealer->AnswerScoring(
                $_SESSION['numQuestion'],
                $_POST['answer'],
                $objectData['objectEndDate']
            );
            $_SESSION['currentScore'] = $_SESSION['currentScore'] + $questionStatus['nbPoints'];
            $_SESSION['gameStatus'] = $questionStatus['gameStatus'];
            $_SESSION['numQuestion']++;
            $_SESSION['currentErrorMargin'] = $questionStatus['currentErrorMargin'];

            return $this->twig->render(
                'Game/solution.html.twig',
                ['answer' => $_POST['answer'],
                    'objectData' => $objectData,
                    'deptId' => $_POST['department'],
                    'totalScore' => $_SESSION['currentScore'],
                    'questionStatus' => $questionStatus
                ]
            );
        }
        header('Location: /');
    }
}
