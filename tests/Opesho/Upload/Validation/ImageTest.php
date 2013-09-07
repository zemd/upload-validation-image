<?php

namespace Opesho\Upload\Validation;

class ImageTest extends \PHPUnit_Framework_TestCase {

    protected $assetsDirectory;

    protected $storage;

    public function setUp() {
        $this->assetsDirectory = dirname(__DIR__).'/../../assets';

        $this->storage = $this->getMock(
            '\Upload\Storage\FileSystem',
            array('upload'),
            array($this->assetsDirectory)
        );

        $this->storage->expects($this->any())
            ->method('upload')
            ->will($this->returnValue(true));

        $_FILES['image_jpg'] = array(
            'name' => 'cross-eyed-cat_2351472k.jpg',
            'tmp_name' => $this->assetsDirectory . '/cross-eyed-cat_2351472k.jpg',
            'error' => 0
        );

        $_FILES['image_gif'] = array(
            'name' => 'tumblr_mczurxdymF1qzlzhuo1_500.gif',
            'tmp_name' => $this->assetsDirectory . '/tumblr_mczurxdymF1qzlzhuo1_500.gif',
            'error' => 0
        );

        $_FILES['small_not_image'] = array(
            'name' => 'test.txt',
            'tmp_name' => $this->assetsDirectory . '/test.txt',
            'error' => 0
        );

        $_FILES['not_image'] = array(
            'name' => 'test1.txt',
            'tmp_name' => $this->assetsDirectory . '/test1.txt',
            'error' => 0
        );

        $_FILES['fake_image'] = array(
            'name' => 'test.txt.jpg',
            'tmp_name' => $this->assetsDirectory . '/test.txt.jpg',
            'error' => 0
        );
    }

    public function testImageJPG() {
        $file = new \Upload\File('image_jpg', $this->storage);
        $validation = new \Opesho\Upload\Validation\Image();
        $this->assertTrue($validation->validate($file));
    }

    public function testImageGIF() {
        $file = new \Upload\File('image_gif', $this->storage);
        $validation = new \Opesho\Upload\Validation\Image();
        $this->assertTrue($validation->validate($file));
    }

    public function testReadError() {
        $this->setExpectedException('PHPUnit_Framework_Error');
        $file = new \Upload\File('small_not_image', $this->storage);
        $validation = new \Opesho\Upload\Validation\Image();
        $validation->validate($file);
    }

    public function testNotImage() {
        $file = new \Upload\File('not_image', $this->storage);
        $validation = new \Opesho\Upload\Validation\Image();
        $this->assertFalse($validation->validate($file));
    }

    public function testFakeImage() {
        $file = new \Upload\File('fake_image', $this->storage);
        $validation = new \Opesho\Upload\Validation\Image();
        $this->assertFalse($validation->validate($file));
    }
}