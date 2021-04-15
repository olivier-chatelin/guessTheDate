<?php

namespace App\Controller;

use App\Model\GameManager;

class GameController extends AbstractController
{
    public function department()
    {
        return $this->twig->render('Game/department.html.twig');
    }

    public function quizz()
    {
        return $this->twig->render('Game/quizz.html.twig');
    }

    public function rules()
    {
        return $this->twig->render('Game/rules.html.twig');
    }

    public function score()
    {
        return $this->twig->render('Game/score.html.twig');
    }

    public function solution()
    {
        return $this->twig->render('Game/solution.html.twig');
    }
}
