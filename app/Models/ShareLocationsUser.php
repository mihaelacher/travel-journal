<?php

namespace App\Models;

/**
 * App\Models\ShareLocationsUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $share_locations_user_id
 *
 */
class ShareLocationsUser extends MainModel
{
    protected $table = 'share_locations_users';
    protected $fillable = ['user_id', 'share_locations_user_id'];
}

