<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmFunctionalLocationLifecycleStateSequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'lifecycle_model_id',
        'lifecycle_state_id',
        'line',
        'tenant_id',
    ];

    protected $casts = [
        'line' => 'integer',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function lifecycleModel(): BelongsTo
    {
        return $this->belongsTo(AmFunctionalLocationLifecycleModel::class, 'lifecycle_model_id');
    }

    public function lifecycleState(): BelongsTo
    {
        return $this->belongsTo(AmFunctionalLocationLifecycleState::class, 'lifecycle_state_id');
    }

    /**
     * Scope to get sequences for a specific model ordered by line
     */
    public function scopeForModel($query, $modelId)
    {
        return $query->where('lifecycle_model_id', $modelId)->orderBy('line');
    }

    /**
     * Scope to get sequences for a specific tenant
     */
    public function scopeForTenant($query, $tenantId)
    {
        return $query->where('tenant_id', $tenantId);
    }
}
