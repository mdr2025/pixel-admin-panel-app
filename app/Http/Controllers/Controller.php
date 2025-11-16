<?php

namespace App\Http\Controllers;


use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

use PixelApp\Http\Controllers\PixelBaseController;

class Controller extends PixelBaseController
{
    /*
    |--------------------------------------------------------------------------
    | Prepare Logging Context
    |--------------------------------------------------------------------------
    */
    protected function prepareLoggingContext(
        array $loggingContext = [],
        string $operationName = "operation",
        bool $appendRequestDataToLog = true,
        bool $appendLoggedUserKeyToLog = true
    ): array {

        $loggingContext["operation"] = $operationName;

        if ($appendLoggedUserKeyToLog && Auth::check()) {
            $loggingContext['user_id'] = Auth::id();
        }

        if ($appendRequestDataToLog) {
            $loggingContext['request'] = request()->all();
        }

        return $loggingContext;
    }


    /*
    |--------------------------------------------------------------------------
    | Helper to Execute Callback
    |--------------------------------------------------------------------------
    */
    protected function executeCallback(callable $callback, array $args = []): mixed
    {
        return call_user_func($callback, ...$args);
    }


    /*
    |--------------------------------------------------------------------------
    | 1) Log only when operation fails
    |--------------------------------------------------------------------------
    */
    public function logOnFailureOnly(
        callable $callback,
        array $args = [],
        string $operationName = "operation",
        ?string $loggingFailingMsg = null,
        array $loggingContext = [],
        bool $appendRequestDataToLog = true,
        bool $appendLoggedUserKeyToLog = true
    ): mixed {

        try {

            return $this->executeCallback($callback, $args);

        } catch (Exception $e) {

            $context = $this->prepareLoggingContext(
                $loggingContext,
                $operationName,
                $appendRequestDataToLog,
                $appendLoggedUserKeyToLog
            );

            Log::error(
                $loggingFailingMsg ?? $e->getMessage(),
                $context
            );

            return Response::error($e->getMessage());
        }
    }


    /*
    |--------------------------------------------------------------------------
    | 2) Log only when operation succeeds
    |--------------------------------------------------------------------------
    */
    public function logOnSuccessOnly(
        callable $callback,
        array $args = [],
        string $operationName = "operation",
        ?string $loggingSuccessMsg = null,
        array $loggingContext = [],
        bool $appendRequestDataToLog = true,
        bool $appendLoggedUserKeyToLog = true
    ): mixed {

        $result = $this->executeCallback($callback, $args);

        $context = $this->prepareLoggingContext(
            $loggingContext,
            $operationName,
            $appendRequestDataToLog,
            $appendLoggedUserKeyToLog
        );

        Log::info(
            $loggingSuccessMsg ?? "Operation succeeded",
            $context
        );

        return $result;
    }


    /*
    |--------------------------------------------------------------------------
    | 3) Log Start + Success + Fail (full operation lifecycle)
    |--------------------------------------------------------------------------
    */
    public function logOperationWithStatus(
        callable $callback,
        array $args = [],
        string $operationName = "operation",
        ?string $loggingStartingMsg = null,
        ?string $loggingSuccessMsg = null,
        ?string $loggingFailingMsg = null,
        array $loggingContext = [],
        bool $appendRequestDataToLog = true,
        bool $appendLoggedUserKeyToLog = true,
        bool $logStart = true,
        bool $logSuccess = true,
        bool $logFailure = true
    ): mixed {

        // Prepare context once for efficiency
        $context = $this->prepareLoggingContext(
            $loggingContext,
            $operationName,
            $appendRequestDataToLog,
            $appendLoggedUserKeyToLog
        );

        /*
        | Log starting (if enabled)
        */
        if ($logStart) {
            Log::info(
                $loggingStartingMsg ?? "Operation started",
                $context
            );
        }

        /*
        | Try execute
        */
        try {

            $result = $this->executeCallback($callback, $args);

            /*
            | Log success (if enabled)
            */
            if ($logSuccess) {
                Log::info(
                    $loggingSuccessMsg ?? "Operation succeeded",
                    $context
                );
            }

            return $result;

        } catch (Exception $e) {

            /*
            | Log failure (if enabled)
            */
            if ($logFailure) {
                Log::error(
                    $loggingFailingMsg ?? $e->getMessage(),
                    $context
                );
            }

            return Response::error($e->getMessage());
        }
    }
}
