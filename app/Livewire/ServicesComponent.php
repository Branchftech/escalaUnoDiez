<?php

namespace App\Livewire;

use App\Services\AlertService;
use App\Services\LoggerService;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use App\Services\PermissionService;

abstract class ServicesComponent extends Component
{

    use LivewireAlert;

    protected AlertService $alertService;
    protected LoggerService $loggerService;
    protected PermissionService $permissionService;

    public function __construct()
    {
        $this->alertService = app(AlertService::class);
        $this->loggerService = app(LoggerService::class);
        $this->permissionService = app(PermissionService::class);
    }
}
