<?php

namespace App\Models;

use App\Models\Traits\FetchableTrait;
use App\Models\Traits\SlugTrait;

/**
 * App\Models\FileType
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 *
 */
class FileType extends MainModel
{
    use SlugTrait, FetchableTrait;

    protected $table = 'file_types';

    const IMAGE = 'file_types.image';
    const VIDEO = 'file_types.video';
}
