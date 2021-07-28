<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $table = 'regions';

    protected $fillable = [
      'cod_commune', 'abr_region', 'gloss_region', 'code_varchar'
    ];

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }
}
