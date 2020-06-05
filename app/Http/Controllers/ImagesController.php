<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;

class ImagesController extends Controller
{
    /**
     * Upload an image to the tmp folder
     *
     * @param  \Illuminate\Support\Facades\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $path = storage_path('tmp/uploads');
    
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    
        $file = $request->file('file');
    
        $name = uniqid() . '_' . trim($file->getClientOriginalName());
    
        $file->move($path, $name);
    
        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }
}
