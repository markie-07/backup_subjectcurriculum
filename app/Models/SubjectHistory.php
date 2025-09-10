<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectHistory extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     * This fixes the "Table not found" error.
     */
    protected $table = 'subject_history';

    /**
     * The attributes that are mass assignable.
     * We've added 'semester' here to allow it to be saved.
     */
    protected $fillable = [
        'curriculum_id',
        'subject_code',
        'subject_name',
        'units',
        'academic_year_range',
        'semester', // ✨ ADDED THIS
        'action',
    ];

    public function curriculum()
    {
        return $this->belongsTo(Curriculum::class);
    }
}