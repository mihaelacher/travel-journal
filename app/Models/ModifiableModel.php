<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class ModifiableModel extends MainModel
{
    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            $currentUserId = self::getCurrentUserId();

            if ($currentUserId) {
                if (is_null($model->created_by)) {
                    $model->created_by = $currentUserId;
                }
            }
        });

        static::updating(function ($model) {
            $currentUserId = self::getCurrentUserId();

            if ($currentUserId) {
                $model->updated_by = $currentUserId;
            }
        });

        static::deleting(function ($model) {
            $currentUserId = self::getCurrentUserId();

            if ($currentUserId) {
                $model->updated_by = $currentUserId;
                $model->save();
            }
        });
    }

    /**
     * @return int|string|null
     */
    private static function getCurrentUserId(): int|string|null
    {
        return Auth::id();
    }
}
