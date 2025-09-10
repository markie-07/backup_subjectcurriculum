<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_code',
        'subject_name',
        'subject_type',
        'subject_unit',
        'lessons',
    ];

    protected $casts = [
        'lessons' => 'array',
    ];

    public function curriculums(): BelongsToMany
    {
        return $this->belongsToMany(Curriculum::class)
            ->withPivot('year', 'semester')
            ->withTimestamps();
    }
}