<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AmWorkOrderLifecycleModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'lifecycle_model_name',
        'name',
        'tenant_id',
    ];

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function lifecycleStates(): HasMany
    {
        return $this->hasMany(AmWorkOrderLifecycleState::class, 'lifecycle_model_id');
    }

    public function sequences(): HasMany
    {
        return $this->hasMany(AmWorkOrderLifecycleStateSequence::class, 'lifecycle_model_id');
    }

    public function orderedSequences(): HasMany
    {
        return $this->hasMany(AmWorkOrderLifecycleStateSequence::class, 'lifecycle_model_id')
            ->orderBy('line');
    }
} 