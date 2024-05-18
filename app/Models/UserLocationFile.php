<?php

namespace App\Models;

/**
 * App\Models\UserLocationFile
 *
 * @property int $id
 * @property int $user_location_id
 * @property int $file_id
 *
 */
class UserLocationFile extends MainModel
{
    protected $table = 'user_location_files';
}
