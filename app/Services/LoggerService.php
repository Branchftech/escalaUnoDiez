<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class LoggerService
{
    public function logInfo(string $message)
    {
        Log::channel('permisos')->info($message);
    }

    public function logWarning(string $message)
    {
        Log::channel('permisos')->warning($message);
    }

    public function logError(string $message)
    {
        Log::channel('errores')->error($message);
    }
}
