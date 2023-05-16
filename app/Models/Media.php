<?php

namespace App\Models;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory, UsesUuid;

    protected $fillable = [
        'mediaable_type',
        'mediaable_id',
        'photo'
    ];

    public function mediaable() {
        return $this->morphTo();
    }

    public function getFileUrlAttribute() {
        return asset($this->photo);
    }

    /**
     * Upload image
     * @param $file
     * @param $directory
     * @return string
     */
    public static function uploadImage($file, string $directory) :string
    {
        $path = config('settings.media.path').'/'.$directory;
        $name = $file->getClientOriginalName();
        $fullName = time().'-'.$name;
        Storage::disk(config('settings.media.disc'))->putFileAs($path, $file, $fullName);
        return 'storage/'.$path.'/'.$fullName;
    }

    /**
     * remove image from media
     * @param $path
     * @param $disk
     * @return void
     */
    public static function removeFile(string $path, string $disk) : void
    {
        Storage::disk($disk)->delete($path);
    }
}
