<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmAssetLifecycleStateSequence extends Model
{
    use HasFactory;

    protected $table = 'am_asset_lifecycle_state_sequences';

    protected $fillable = [
        'tenant_id',
        'lifecycle_model_id',
        'lifecycle_state_id',
        'line',
    ];

    protected $casts = [
        'line' => 'integer',
    ];

    /**
     * Get the tenant that owns the sequence.
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the lifecycle model for this sequence.
     */
    public function lifecycleModel(): BelongsTo
    {
        return $this->belongsTo(AmAssetLifecycleModel::class, 'lifecycle_model_id');
    }

    /**
     * Get the lifecycle state for this sequence.
     */
    public function lifecycleState(): BelongsTo
    {
        return $this->belongsTo(AmAssetLifecycleState::class, 'lifecycle_state_id');
    }
}
