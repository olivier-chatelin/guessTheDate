<?php

namespace App\Controller;

use App\Model\GalleryManager;

class GalleryController extends AbstractController
{
    public function index()
    {
        $galleryData = file_get_contents('php://input');
        $galleryData = json_decode($galleryData, true);
        var_dump($galleryData);
//        $galleryManager = new GalleryManager();
//        $gallery = $galleryManager->selectAll();
//        return $this->twig->render('Gallery/index.html.twig', [
//            'gallery' => $gallery
//        ]);
    }
}
