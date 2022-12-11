<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Images;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function __construct(){

    }

    public function addImage(){
        return view('addImage');
    }

    public function storeImage(Request $request){
        $name = time() . Str::random(60) . '.'.$request->file('image')->getClientOriginalExtension();
        $path = Images::IMAGE_STORE_PATH;

        if($request->image_type == Images::BACKUP_IMAGE){

            $this->backup_image($request, $path, $name);
            $this->store_image($name, $request->image_type);

            return "Image store successfully";
        }else if($request->image_type == Images::BLUR_IMAGE){
            // create new Intervention Image
            $img = Image::make($request->image);
            $img->blur(15);
            Storage::disk('public')->put($path.'/'.$name, (string) $img->encode());
            $this->store_image($name, $request->image_type);
            return "Image store successfully";
        }
    }

    protected function backup_image($request, $path, $name){
        // create empty canvas with black background
        $img = Image::canvas(120, 90, '#000000');
        // fill image with color
        $img->fill('#b53717');
        // backup image with colored background
        $img->backup();
        $imgage = Image::make($request->image);
        // fill image with tiled image
        $img->fill($imgage);
        // // return to colored background
        $img->reset();

        Storage::disk('public')->put($path.'/'.$name, (string) $img->encode());
    }

    protected function store_image($name, $image_type){
        $imageStore = Images::Create([
            'image' => $name,
            'image_type' => $image_type
        ]);
    }
}
