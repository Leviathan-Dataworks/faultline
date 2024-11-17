<?php

namespace leviathan\Faultline;

use Exception;
use Illuminate\Support\Facades\Http;
use Throwable;

class Faultline
{
    public function sendErrors(Throwable $exception, $session = null)
    {
        // logger('in Faultline->sendErrors...');
        if (!$faultline = config('faultline')) {
            return false;
        }
        try {
            Http::withToken($faultline['token'])
                ->post($faultline['url'], [
                    'client_timestamp' => now()->toIso8601String(),
                    'message' => $exception->getMessage(),
                    'exception' => get_class($exception),
                    'stack_trace' => $exception->getTraceAsString(),
                    'project_id' => $faultline['project'],
                    // Add more context as needed
                    'session' => $session ?? json_encode($session),
                    'environment' => config('app.env'),
                ]);
        } catch (Exception $e) {
            // Handle potential exceptions during the reporting process (e.g., log locally)
            logger()->error('Failed to report error to central service: ' . $e->getMessage());
        }
    }
}
