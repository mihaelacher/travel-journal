<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\File
 *
 * @property int $id
 * @property string $original_name
 * @property string $system_name
 * @property string $path
 * @property int $file_type_id
 * @property int $created_by
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 *
 */
class File extends ModifiableModel
{
    use SoftDeletes;

    protected $table = 'files';
}
