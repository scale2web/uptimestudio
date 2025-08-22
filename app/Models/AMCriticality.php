<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AMCriticality extends Model
{
    protected $table = 'a_m_criticalities';
    
    protected $fillable = [
        'criticality',
        'name',
        'rating_factor',
        'tenant_id',
    ];
    
    protected $casts = [
        'criticality' => 'integer',
        'rating_factor' => 'integer',
    ];
    
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }
}
