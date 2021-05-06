<?php

namespace App\Service;

use App\Model\BadgeManager;

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
}
