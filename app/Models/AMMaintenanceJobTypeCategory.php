<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AMMaintenanceJobTypeCategory extends Model
{
    use HasFactory;

    protected $table = 'am_maintenance_job_type_categories';

    protected $fillable = [
        'job_type_category_code',
        'name',
        'description',
        'tenant_id',
    ];

    /**
     * Get the tenant that owns the job type category.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the job types that belong to this category.
     */
    public function jobTypes(): HasMany
    {
        return $this->hasMany(AMMaintenanceJobType::class, 'job_type_category_id');
    }
} 