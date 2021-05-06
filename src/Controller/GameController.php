<?php

namespace App\Controller;

use App\Model\AbstractManager;
use App\Model\DepartmentManager;
use App\Model\ScoreManager;
use App\Service\BadgeDealer;
use App\Service\ConnexionAPI;
use App\Service\GameDealer;
use App\Service\LogRecorder;

class GameController extends AbstractController
{
    public const BADGE_PERFECT = 4;
    public const BADGE_100K = 8;
    public const BADGE_FIRSTBESTSCORE = 1;
    public const BADGE_EASTER = 10;
    public const BADGE_ALLDEPTS = 3;



    public function department(): string
    {
        if (!isset($_SESSION['pseudo'])) {
            header('Location: /');
        }
        $_SESSION['game']['status'] = 'ToStart';
        $_SESSION['game']['ac'] = 0;
        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAll();


        return $this->twig->render('Game/department.html.twig', ['departments' => $departments]);
    }

    public function quizz($departmentId): string
    {

        if (($_SESSION['game']['status'] === 'ToStart') || ($_SESSION['game']['status'] === 'Game Over')) {
            $_SESSION['deptId'] = intval($departmentId);
            $_SESSION['game']['numQuestion'] = 1;
            $_SESSION['game']['currentScore'] = 0;
            $_SESSION['game']['diff'] = $_SESSION['game']['currentErrorMargin'] = $_SESSION['game']['nbPoints'] = null;
            $_SESSION['game']['userAnswer'] = $_SESSION['game']['rightAnswer'] = null;
            $gameDealer = new GameDealer();
        } else {
            $_SESSION['game']['numQuestion']++;
        }
        $gameDealer = new GameDealer();
        $_SESSION['game']['currentErrorMargin'] = $gameDealer->getGameErrorMargin();
        $connexionAPI = new ConnexionAPI();
        $pickedObject = $connexionAPI->getInfoArtPieceToShow($departmentId);
        if ($_SESSION['game']['ac'] === 0) {
            $_SESSION['game']['acArt'] = $pickedObject->getObjectId();
            $_SESSION['game']['ac'] = 1;
        }
        $_SESSION['game']['HavePointsBeenScored'] = false;
        $this->twig->addGlobal('session', $_SESSION);
        return $this->twig->render('Game/quizz.html.twig', ['pickedObject' => $pickedObject]);
    }

    public function solution()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if ($_SESSION['game']['acArt'] !== $_POST['objectId']) {
                $this->PublicLogRecorder->recordIsCheating();
                header('Location: /Error/cheater');
            }
            $_SESSION['game']['ac'] = 0;
            $connexionApi = new ConnexionAPI();
            $objectData = $connexionApi->showObjectById(intval($_POST['objectId']));
            $gameDealer = new GameDealer();
            $gameDealer->scoreByAnswer($_POST['answer'], $objectData['objectEndDate']);

            if ($_SESSION['game']['HavePointsBeenScored'] === false) {
                $_SESSION['game']['currentScore'] = $_SESSION['game']['currentScore'] + $_SESSION['game']['nbPoints'];
            }
            $shouldReceivedBadge = 0;
            if ($_SESSION['game']['status'] === 'Perfect') {
                $badgeDealer = new BadgeDealer();
                $shouldReceivedBadge = $badgeDealer->checkFirstPerfect($_SESSION['id'], self::BADGE_PERFECT);
            }

            if ($_SESSION['game']['status'] === 'Game Over') {
                $scoreManager = new ScoreManager();
                $departmentManager = new DepartmentManager();
                $deptId = $departmentManager->selectOneByDeptId($_SESSION['deptId'])['id'];
                $highestScoreRecorded = 0;
                if ($scoreManager->getScoresByDepartment($deptId)) {
                    $highestScoreRecorded = (int)$scoreManager->getScoresByDepartment($deptId)[0]['best_score'];
                }
                $scores = $scoreManager->checkScoreAlreadyExists($_SESSION['id'], $_SESSION['deptId']);
                if (empty($scores)) {
                    $scoreManager = new ScoreManager();
                    $scoreManager->insertNewBestScoreOnDept(
                        $_SESSION['id'],
                        $_SESSION['deptId'],
                        $_SESSION['game']['currentScore']
                    );
                } elseif ($_SESSION['game']['currentScore'] > $scores[0]['best_score']) {
                    $scoreManager = new ScoreManager();
                    $scoreManager->updateBestScoreByUserDept(
                        $_SESSION['id'],
                        $_SESSION['deptId'],
                        $_SESSION['game']['currentScore']
                    );
                }
                if ($_SESSION['game']['currentScore'] > $highestScoreRecorded) {
                    $this->PublicLogRecorder->recordNewFirst();
                }
            }
            $this->twig->addGlobal('session', $_SESSION);
            $stringObjectData = json_encode($objectData);
            $_SESSION['game']['HavePointsBeenScored'] = true;
            return $this->twig->render('Game/solution.html.twig', [
                'objectData' => $objectData,
                'stringObjectData' => $stringObjectData,
                'shouldReceiveBadge' => $shouldReceivedBadge
            ]);
        }
        header('Location: /');
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

    public function gameover()
    {
        return $this->twig->render('Game/gameover.html.twig', []);
    }
}
