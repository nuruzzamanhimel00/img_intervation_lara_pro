<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Images extends Model
{
    use HasFactory;
    protected $fillable = ['image', 'image_type'];
    protected $table = "images";

    protected $appends = ['image_url'];

    const BACKUP_IMAGE = 'backup_image';
    const BLUR_IMAGE = 'blur_image';
    const BRIGHTNESS_IMAGE = 'brightness_image';
    const CIRCLE_IMAGE = 'circle_image';

    //image store path
    const IMAGE_STORE_PATH = 'image/feature_image';

    public function getImageUrlAttribute(){
        $path = self::IMAGE_STORE_PATH;
        if (Storage::disk('public')->exists($path.'/'.$this->image)) {
           return $path.'/'.$this->image;

        }
    }

}
