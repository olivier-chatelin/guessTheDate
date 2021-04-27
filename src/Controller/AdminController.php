<?php

namespace App\Controller;

use App\Model\AbstractManager;
use App\Model\AdminManager;
use App\Model\DepartmentManager;
use App\Model\GameAdminManager;
use App\Model\UserManager;
use App\Service\FormChecker;

class AdminController extends AbstractController
{

    public function deleteBadge(string $pseudo, string $id)
    {
        $adminManager = new AdminManager();
        $adminManager->deleteBadge($pseudo, $id);
        header('Location: /admin/show/' . $pseudo);
    }
    public function addBadge(string $pseudo, string $idBadge)
    {
        $adminManager = new AdminManager();
        $idUser = $adminManager->getInfosByPseudo($pseudo)['profileInfo']['id'];
        $adminManager->addBadge($idUser, $idBadge);
        header('Location: /admin/show/' . $pseudo);
    }
    public function gamesetup(int $deptId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $gameParameters = array_map('trim', $_POST);
            $departmentManager = new DepartmentManager();
            $departmentManager->updateGameParameters($deptId, $gameParameters['pointunit'], $gameParameters['margin']);
        }
        return $this->twig->render('Admin/gamesetup');
    }

    public function home()
    {
        if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header('Location: /');
        }
        $adminManager = new AdminManager();
        $names = $adminManager->getNames();
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $formChecker = new FormChecker($_POST);
            $formChecker->cleanAll();
            $trimmedPost = $formChecker->getPost();
            $formChecker->checkInputLength($trimmedPost['pseudo'], 'pseudo', 1, 255);
            $errors = $formChecker->getErrors();
            $search = $formChecker->getPost();
            $search['pseudo'] = ucfirst(strtolower($search['pseudo']));
            if (!in_array($search['pseudo'], $names)) {
                $errors['exist'] = "Ce nom n'existe pas dans la base donnée";
            }
            if (empty($errors)) {
                header('Location: /Admin/show/' . $search['pseudo']);
            }
        }

        return $this->twig->render('/Admin/home.html.twig', [ 'errors' => $errors,'names' => $names]);
    }
    public function show(string $pseudo)
    {
        $adminManager = new AdminManager();
        $userData = $adminManager->getInfosByPseudo($pseudo);
        return $this->twig->render('/Admin/show.html.twig', ['user_data' => $userData]);
    }

    public function isAdmin($pseudo)
    {
        $adminManager = new AdminManager();
        $adminManager->changeIsAdminSatus($pseudo);

        header('Location: /admin/show/' . $pseudo);
    }
    public function changeAvatar(string $pseudo, string $avatarId)
    {
        $adminManager = new AdminManager();
        $adminManager->changeAvatar($pseudo, $avatarId);

        if ($_SESSION['pseudo'] === $pseudo) {
            $_SESSION['avatar'] = $adminManager->getAvatarbiId($avatarId)['image'];
        }
        header('Location: /admin/show/' . $pseudo);
    }
}
