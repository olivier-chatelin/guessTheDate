<?php

namespace App\Service;

use App\Model\BadgeManager;
use App\Model\ScoreManager;
use App\Service\PublicLogRecorder;

class BadgeDealer
{
    public const BADGE_PERFECT = 4;
    public const BADGE_100K = 8;
    public const BADGE_FIRSTBESTSCORE = 1;
    public const BADGE_EASTER = 10;
    public const BADGE_ALLDEPTS = 3;

    public function checkBadgeAttribution(int $userId, int $badgeId)
    {
        $badgeManager = new BadgeManager();
        $alreadyGotTheBadge = $badgeManager->hasTheBadgeBeenGiven($userId, $badgeId);
        $badgeInfo = 0;

        if (!$alreadyGotTheBadge) {
            $badgeManager->giveNewBadgeToUser($userId, $badgeId);
            $badgeInfo = $badgeManager->getInfoBadgeToGive($userId, $badgeId);
            $publicLogRecorder = new PublicLogRecorder();
            $publicLogRecorder->recordNewBadgeGiven($badgeInfo['name']);
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

    public function checkBadgeBestScore()
    {
        if ($_SESSION['game']['status'] === 'Game Over') {
            $highestScoreRecorded = 0;
            $scoreManager = new ScoreManager();
            if ($scoreManager->getScoresByDepartment($_SESSION['deptId'])) {
                $highestScoreRecorded = (int)$scoreManager->getScoresByDepartment($_SESSION['deptId'])[0]['best_score'];
            }
            if ($_SESSION['game']['currentScore'] > $highestScoreRecorded) {
                $shouldReceivedBadge = 0;
                $badgeManager = new BadgeManager();
                $badgeNb = $badgeManager->linkBestScoreBadgeAndDeptNb($_SESSION['deptId']);

                $shouldReceivedBadge = $this->checkBadgeAttribution($_SESSION['id'], $badgeNb);
                return $shouldReceivedBadge;
            }
        }
    }
}
