<?php

/*
 * w przyszłości jako klasa bazowa dla poszczególnych specjalizacji (png, jpg etc.)
 */

/**
 * Description of Image
 *
 * @author Tomek
 */
namespace Lib\Img;

class Image 
{
    private $_imagePath;
    
    private $_imageRatio;
    
    private $_imageInfo = array();
    
    public function __construct($image)
    {
        if (!is_string($image)) {
            throw new \Exception("Parameter must be string type " . __METHOD__);
        }
        
        if (!$this->_checkIfExist($image)) {
            throw new \Exception("File doesn't exist " . __METHOD__);
        }
        
        // tutaj sprawdzenie czy plik jest obrazem  
        $this->_imagePath = $image;
    }
    
    public function getFilename()
    {
        return pathinfo($this->_imagePath, PATHINFO_BASENAME);
    }
    
    public function getFilenameWithoutExt()
    {
        return pathinfo($this->_imagePath, PATHINFO_FILENAME);
    }
    
    public function getFileExt()
    {
        return pathinfo($this->_imagePath, PATHINFO_EXTENSION);
    }
    
    public function getFileDirectory()
    {
        return pathinfo($this->_imagePath, PATHINFO_DIRNAME);
    }
    
    public function getFullPath()
    {
        return $this->_imagePath;
    }
    
    public function getMimeType()
    {
        if (empty($this->_imageInfo)) {
            $this->_imageInfo = getimagesize($this->getFullPath());
        }        
        return $this->_imageInfo['mime'];
    }
    
    public function getWidth()
    {
        if (empty($this->_imageInfo)) {
            $this->_imageInfo = getimagesize($this->getFullPath());
        } 
        return $this->_imageInfo[0];
    }
    
    public function getHeight()
    {
        if (empty($this->_imageInfo)) {
            $this->_imageInfo = getimagesize($this->getFullPath());
        } 
        return $this->_imageInfo[1];
    }
    
    public function getRatio()
    {
        if ($this->_imageRatio === null) {
            $this->_imageRatio = $this->getWidth() / $this->getHeight();
        }
        return $this->_imageRatio;
    }
    
    public function isPortrait()
    {
        return $this->getWidth() < $this->getHeight();
    }
    
    public function __toString()
    {
        return $this->getFullPath();
    }
    
    protected function _checkIfExist($filename)
    {
        return file_exists($filename);
    }
}
