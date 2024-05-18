<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainModel extends Model
{
    /**
     * @return void
     */
    public static function boot(): void
    {
        parent::boot();

        static::saving(function ($model) {
            foreach ($model?->toArray() as $name => $value) {
                if (! isset($value) || $value === '') {
                    $model->{$name} = null;
                }
            }
        });
    }
}
