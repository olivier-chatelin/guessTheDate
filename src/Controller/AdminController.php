<?php

namespace App\Controller;

use App\Model\AdminManager;
use App\Model\DepartmentManager;
use App\Model\GameAdminManager;

class AdminController extends AbstractController
{
    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index(): string
    {
        $adminManager = new AdminManager();
        $users = $adminManager->selectAll();
        return $this->twig->render('Admin/index.html.twig', [
            'users' => $users
        ]);
    }

    public function show(int $id): string
    {
        $adminManager = new AdminManager();
        $user = $adminManager->selectOneById($id);

        return $this->twig->render('Admin/show.html.twig', [
        'user' => $user
        ]);
    }

    public function edit(int $id): string
    {
        $adminManager = new AdminManager();
        $user = $adminManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation in ok, update and redirection
            $adminManager->update($user);
            header('Location: /admin/show/' . $id);
        }
        return $this->twig->render('Admin/edit.html.twig', [
            'user' => $user,
        ]);
    }

    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation in ok, insert and redirection
            $adminManager = new AdminManager();
            $id = $adminManager->insert($user);
            header('Location:/admin/show/' . $id);
        }
            return $this->twig->render('Admin/add.html.twig');
    }

    public function delete(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $adminManager = new AdminManager();
            $adminManager->delete($id);
            header('Location:/admin/index');
        }
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
}
