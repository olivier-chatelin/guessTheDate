<?php


namespace App\Service;
use App\Model\UserManager;
use App\Model\BadgeManager;


class BadgeDealer
{

    public function CheckFirstPerfect(int $userId, int $badgeId)
    {
        $badgeManager = new BadgeManager();
        $alreadyGotTheBadge = $badgeManager->HasTheBadgeBeenGiven($userId, $badgeId);
        $badgeInfo = 0;
        if (!$alreadyGotTheBadge) {
            $badgeManager->GiveNewBadgeToUser($userId, $badgeId);
            $badgeInfo = $badgeManager->getInfoBadgeToGive($userId,$badgeId);
        }
        return $badgeInfo;

}


}