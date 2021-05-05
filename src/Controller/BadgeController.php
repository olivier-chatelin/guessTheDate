<?php

namespace App\Controller;

use App\Model\BadgeManager;
use App\Model\ScoreManager;

class BadgeController extends AbstractController
{
    public function show()
    {
        $badgeManager = new BadgeManager();
        $badgesData = $badgeManager->showAll($_SESSION['pseudo']);
        $badgesLeftData = $badgeManager->showBadgesLeft($_SESSION['pseudo']);
        $scoreManager = new ScoreManager();
        $scores = $scoreManager->getScoresbyPseudo($_SESSION['pseudo']);
        return $this->twig->render(
            'Badge/show.html.twig',
            ['badgesData' => $badgesData, 'badgesLeftData' => $badgesLeftData, 'scores' => $scores]
        );
    }
}
