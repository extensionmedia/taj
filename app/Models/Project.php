<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'project';
    public $timestamps = false;
    protected $fillable = [
        'date_creation',
        'project_name',
        'telephone_1',
        'telephone_2',
        'telephone_3',
        'telephone_4',
        'ville',
        'adresse',
        'email',
        'site_web'
    ];
}
