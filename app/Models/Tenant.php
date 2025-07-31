<?php

namespace App\Models;

use App\Services\SubscriptionService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'uuid',
        'is_name_auto_generated',
        'created_by',
        'domain',
    ];

    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->using(TenantUser::class)->withPivot('id')->withTimestamps();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function stripeData(): HasOne
    {
        return $this->hasOne(UserStripeData::class);
    }

    public function subscriptionProductMetadata()
    {
        /** @var SubscriptionService $subscriptionService */
        $subscriptionService = app(SubscriptionService::class);

        return $subscriptionService->getTenantSubscriptionProductMetadata($this);
    }

    public function roles(): HasMany
    {
        return $this->hasMany(Role::class);
    }

    public function amFunctionalLocationLifecycleStates(): HasMany
    {
        return $this->hasMany(AmFunctionalLocationLifecycleState::class);
    }

    public function amFunctionalLocationLifecycleModels(): HasMany
    {
        return $this->hasMany(AmFunctionalLocationLifecycleModel::class);
    }

    public function amFunctionalLocationLifecycleStateSequences(): HasMany
    {
        return $this->hasMany(AmFunctionalLocationLifecycleStateSequence::class);
    }

    public function amAssetLifecycleStates(): HasMany
    {
        return $this->hasMany(AmAssetLifecycleState::class);
    }

    public function amAssetLifecycleModels(): HasMany
    {
        return $this->hasMany(AmAssetLifecycleModel::class);
    }

    public function amAssetLifecycleStateSequences(): HasMany
    {
        return $this->hasMany(AmAssetLifecycleStateSequence::class);
    }

    public function amAssetTypes(): HasMany
    {
        return $this->hasMany(AmAssetType::class);
    }

    public function amFunctionalLocationTypes(): HasMany
    {
        return $this->hasMany(AmFunctionalLocationType::class);
    }
}
