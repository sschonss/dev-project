<?php

namespace App\Domains\Level\Models;

use App\Domains\Developer\Models\Developer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class  Level extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'levels';

    protected $fillable = [
        'level'
    ];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    protected $hidden = ['deleted_at'];

    public function developers(): HasMany
    {
        return $this->hasMany(Developer::class);
    }
}
