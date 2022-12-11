<?php

namespace App\Http\Controllers;

use Image;
use App\Models\Images;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function __construct(){

    }

    public function addImage(){
        return view('addImage');
    }

    public function viewImage(){
        $images = Images::latest()->get();
        // return $images;
        return view('imageView',compact('images'));
    }

    public function storeImage(Request $request){
        $name = time() . Str::random(60) . '.'.$request->file('image')->getClientOriginalExtension();
        $path = Images::IMAGE_STORE_PATH;

        if($request->image_type == Images::BACKUP_IMAGE){

            $this->backup_image($request, $path, $name);
            $this->store_image($name, $request->image_type);


        }else if($request->image_type == Images::BLUR_IMAGE){
            // create new Intervention Image
            $this->blur_image($request, $path, $name);
            $this->store_image($name, $request->image_type);

        }
        else if($request->image_type == Images::BRIGHTNESS_IMAGE){
           // create new Intervention Image
            $this->brightness_image($request, $path, $name);
            $this->store_image($name, $request->image_type);
        }
        else if($request->image_type == Images::CIRCLE_IMAGE){

            return "https://www.imnobby.com/2022/06/02/php-crop-image-from-square-to-circle-aka-set-image-border-radius/";
            $img = Image::make($request->image);
            $image_width = 300;

            // Apply a smart crop
            $img->fit($image_width);

            // create empty canvas with transparent background
            $canvas = Image::canvas($image_width, $image_width);

            // draw a black circle on it
            $canvas->circle($image_width, $image_width/2, $image_width/2, function ($draw) {
                $draw->background('#000000');
            });
            $img->circle($image_width, $image_width/2, $image_width/2, function ($draw) {
                $draw->background('#000000');
            });

            // // Mask your image with the shape
            // $img->mask($canvas->encode('png', 75), true); // 75 is the image compression ratio

            Storage::disk('public')->put($path.'/'.$name, (string)  $img->encode());
            // Response with the image or you can as well do whatever you like with it.

             $this->store_image($name, $request->image_type);
         }

        return redirect()->route('images.view');
    }

    protected function brightness_image($request, $path, $name){
        $img = Image::make($request->image);
        // increase brightness of image
        $img->brightness(35);
        Storage::disk('public')->put($path.'/'.$name, (string) $img->encode());
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

    protected function blur_image($request, $path, $name){
        $img = Image::make($request->image);
        $img->blur(70);
        Storage::disk('public')->put($path.'/'.$name, (string) $img->encode());
    }

    protected function store_image($name, $image_type){
        $imageStore = Images::Create([
            'image' => $name,
            'image_type' => $image_type
        ]);
    }

    public function deleteImage($id){
        $find_image = Images::findOrFail($id);
        throw_if(!$find_image, new \Exception("You're not authorized!", Response::HTTP_FORBIDDEN));
        $path = Images::IMAGE_STORE_PATH;
        if (Storage::disk('public')->exists($path.'/'.$find_image->image)) {
            Storage::disk('public')->delete($path.'/'.$find_image->image);
        }
        if($find_image->delete()){
            return redirect()->route('images.view');
        }
    }
}
