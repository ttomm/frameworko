<?php

namespace App\Controllers;
use Lib\Img as Img;

/**
 * Description of IndexController
 *
 * @author Tomek
 */
class IndexController extends \Lib\BaseController
{
    public function init()
    {
        // init
    }
    public function IndexAction()
    {
        $image = new Img\Image('c:/zdjecia/PW680141.jpg');
        $imageService  = new Img\ImageService($image);
        $imageService->setThumbnailSize(200, 180)->setThumBackground(255, 0, 0)->createThumbnail();
    }
}
