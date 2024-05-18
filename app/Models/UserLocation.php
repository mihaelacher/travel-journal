<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * App\Models\UserLocation
 *
 * @property int $id
 * @property int $user_id
 * @property int $location_id
 * @property string $photo_references
 * @property Carbon $visited_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @method static create(array $param)
 */
class UserLocation extends MainModel
{
    protected $table = 'user_locations';
    protected $fillable = ['user_id', 'location_id', 'visited_at', 'photo_references'];
}

