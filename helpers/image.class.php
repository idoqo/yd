<?php
class Image
{
    private $url = null;
    private $tmp = null;

    public function __construct($url)
    {
        $this->url = $url;
        $this->tmp = $url; #To avoid overwriting original
    }

    /**
     * Check for existence of files.
     * @see all other methods
     * @return bool
     */
    private function exists()
    {
        return file_exists($this->url);
    }

    /**
     * get the image h and w dimensions
     * @return mixed array of image dimesions
     */
    public function getDimensions()
    {
        if ($this->exists() == false) {
            return "Unable to get file";
        }
        $details = getimagesize($this->url);
        $width = $details[0];
        $height = $details[1];
        return array("width" => $width, "height" => $height);
    }

    /**
     * get the imagetype of an image object
     * @return string imagetype XXX constant
     */
    public function type()
    {
        if ($this->exists() == false) {
            return "Unable to get file";
        }
        return exif_imagetype($this->url);
    }

    /**
     * solely exists to avoid switching cases inside of methods
     * @return image created based on the type
     */
    private function generateFromType()
    {
        $type = $this->type();
        switch ($type) {
            case 1:
                return imagecreatefromgif($this->url);
            case 2:
                return imagecreatefromjpeg($this->url);
            case 3:
                return imagecreatefrompng($this->url);
        }
    }

    /**
     * resize the image to a desired size
     * using the provided width and dumps it in the specified folder
     * External folders should be given with trailing dots and must be on the file disk.
     * imagejpeg() will not accept http:// urls.
     * Folders should be different from source folder to avoid conflicting files
     * @param int widthPixel
     * @param String dir
     */
    public function scale($widthPixel, $dir)
    {
        $dim = $this->getDimensions();
        $newWidth = floor(($widthPixel));
        $newHeight = floor(($dim['height'] * ($widthPixel / $dim['width'])));

        $sourceImage = $this->generateFromType();
        $tmpImage = imagecreatetruecolor($newWidth, $newHeight);

        imagecopyresampled($tmpImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $dim['width'], $dim['height']);

        //QUICK FIX
        $fileComponents = explode("/", $this->url);
        $fileName = end($fileComponents);
        imagepng($tmpImage, $dir . $fileName, 9);
    }

}