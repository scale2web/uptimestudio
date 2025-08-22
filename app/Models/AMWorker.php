<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AMWorker extends Model
{
    protected $table = 'am_workers';
    
    protected $fillable = [
        'personnel_number',
        'birthdate',
        'citizenship_country_region',
        'deceased_date',
        'disabled_verification_date',
        'education',
        'ethnic_origin_id',
        'first_name',
        'gender',
        'is_disabled',
        'is_full_time_student',
        'known_as',
        'language_id',
        'last_name',
        'last_name_prefix',
        'middle_name',
        'name',
        'nationality_country_region',
        'native_language_id',
        'personal_suffix',
        'personal_title',
        'person_birth_city',
        'person_birth_country_region',
        'primary_contact_email',
        'tenant_id',
    ];
    
    protected $casts = [
        'birthdate' => 'date',
        'deceased_date' => 'date',
        'disabled_verification_date' => 'date',
        'is_disabled' => 'boolean',
        'is_full_time_student' => 'boolean',
    ];
    
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function workerGroups(): BelongsToMany
    {
        return $this->belongsToMany(AMWorkerGroup::class, 'am_worker_am_worker_group', 'am_worker_id', 'am_worker_group_id')
            ->withTimestamps();
    }
    
    // Helper method to get full name
    public function getFullNameAttribute(): string
    {
        $parts = array_filter([$this->first_name, $this->middle_name, $this->last_name]);
        return implode(' ', $parts);
    }
}
