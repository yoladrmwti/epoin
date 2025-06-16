<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class pelanggar extends Model
{
 use HasFactory;
    protected $fillable = [
        'id_siswa',
        'poin_pelanggar',
        'status_pelanggar',
        'status',
    ];
}
