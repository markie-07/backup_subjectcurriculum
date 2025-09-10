<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'subject_code',
        'subject_name',
        'units',
        'academic_year_range',
        'action',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}