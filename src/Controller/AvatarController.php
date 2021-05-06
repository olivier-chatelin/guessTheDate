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
