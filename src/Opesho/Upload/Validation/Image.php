<?php
namespace Opesho\Upload\Validation;

use Upload\File;
use Upload\Validation\Base as ValidationBase;

/**
 * Validate image file
 *
 * This class validates an uploads images with exif extension.
 *
 * WARNING! This kind of validation is not fully securing your application from malicious scripts.
 *
 * @author  Dmitry Zelenetskiy <dmitry.zelenetskiy@gmail.com>
 * @package Upload
 */
class Image extends ValidationBase
{

    /**
     * Validate file
     * @param  File $file
     * @return bool         True if file is valid, false if file is not valid
     */
    public function validate(File $file)
    {
        if (exif_imagetype($file->getPathname()) !== false) {
            return true;
        }
        $this->setMessage('Trying upload file that is not image.');
        return false;
    }
}
