<?php

namespace App\Controller;

class ErrorController extends AbstractController
{
    public function notFund()
    {
        return $this->twig->render('Errors/404.html.twig');
    }

    public function cheater()
    {
        return $this->twig->render('Errors/cheater.html.twig');
    }
}
