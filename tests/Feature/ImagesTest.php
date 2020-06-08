<?php

namespace Tests\Feature;

use App\Login;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImagesTest extends TestCase
{
    protected $user;

    protected function successfulUploadRoute()
    {
        return route('images.store');
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->user = factory(Login::class)->create();
        File::deleteDirectory(Storage::disk('tmp')->path('/'));
    }

    public function testUserUploadImage()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($this->user)
            ->post($this->successfulUploadRoute(), [
            'file' => $file
        ]);

        $response->assertJsonStructure([
            'name',
            'original_name'
        ]);

        $response->assertJsonFragment([
            'original_name' => 'avatar.jpg'
        ]);
    
        $json = $response->json();

        Storage::disk('tmp')->assertExists($json['name']);
        Storage::disk('tmp')->assertMissing('missing.jpg');
    }
}
