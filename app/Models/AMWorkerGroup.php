<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AMWorkerGroup extends Model
{
    protected $table = 'am_worker_groups';
    
    protected $fillable = [
        'worker_group',
        'name',
        'tenant_id',
    ];
    
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
    
    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(AMWorker::class, 'am_worker_am_worker_group', 'am_worker_group_id', 'am_worker_id')
            ->withTimestamps();
    }
    
    public function getWorkersCountAttribute(): int
    {
        return $this->workers()->count();
    }
}
