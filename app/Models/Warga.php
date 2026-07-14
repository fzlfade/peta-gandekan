<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_pemilik', 'alamat', 'latitude', 'longitude'])]
class Warga extends Model
{
    protected function casts(): array
    {
        return [
            'latitude' => 'double',
            'longitude' => 'double',
        ];
    }
}
