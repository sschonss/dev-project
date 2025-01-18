<?php

namespace App\Domains\Developer\Models;

use App\Domains\Level\Models\Level;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Developer extends Model
{
    use SoftDeletes;

    protected $table = 'developers';

    protected $fillable = [
        'name',
        'gender',
        'birth_date',
        'hobby',
        'level_id',
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    protected $hidden = ['deleted_at'];

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function getLevelNameAttribute(): string
    {
        return $this->level->level;
    }
}
