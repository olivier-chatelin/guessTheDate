<?php

namespace App\Controller;

use App\Model\AbstractManager;
use App\Model\BadgeManager;
use App\Model\UserManager;
use App\Model\ScoreManager;

class PlayerController extends AbstractController
{
    public function show($pseudo)
    {
        $badgeManager = new BadgeManager();
        $badges = $badgeManager->showAll($pseudo);
        $scoreManager = new ScoreManager();
        $scores = $scoreManager->getScoresbyPseudo($pseudo);

        return $this->twig->render(
            'Player/showByPseudo.html.twig',
            ['badges' => $badges, 'pseudo' => $pseudo, 'scores' => $scores]
        );
    }
}
