<?php


namespace Innox\Traits;


use App\Business\Upload;
use App\DB\Meta;
use Illuminate\Database\Eloquent\Model;

trait IsUploadable
{
    public function uploadable()
    {
        return $this->morphMany(Upload::class, 'uploadable');

    }

    public function saveUpload(Upload $upload)
    {
        return $this->uploadable()->save($upload);
    }

    public function getUpload($key , $default = '')
    {
        return  isset($this->uploadable()->where('key', $key)->first()->url) ? $this->uploadable()->where('key', $key)->first()->url : $default;
    }
}
