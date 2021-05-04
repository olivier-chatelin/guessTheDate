<?php

namespace App\Controller;

use App\Model\BadgeManager;

class BadgeController extends AbstractController
{
    public function show()
    {
        $badgeManager = new BadgeManager();
        $badgesData = $badgeManager->showAll($_SESSION['pseudo']);
        $badgesLeftData = $badgeManager->showBadgesLeft($_SESSION['pseudo']);
        return $this->twig->render(
            'Badge/show.html.twig',
            ['badgesData' => $badgesData, 'badgesLeftData' => $badgesLeftData]
        );
    }
}
