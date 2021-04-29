<?php

namespace App\Controller;

use App\Model\AvatarManager;
use App\Model\UserManager;

class AvatarController extends AbstractController
{
    public function index()
    {
        $avatarManager = new AvatarManager();
        $avatars = $avatarManager->selectAll();
        return $this->twig->render('Avatar/index.html.twig', [
            'avatars' => $avatars
            ]);
    }

    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation in ok, insert and redirection
            $avatarManager = new AvatarManager();
            $id = $avatarManager->insert($user);
            header('Location:/avatar/index/' . $id);
        }
        return $this->twig->render('Avatar/add.html.twig');
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $avatarManager = new AvatarManager();
            $avatarManager->delete($id);
            header('Location:/avatar/index');
        }
    }

    public function edit(string $userId): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($userId);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($userManager->updateAvatarId($userId, $_POST['avatar_id'])) {
                $this->logRecorder->recordChangeAvatar();
                $_SESSION['avatar'] = $userManager->getAvatarById($_SESSION['id'])['image'];
            };
            header('Location:/avatar/index');
        }
        return $this->twig->render('Avatar/index.html.twig', [
            'user' => $user,
        ]);
    }
}
