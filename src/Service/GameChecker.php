<?php

namespace App\Service;

use App\Model\ScoreManager;

class GameChecker
{

    public const BADGE_PERFECT = 4;
    public const BADGE_100K = 8;
    public const BADGE_FIRSTBESTSCORE = 1;
    public const BADGE_EASTER = 10;
    public const BADGE_ALLDEPTS = 3;

    public function checkStatus()
    {
        $shouldReceivedBadge = 0;
        if ($_SESSION['game']['status'] === 'Perfect') {
            $badgeDealer = new BadgeDealer();
            $shouldReceivedBadge = $badgeDealer->checkFirstPerfect($_SESSION['id'], self::BADGE_PERFECT);
        }

        if ($_SESSION['game']['status'] === 'Game Over') {
            $scoreManager = new ScoreManager();
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
        }
        return $shouldReceivedBadge;
    }
}
