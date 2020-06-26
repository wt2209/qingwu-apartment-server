<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait UuidPrimaryKey
{
    // 加上这一句，会导致前端发生跨域错误，不知道为什么
    // public $incrementing = false;

    // 使用uuid
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
}
