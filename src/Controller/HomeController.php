<?php

/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\UserManager;
use App\Service\FormChecker;

class HomeController extends AbstractController
{


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
                } elseif (password_verify($_POST['password'], $userData['password'])) {
                    $_SESSION['id'] = $userData['id'];
                    $_SESSION['pseudo'] = $userData['pseudo'];
                    $_SESSION['is_admin'] = $userData['is_admin'];
                    $userManager = new UserManager();
                    $_SESSION['avatar'] = $userManager->getAvatarById($_SESSION['id'])['image'];

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
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formChecker = new FormChecker($_POST);
            $formChecker->cleanAll();
            $trimmedPost = $formChecker->getPost();

            $formChecker->checkInputPattern($trimmedPost['pseudo'], 'pseudo', 'alnum');
            $formChecker->checkInputLength($trimmedPost['pseudo'], 'pseudo', 1, FormChecker::PSEUDO_LENGTH);

            $formChecker->checkInputPattern($trimmedPost['password'], 'password');
            $formChecker->checkInputLength($trimmedPost['password'], 'password', 1);


            $errors = $formChecker->getErrors();
            $userData = $formChecker->getPost();

            if (empty($errors)) {
                $userData['pseudo'] = ucfirst(strtolower($userData['pseudo']));
                $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);

                $userManager = new UserManager();
                $errors = $userManager->create($userData);

                if (empty($errors)) {
                    $userData = $userManager->selectOneByPseudo($userData['pseudo']);
                    $_SESSION['id'] = $userData['id'];
                    $_SESSION['pseudo'] = $userData['pseudo'];
                    $_SESSION['is_admin'] = $userData['is_admin'];
                    header('Location: /Game/department');
                }
            }
        }
        return $this->twig->render('Home/signup.html.twig', ['errors' => $errors]);
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
