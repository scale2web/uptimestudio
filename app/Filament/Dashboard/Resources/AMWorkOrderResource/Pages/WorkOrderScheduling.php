<?php

namespace App\Filament\Dashboard\Resources\AMWorkOrderResource\Pages;

use App\Filament\Dashboard\Resources\AMWorkOrderResource;
use App\Models\AMWorkOrder;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class WorkOrderScheduling extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = AMWorkOrderResource::class;

    protected static string $view = 'filament.dashboard.resources.am-work-order-resource.pages.work-order-scheduling';

    protected static ?string $title = 'Work Order Scheduling';

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?string $navigationGroup = 'Jobs';

    protected static ?int $navigationSort = 2;

    public ?array $data = [];

    public ?string $start_date = null;
    public ?string $end_date = null;
    public ?string $work_order_type = null;
    public ?string $priority = null;
    public ?string $scheduling_method = null;
    public ?string $worker_group = null;

    public function mount(): void
    {
        // Initialize form with default values
        $this->start_date = now()->format('Y-m-d');
        $this->end_date = now()->addDays(30)->format('Y-m-d');
        $this->work_order_type = 'all';
        $this->priority = 'all';
        $this->scheduling_method = 'manual';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Schedule Filters')
                    ->description('Filter work orders for scheduling')
                    ->schema([
                        DatePicker::make('start_date')
                            ->label('Start Date')
                            ->default(now())
                            ->required(),

                        DatePicker::make('end_date')
                            ->label('End Date')
                            ->default(now()->addDays(30))
                            ->required(),

                        Select::make('work_order_type')
                            ->label('Work Order Type')
                            ->options([
                                'all' => 'All Types',
                                'corrective' => 'Corrective',
                                'preventive' => 'Preventive',
                                'safety' => 'Safety',
                            ])
                            ->default('all'),

                        Select::make('priority')
                            ->label('Priority')
                            ->options([
                                'all' => 'All Priorities',
                                'high' => 'High',
                                'medium' => 'Medium',
                                'low' => 'Low',
                            ])
                            ->default('all'),
                    ])
                    ->columns(4),

                Section::make('Scheduling Options')
                    ->description('Configure scheduling parameters')
                    ->schema([
                        Select::make('worker_group')
                            ->label('Worker Group')
                            ->options(function () {
                                return \App\Models\AMWorkerGroup::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                                    ->pluck('name', 'id')
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        Select::make('scheduling_method')
                            ->label('Scheduling Method')
                            ->options([
                                'manual' => 'Manual Assignment',
                                'auto_balance' => 'Auto Balance Workload',
                                'skill_based' => 'Skill-Based Assignment',
                                'location_based' => 'Location-Based Assignment',
                            ])
                            ->default('manual')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public function scheduleWorkOrders(): void
    {
        // Get work orders based on filters
        $query = AMWorkOrder::query()
            ->where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->where('active', true)
            ->whereBetween('expected_start', [$this->start_date, $this->end_date]);

        // Apply type filter
        if ($this->work_order_type !== 'all') {
            $query->whereHas('workOrderType', function ($q) {
                $q->where('name', 'like', '%' . ucfirst($this->work_order_type) . '%');
            });
        }

        // Apply priority filter
        if ($this->priority !== 'all') {
            $query->whereHas('serviceLevel', function ($q) {
                $priorityMap = [
                    'high' => 3,
                    'medium' => 2,
                    'low' => 1,
                ];
                $q->where('criticality', $priorityMap[$this->priority]);
            });
        }

        $workOrders = $query->get();

        if ($workOrders->isEmpty()) {
            Notification::make()
                ->title('No Work Orders Found')
                ->body('No work orders match the selected criteria.')
                ->warning()
                ->send();
            return;
        }

        // Apply scheduling logic based on method
        $scheduledCount = 0;
        foreach ($workOrders as $workOrder) {
            if ($this->applyScheduling($workOrder)) {
                $scheduledCount++;
            }
        }

        Notification::make()
            ->title('Scheduling Complete')
            ->body("Successfully scheduled {$scheduledCount} work orders.")
            ->success()
            ->send();
    }

    protected function applyScheduling(AMWorkOrder $workOrder): bool
    {
        try {
            DB::beginTransaction();

            switch ($this->scheduling_method) {
                case 'auto_balance':
                    $this->autoBalanceWorkload($workOrder);
                    break;
                case 'skill_based':
                    $this->skillBasedAssignment($workOrder);
                    break;
                case 'location_based':
                    $this->locationBasedAssignment($workOrder);
                    break;
                default:
                    // Manual assignment - just update the work order
                    $workOrder->update([
                        'am_work_order_lifecycle_state_id' => $this->getScheduledStateId(),
                    ]);
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    protected function autoBalanceWorkload(AMWorkOrder $workOrder): void
    {
        // Find worker with least workload
        $worker = \App\Models\AMWorker::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->withCount(['workOrders' => function ($query) {
                $query->where('active', true)
                    ->where('am_work_order_lifecycle_state_id', $this->getScheduledStateId());
            }])
            ->orderBy('work_orders_count')
            ->first();

        if ($worker) {
            $workOrder->update([
                'scheduled_worker_personnel_number' => $worker->personnel_number,
                'am_work_order_lifecycle_state_id' => $this->getScheduledStateId(),
            ]);
        }
    }

    protected function skillBasedAssignment(AMWorkOrder $workOrder): void
    {
        // This would implement skill-based logic
        // For now, just update the state
        $workOrder->update([
            'am_work_order_lifecycle_state_id' => $this->getScheduledStateId(),
        ]);
    }

    protected function locationBasedAssignment(AMWorkOrder $workOrder): void
    {
        // This would implement location-based logic
        // For now, just update the state
        $workOrder->update([
            'am_work_order_lifecycle_state_id' => $this->getScheduledStateId(),
        ]);
    }

    protected function getScheduledStateId(): ?int
    {
        try {
            return \App\Models\AmWorkOrderLifecycleState::where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
                ->where('lifecycle_state', 'Scheduled')
                ->value('id');
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function isFormReady(): bool
    {
        return true; // Form is always ready since we initialize it in mount()
    }

    public function getScheduledWorkOrders()
    {
        return AMWorkOrder::query()
            ->where('tenant_id', \Filament\Facades\Filament::getTenant()->id)
            ->where('active', true)
            ->whereBetween('expected_start', [$this->start_date ?? now(), $this->end_date ?? now()->addDays(30)])
            ->with(['workOrderType', 'workOrderLifecycleState', 'responsibleWorker', 'workerGroup'])
            ->orderBy('expected_start')
            ->get();
    }

    public static function getUrl(array $parameters = [], bool $isAbsolute = true, ?string $panel = null, ?\Illuminate\Database\Eloquent\Model $tenant = null): string
    {
        return static::getResource()::getUrl('scheduling', $parameters, $isAbsolute, $panel, $tenant);
    }
}
