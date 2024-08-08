<?php

namespace App\Services;

use Livewire\Component;

class AlertService
{
    public function success(Component $component, string $message)
    {
        $component->alert('success', $message);
    }

    public function error(Component $component, string $message)
    {
        $component->alert('error', $message);
    }

    public function info(Component $component, string $message)
    {
        $component->alert('info', $message);
    }

    public function warning(Component $component, string $message)
    {
        $component->alert('warning', $message);
    }
}
