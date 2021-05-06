<?php

namespace App\Controller;

use App\Model\GalleryManager;

class GalleryController extends AbstractController
{
    public function action()
    {
        $galleryData = file_get_contents('php://input');
        $galleryData = json_decode($galleryData, true);
        $galleryManager = new GalleryManager();
        $paintingId = $galleryManager->insert($galleryData);
        $galleryManager->attributePainting($_SESSION['id'], $paintingId);
    }

    public function show($pseudo)
    {
        $galleryManager = new GalleryManager();
        $paintings = $galleryManager->showPaintingByPseudo($pseudo);
        return $this->twig->render('Gallery/show.html.twig', [
            'paintings' => $paintings
            ]);
    }
}
