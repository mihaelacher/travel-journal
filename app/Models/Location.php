<?php

namespace App\Models;

/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $name
 * @property string $photo_references
 * @property string $latitude
 * @property string $longitude
 * @property string $vicinity
 *
 */
class Location extends MainModel
{
    protected $table = 'locations';
    protected $fillable = ['latitude', 'longitude', 'name'];

    public $timestamps = false;
}
