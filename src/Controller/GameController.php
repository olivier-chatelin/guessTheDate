<?php

namespace App\Controller;

use App\Model\AbstractManager;
use App\Model\DepartmentManager;
use App\Model\ScoreManager;
use App\Service\BadgeDealer;
use App\Service\ConnexionAPI;
use App\Service\GameChecker;
use App\Service\GameDealer;
use App\Service\LogRecorder;

class GameController extends AbstractController
{
    public const BADGE_PERFECT = 4;
    public const BADGE_100K = 8;
    public const BADGE_FIRSTBESTSCORE = 1;
    public const BADGE_EASTER = 10;
    public const BADGE_ALLDEPTS = 3;
    public const EASTER_DEPT = "21";



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
        if ($departmentId === self::EASTER_DEPT) {
            $this->PublicLogRecorder->recordEasterEgg();
        }
        $badgeDealer = new BadgeDealer();
        $badgeDealer->checkBadgeAttribution($_SESSION['id'], self::BADGE_EASTER);
        $departmentManager = new DepartmentManager();
        $availableIds = $departmentManager->getAllDepartmentNumbers();
        if (!in_array($departmentId, $availableIds)) {
            return $this->twig->render('/Errors/404.html.twig');
        }

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

            $gameChecker = new GameChecker();
            $highestScoreRecorded = $gameChecker->checkStatus();

            $badgeDealer = new BadgeDealer();
            $shouldReceiveBadge = $badgeDealer->checkBadgePerfect();
            $shouldReceiveBadge = $badgeDealer->checkBadgeBestScore($highestScoreRecorded);

            $this->twig->addGlobal('session', $_SESSION);
            $stringObjectData = json_encode($objectData);
            $_SESSION['game']['HavePointsBeenScored'] = true;
            return $this->twig->render('Game/solution.html.twig', [
                'objectData' => $objectData,
                'stringObjectData' => $stringObjectData,
                'shouldReceiveBadge' => $shouldReceiveBadge
            ]);
        }
        header('Location: /');
    }

    public function score($deptNb): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //TODO POST data to secure
            header('Location: /Game/score/' . $_POST['idDepartmentSelected']);
        }
        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAll();
        $scoreManager = new ScoreManager();
        $scores = $scoreManager->getScoresByDepartment($deptNb);

        return $this->twig->render('Game/score.html.twig', [
            'departments' => $departments,
            'deptNb' => $deptNb,
            'scores' => $scores
        ]);
    }

    public function gameover()
    {
        return $this->twig->render('Game/gameover.html.twig', []);
    }
}
