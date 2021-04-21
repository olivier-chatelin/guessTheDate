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
use App\Service\FormChecker;



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
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formChecker = new FormChecker($_POST);
            $formChecker->cleanAll();
            $trimmedPost = $formChecker->getPost();

            if (empty($errors)) {
                $userManager = new UserManager();
                $userData = $userManager->selectOneByPseudo($trimmedPost['pseudo']);

                if ($userData === false) {
                    $errors['pseudo'] = 'Ce pseudo n\'existe pas';
                    //TODO implementer le password_verify
                } elseif ($_POST['password'] === $userData['password']) {
                    $_SESSION['id'] = $userData['id'];
                    $_SESSION['pseudo'] = $userData['pseudo'];
                    $_SESSION['is_admin'] = $userData['is_admin'];
                    header('Location: /Game/Department');
                } else {
                    $errors['password'] = 'Password incorrect';
                }
            }
        }
        return $this->twig->render('Home/index.html.twig', [
        'errors' => $errors
        ]);
    }

    public function signup()
    {
        return $this->twig->render('Home/signup.html.twig');
    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }

    public function profile()
    {
        return $this->twig->render('Home/profile.html.twig');
    }
}
