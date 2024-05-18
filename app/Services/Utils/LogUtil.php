<?php

namespace App\Services\Utils;

use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogUtil
{
    /**
     * Log a warning message.
     *
     * @param string $msg The warning message.
     * @return void
     */
    public static function warn(string $msg): void
    {
        Log::warning($msg);
    }

    /**
     * Log an informational message.
     *
     * @param string $msg The informational message.
     * @return void
     */
    public static function info(string $msg): void
    {
        Log::info($msg);
    }

    /**
     * Log a debug message.
     *
     * @param string $msg The debug message.
     * @return void
     */
    public static function debug(string $msg): void
    {
        Log::debug($msg);
    }

    /**
     * Log an error message.
     *
     * @param string $msg The error message.
     * @return void
     */
    public static function error(string $msg): void
    {
        Log::error($msg);
    }

    /**
     * Log an error message along with exception details.
     *
     * @param string|null $message The error message.
     * @param Exception|null $exception The exception object.
     * @return void
     * @throws Exception
     */
    public static function logError(?string $message, ?Exception $exception = null): void
    {
        // Sanity check.
        if ($exception == null && $message == null) {
            return; // Do nothing.
        }
        // Convert message to exception, if needed.
        if ($exception == null) {
            $exception = new Exception($message);
        }

        // Send message to Sentry and local log files.
        self::reportException(exception: $exception);
    }

    /**
     * Report an exception to Sentry and local log files.
     *
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    private static function reportException(Exception $exception): void
    {
        self::error($exception->getMessage());

        $userId = self::getUserId();
        \Sentry\configureScope(function (\Sentry\State\Scope $scope) use ($userId): void {
            $scope->setUser(['id' => $userId]);
        });

        if (class_exists('Sentry')) {
            \Sentry\captureException($exception);
        } elseif (app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }
    }

    /**
     * Get the user ID.
     *
     * @return mixed|string The user ID or a default string if not available.
     * @throws Exception in case of invalid identity.
     */
    private static function getUserId(): mixed
    {
        // CASE 1: No user could be determined in case of CLI invocation.
        if (self::isCLI()) {
            return 'CLI';
        }

        // CASE 2: Not logged user.
        if (Auth::user() == null) {
            return 'Not logged in.'; // Not logged in.
        }
        // CASE 3: User logged in.
        return Auth::user()->id;
    }

    /**
     * Check if the script is running in CLI mode.
     *
     * @return bool True if running in CLI mode, false otherwise.
     */
    private static function isCLI(): bool
    {
        return php_sapi_name() === 'cli';
    }
}
