<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->morphTo();
    }

    public function removeImagesFromDataBaseOwnedBy($type, $id)
    {
        return $this->where('owner_type', $type)
            ->where('owner_id', $id)
            ->delete();
    }

    public function removeImagesFromStorage($path)
    {
        if (is_array($path)) {
            foreach ($path as $image) {
                Storage::delete("public/{$image['path']}");
            }
            return;
        }
        Storage::delete("public/{$path}");
        return;
    }
}
