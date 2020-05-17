<?php

namespace Tests\Unit\Helpers\Resources;

use PHPUnit\Framework\TestCase;

class LoadResourceTest extends TestCase
{

    const INVALID = 'i-love-laravel.css';

    const VALID = 'style.css';

    /**
     * A basic unit test example.
     */
    public function testNoManifest()
    {
        $this->assertFalse(load_resource('any-resource'));
    }

    /**
     * A basic unit test example.
     */
    public function testInvalidAsset()
    {
        $this->assertFalse(load_resource(self::INVALID));
    }
    
    /**
     * A basic unit test example.
     */
    /*
    public function testValidUlrAsset()
    {
        $this->assertFalse(load_resource(self::VALID, 'url'));
    }
    */
    /**
     * A basic unit test example.
     */
    /*
    public function testValidFileAsset()
    {
        $this->assertFalse(load_resource(self::VALID, 'file'));
    }
    */
}
