<?php

namespace App\Service;

use App\Model\BadgeManager;
use App\Model\UserManager;
use App\Model\ScoreManager;
use App\Service\PublicLogRecorder;

class BadgeDealer
{
    public const BADGE_PERFECT = 4;
    public const BADGE_100K = 8;
    public const BADGE_FIRSTBESTSCORE = 1;
    public const BADGE_EASTER = 10;
    public const BADGE_ALLDEPTS = 3;
    public const GAMES_NB10 = 11;
    public const GAMES_NB50 = 12;
    public const GAMES_NB100 = 13;

    public function checkBadgeAttribution(int $userId, int $badgeId)
    {
        $badgeManager = new BadgeManager();
        $alreadyGotTheBadge = $badgeManager->hasTheBadgeBeenGiven($userId, $badgeId);
        $badgeInfo = 0;

        if (!$alreadyGotTheBadge) {
            $badgeManager->giveNewBadgeToUser($userId, $badgeId);
            $badgeInfo = $badgeManager->getInfoBadgeToGive($userId, $badgeId);
        }
        return $badgeInfo;
    }

    public function checkBadgePerfect()
    {
        $shouldReceivedBadge = 0;
        if ($_SESSION['game']['status'] === 'Perfect') {
            $shouldReceivedBadge = $this->checkBadgeAttribution($_SESSION['id'], self::BADGE_PERFECT);
        }
        return $shouldReceivedBadge;
    }

    public function checkBadgeBestScore($highestScoreRecorded)
    {
        if ($_SESSION['game']['status'] === 'Game Over') {
            if ($_SESSION['game']['currentScore'] > $highestScoreRecorded) {
                $shouldReceivedBadge = 0;
                $badgeManager = new BadgeManager();
                $badgeNb = $badgeManager->linkBestScoreBadgeAndDeptNb($_SESSION['deptId']);

                $shouldReceivedBadge = $this->checkBadgeAttribution($_SESSION['id'], $badgeNb);
                return $shouldReceivedBadge;
            }
        }
    }

    public function checkBadgeGameNb()
    {
        $shouldReceiveBadge = 0;
        $userManager = new UserManager();
        $infoUser = $userManager->selectOneByPseudo($_SESSION['pseudo']);
        if ($infoUser['count_game'] >= 101) {
            $shouldReceiveBadge = $this->checkBadgeAttribution($_SESSION['id'], self::GAMES_NB100);
        } elseif ($infoUser['count_game'] >= 51) {
            $shouldReceiveBadge = $this->checkBadgeAttribution($_SESSION['id'], self::GAMES_NB50);
        } elseif ($infoUser['count_game'] >= 11) {
            $shouldReceiveBadge = $this->checkBadgeAttribution($_SESSION['id'], self::GAMES_NB10);
        }
        return $shouldReceiveBadge;
    }
}
