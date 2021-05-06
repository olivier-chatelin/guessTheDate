<?php

namespace App\Service;

use App\Model\UserManager;
use App\Model\BadgeManager;

class BadgeDealer
{

    public function checkFirstPerfect(int $userId, int $badgeId)
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
}
