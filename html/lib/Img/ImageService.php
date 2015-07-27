<?php

/*
 *  klasa do obsługi plików graficznych
 */

/**
 * Description of ImageService
 *
 * @author Tomek
 */
namespace Lib\Img;


class ImageService 
{    
    private $_image;
    
    private $_thumbWidth = 100;
    
    private $_thumbHeight = 75;
    
    private $_currentReducingMethod = 'described';
    
    private $_reducingMethods = array(
        'inscribed', 'described', // + metoda która nie opiera się na rozmiarach canvas miniatury tylko na rozmiarach i proporcjach pierwotnego zdjęcia
    );
    
    private $_canvasBackgroundColor = array(
        255, 255, 255
    );
    
    public function __construct(Image $img = null)
    {
        $this->_image = $img;
    }
    
    
    public function createThumbnail(Image $img = null)
    {
        if ($img == null && $this->_image == null) {
            throw new Exception("Image can't be null " . __METHOD__);
        } else if ($img instanceof Image) {
            $this->_image = $img;
        }
        
        
        $thumb = $this->_createCanvas();
        
        
        $newSizes = $this->_calcInscribedSizes();
        echo '<pre>';
        print_r($newSizes);
        echo '</pre>';
        switch($this->_image->getMimeType()) {
            case 'image/jpeg':
                $sourceImageRes = imagecreatefromjpeg($this->_image);
                imagecopyresampled($thumb, $sourceImageRes, $newSizes['coordX'], $newSizes['coordY'], 0, 0, $newSizes['destWidth'], $newSizes['destHeight'], $this->_image->getWidth(), $this->_image->getHeight());
                imagejpeg($thumb, $this->_image->getFileDirectory() . DIRECTORY_SEPARATOR . $this->_image->getFilenameWithoutExt() . '_min.jpg', 100);
                imagedestroy($sourceImageRes);
                break;
            case 'image/png':
                
                break;
            case 'image/gif':
                
                break;
            default:
                throw new Exception("Nie obsługiwany format tworzenia miniatur");
        }
        
        imagedestroy($thumb);
    }
    
    public function setThumbnailSize($width, $height)
    {
        $this->_thumbWidth = (int)$width > 0 ? (int)$width : $this->_thumbWidth;
        $this->_thumbHeight = (int)$height > 0 ? (int)$height : $this->_thumbHeight;
        return $this;
    }
    
    
    /**
     * Ustala metodę pomniejszania np. zdjęcie wpisane w canvas, opisane na canvas
     * @param string $method
     */
    public function setReducingMethod($method)
    {
        if (in_array($method, $this->_reducingMethods)) {
            $this->_currentReducingMethod = $method;
        }
        return $this;
    }
    
    /**
     * Set canvas background color
     * @param int - can pass from 0 to 3 numbers (between 0-255) to set RGB color
     * @return \Lib\Img\ImageService
     */
    public function setThumBackground()
    {
        $args = func_get_args();
        for ($i = 0; $i < 3; $i++) {
            $c = (int)$args[$i];
            if ($c >= 0 && $c <= 255) {
                $this->_canvasBackgroundColor[$i] = $c;
            }
        }
        return $this;
    }
    
    /**
     * creates resource of thumbnail canvas
     * @return resource of image
     */
    private function _createCanvas()
    {
        $canvas = imagecreatetruecolor($this->_thumbWidth, $this->_thumbHeight);
        // set canvas to white
        $color = imagecolorallocate(
                                    $canvas, 
                                    $this->_canvasBackgroundColor[0], 
                                    $this->_canvasBackgroundColor[1], 
                                    $this->_canvasBackgroundColor[2]
                                );
        imagefill($canvas, 0, 0, $color);
        
        return $canvas;
    }
    
    /**
     * oblicza wymiary pomniejszonego obrazu źródłowego tak aby w całości zmieścił się na płótnie miniatury (wpisany w canvas)
     */
    private function _calcInscribedSizes()
    {
        $newSizes = array();
        if ($this->_image->getRatio() < $this->_getThumbnailCanvasRatio()) {
            $divider = $this->_image->getHeight() / $this->_thumbHeight;
            $newSizes['destWidth'] = $this->_image->getWidth() / $divider;
            $newSizes['destHeight'] = $this->_thumbHeight;
            $newSizes['coordX'] = ($this->_thumbWidth - $newSizes['destWidth']) / 2;
            $newSizes['coordY'] = 0;
        } else {
            $divider = $this->_image->getWidth() / $this->_thumbWidth;
            $newSizes['destWidth'] = $this->_thumbWidth;
            $newSizes['destHeight'] = $this->_image->getHeight() / $divider;
            $newSizes['coordX'] = 0;
            $newSizes['coordY'] = ($this->_thumbHeight - $newSizes['destHeight']) / 2;
        }
        return $newSizes;
    }
    
    /**
     * oblicza wymiary pomniejszonego obrazu źródłowego tak aby w całości pokrył płótno miniatury (opisany na canvas)
     */
    private function _calcDescribedSizes()
    {
        
    }
    
    
    private function _calcProportion()
    {
        
    }
    
    private function _getThumbnailCanvasRatio()
    {
        return $this->_thumbWidth / $this->_thumbHeight;
    }
}
