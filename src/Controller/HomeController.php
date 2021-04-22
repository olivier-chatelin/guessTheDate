<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\HomeManager;
use App\Model\UserManager;

class HomeController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        return $this->twig->render('Home/index.html.twig');
    }

    public function signup()
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userData = [];
            $userData['pseudo'] = strtolower($_POST['pseudo']);
            $userData['pseudo'] = ucfirst($_POST['pseudo']);
            $userData['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $userManager = new UserManager();
            $errors = $userManager->create($userData);
            if (empty($errors)) {
                header('Location: /Game/department');
            }
        }

        return $this->twig->render('Home/signup.html.twig', ['errors' => $errors]);
    }
}
