<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    use HasFactory;

    protected $table = 'job_vacancies';

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'location',
        'type',        // full-time, part-time, intern, etc
        'salary',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Relasi: Satu lowongan punya banyak pelamar
     */
    public function applications()
    {
        return $this->hasMany(Application::class, 'job_id');
    }
}
