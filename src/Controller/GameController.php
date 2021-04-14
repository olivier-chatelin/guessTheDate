<?php

namespace App\Controller;

use App\Model\GameManager;
use App\Model\DepartmentManager;

class GameController extends AbstractController
{
    public function department()
    {
        $departmentManager = new DepartmentManager();
        $departments = $departmentManager->selectAll();
        return $this->twig->render('Game/department.html.twig',['departments'=> $departments]);
    }

    public function quizz($id)
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
}
