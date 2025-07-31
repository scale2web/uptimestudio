<?php

namespace App\Console\Commands;

use App\Models\AMAsset;
use App\Models\AmAssetType;
use App\Models\Tenant;
use Illuminate\Console\Command;

class CheckAssetTypeCompleteness extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-asset-type-completeness {--tenant= : Check specific tenant by ID} {--detailed : Show detailed breakdown}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check completeness of asset type assignments for AMAssets';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->option('tenant');
        $detailed = $this->option('detailed');

        $this->info('🔍 Asset Type Completeness Check');
        $this->info('================================');

        if ($tenantId) {
            $this->checkSpecificTenant($tenantId, $detailed);
        } else {
            $this->checkAllTenants($detailed);
        }
    }

    private function checkAllTenants($detailed)
    {
        // Overall statistics
        $totalAssets = AMAsset::count();
        $assetsWithType = AMAsset::whereNotNull('am_asset_type_id')->count();
        $assetsWithoutType = AMAsset::whereNull('am_asset_type_id')->count();
        $completionRate = $totalAssets > 0 ? round(($assetsWithType / $totalAssets) * 100, 2) : 0;

        $this->info("\n📊 Overall Statistics:");
        $this->info("Total AMAssets: {$totalAssets}");
        $this->info("Assets with Asset Type: {$assetsWithType}");
        $this->info("Assets without Asset Type: {$assetsWithoutType}");
        $this->info("Completion Rate: {$completionRate}%");

        if ($assetsWithoutType > 0) {
            $this->warn("\n⚠️  Found {$assetsWithoutType} assets without asset types!");
        } else {
            $this->info("\n✅ All assets have asset types assigned!");
        }

        // Check by tenant
        $tenants = Tenant::all();
        $this->info("\n🏢 Breakdown by Tenant:");
        
        foreach ($tenants as $tenant) {
            $tenantAssets = AMAsset::where('tenant_id', $tenant->id)->count();
            $tenantAssetsWithType = AMAsset::where('tenant_id', $tenant->id)
                ->whereNotNull('am_asset_type_id')->count();
            $tenantAssetsWithoutType = AMAsset::where('tenant_id', $tenant->id)
                ->whereNull('am_asset_type_id')->count();
            $tenantCompletionRate = $tenantAssets > 0 ? round(($tenantAssetsWithType / $tenantAssets) * 100, 2) : 0;

            $status = $tenantAssetsWithoutType > 0 ? '❌' : '✅';
            $this->info("{$status} Tenant {$tenant->id} ({$tenant->name}): {$tenantAssetsWithType}/{$tenantAssets} ({$tenantCompletionRate}%)");

            if ($detailed && $tenantAssetsWithoutType > 0) {
                $this->showAssetsWithoutType($tenant->id, $tenant->name);
            }
        }

        // Asset type distribution
        if ($detailed) {
            $this->showAssetTypeDistribution();
        }
    }

    private function checkSpecificTenant($tenantId, $detailed)
    {
        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            $this->error("Tenant with ID {$tenantId} not found!");
            return;
        }

        $this->info("\n🏢 Checking Tenant: {$tenant->name} (ID: {$tenantId})");
        
        $tenantAssets = AMAsset::where('tenant_id', $tenantId)->count();
        $tenantAssetsWithType = AMAsset::where('tenant_id', $tenantId)
            ->whereNotNull('am_asset_type_id')->count();
        $tenantAssetsWithoutType = AMAsset::where('tenant_id', $tenantId)
            ->whereNull('am_asset_type_id')->count();
        $tenantCompletionRate = $tenantAssets > 0 ? round(($tenantAssetsWithType / $tenantAssets) * 100, 2) : 0;

        $this->info("Total Assets: {$tenantAssets}");
        $this->info("Assets with Asset Type: {$tenantAssetsWithType}");
        $this->info("Assets without Asset Type: {$tenantAssetsWithoutType}");
        $this->info("Completion Rate: {$tenantCompletionRate}%");

        if ($tenantAssetsWithoutType > 0) {
            $this->warn("\n⚠️  Found {$tenantAssetsWithoutType} assets without asset types!");
            $this->showAssetsWithoutType($tenantId, $tenant->name);
        } else {
            $this->info("\n✅ All assets have asset types assigned!");
        }

        if ($detailed) {
            $this->showAssetTypeDistribution($tenantId);
        }
    }

    private function showAssetsWithoutType($tenantId, $tenantName)
    {
        $assetsWithoutType = AMAsset::where('tenant_id', $tenantId)
            ->whereNull('am_asset_type_id')
            ->get(['id', 'maintenance_asset', 'name']);

        $this->info("\n📋 Assets without Asset Type in {$tenantName}:");
        $this->table(
            ['ID', 'Maintenance Asset', 'Name'],
            $assetsWithoutType->map(function ($asset) {
                return [
                    $asset->id,
                    $asset->maintenance_asset ?? 'N/A',
                    $asset->name ?? 'N/A'
                ];
            })->toArray()
        );
    }

    private function showAssetTypeDistribution($tenantId = null)
    {
        $query = AMAsset::whereNotNull('am_asset_type_id')
            ->with('assetType');

        if ($tenantId) {
            $query->where('tenant_id', $tenantId);
        }

        $assetTypeCounts = $query->get()
            ->groupBy('am_asset_type_id')
            ->map(function ($assets) {
                return $assets->count();
            });

        $assetTypes = AmAssetType::whereIn('id', $assetTypeCounts->keys())
            ->get(['id', 'maintenance_asset_type', 'name']);

        $this->info("\n📈 Asset Type Distribution:");
        $distribution = [];
        foreach ($assetTypes as $assetType) {
            $count = $assetTypeCounts->get($assetType->id, 0);
            $distribution[] = [
                $assetType->maintenance_asset_type,
                $assetType->name,
                $count
            ];
        }

        $this->table(
            ['Asset Type Code', 'Asset Type Name', 'Count'],
            $distribution
        );
    }
}
