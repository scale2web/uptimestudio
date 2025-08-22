<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AMMaintenanceJobType extends Model
{
    use HasFactory;

    protected $table = 'am_maintenance_job_types';

    protected $fillable = [
        'job_type_code',
        'name',
        'description',
        'maintenance_stop_required',
        'job_type_category_id',
        'tenant_id',
    ];

    /**
     * Get the tenant that owns the job type.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the job type category that owns the job type.
     */
    public function jobTypeCategory(): BelongsTo
    {
        return $this->belongsTo(AMMaintenanceJobTypeCategory::class, 'job_type_category_id');
    }
} 