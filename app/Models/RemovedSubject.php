<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RemovedSubject extends Model
{
    use HasFactory;

    protected $fillable = [
        'curriculum_id',
        'subject_id',
        'subject_code',
        'subject_name',
        'year',
        'semester',
    ];

    /**
     * Get the curriculum that the subject was removed from.
     */
    public function curriculum(): BelongsTo
    {
        return $this->belongsTo(Curriculum::class);
    }

    /**
     * Get the subject that was removed.
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}