<?php

namespace App\Services;

use App\Constants\SubscriptionStatus;
use App\Constants\TenancyPermissionConstants;
use App\Constants\TenantConstants;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Str;

class TenantCreationService
{
    private const DISALLOWED_TENANT_SUBSCRIPTION_STATUSES = [
        SubscriptionStatus::NEW->value,
        SubscriptionStatus::PENDING->value,
        SubscriptionStatus::ACTIVE->value,
        SubscriptionStatus::PAUSED->value,
        SubscriptionStatus::PAST_DUE->value,
        SubscriptionStatus::PENDING_USER_VERIFICATION->value,
    ];

    public function __construct(
        private TenantPermissionService $tenantPermissionService,
    ) {}

    public function findUserTenantsForNewOrder(?User $user)
    {
        if ($user === null) {
            return collect();
        }

        return $this->tenantPermissionService->filterTenantsWhereUserHasPermission(
            $user->tenants()->get(),
            TenancyPermissionConstants::PERMISSION_CREATE_ORDERS
        );
    }

    public function findUserTenantForNewOrderByUuid(User $user, ?string $tenantUuid): ?Tenant
    {
        if ($tenantUuid === null) {
            return null;
        }

        return $this->tenantPermissionService->filterTenantsWhereUserHasPermission(
            $user->tenants()->where('uuid', $tenantUuid)->get(),
            TenancyPermissionConstants::PERMISSION_CREATE_ORDERS
        )->first();
    }

    public function findUserTenantsForNewSubscription(?User $user)
    {
        if ($user === null) {
            return collect();
        }

        return $this->tenantPermissionService->filterTenantsWhereUserHasPermission(
            $user->tenants()->whereDoesntHave('subscriptions', function ($query) {
                $query->whereIn('status', self::DISALLOWED_TENANT_SUBSCRIPTION_STATUSES);
            })->get(),
            TenancyPermissionConstants::PERMISSION_CREATE_SUBSCRIPTIONS
        );
    }

    public function findUserTenantForNewSubscriptionByUuid(User $user, ?string $tenantUuid): ?Tenant
    {
        if ($tenantUuid === null) {
            return null;
        }

        return $this->tenantPermissionService->filterTenantsWhereUserHasPermission(
            $user->tenants()->whereDoesntHave('subscriptions', function ($query) {
                $query->whereIn('status', $query->whereIn('status', self::DISALLOWED_TENANT_SUBSCRIPTION_STATUSES));
            })->where('uuid', $tenantUuid)->get(),
            TenancyPermissionConstants::PERMISSION_CREATE_SUBSCRIPTIONS
        )->first();
    }

    public function createTenant(User $user): Tenant
    {
        // add an enumeration to the name to avoid name conflicts

        $latestUserTenant = $user->tenants()->latest()->first();

        $number = 1;
        if ($latestUserTenant) {
            $parts = explode('#', $latestUserTenant->name);
            if (count($parts) > 1) {
                $number = $parts[count($parts) - 1];
                $number = (int) $number + 1;
            }
        }

        $name = $user->name.' '.TenantConstants::getAlias();

        $name .= ' #'.$number;

        $tenant = Tenant::create([
            'name' => $name,
            'uuid' => (string) Str::uuid(),
            'is_name_auto_generated' => true,
            'created_by' => $user->id,
        ]);

        $tenant->users()->attach($user);

        $this->tenantPermissionService->assignTenantUserRole($tenant, $user, TenancyPermissionConstants::TENANT_CREATOR_ROLE);

        return $tenant;
    }

    public function createTenantForFreePlanUser(User $user)
    {
        if ($user->tenants->count() == 0) {
            $this->createTenant($user);
        }
    }
}
