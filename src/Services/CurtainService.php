<?php

declare(strict_types=1);

namespace Daycode\Curtain\Services;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CurtainService
{
    /**
     * @var string Cache key for storing maintenance timer
     */
    protected const CACHE_KEY = 'curtain:timer';

    /**
     * @var string Path to maintenance mode file
     */
    protected const MAINTENANCE_PATH = 'framework/down';

    /**
     * Enable maintenance mode with the given options.
     *
     * @param  array  $options  Configuration options for maintenance mode
     */
    public function enable(array $options = []): void
    {
        $payload = $this->buildMaintenancePayload($options);

        $this->writeMaintenanceFile($payload);

        if (isset($options['timer'])) {
            $this->setTimer($options['timer']);
        }
    }

    /**
     * Disable maintenance mode and clear associated data.
     */
    public function disable(): void
    {
        $this->removeMaintenanceFile();
        $this->clearTimer();
    }

    /**
     * Check if the application is in maintenance mode.
     *
     * @return bool True if in maintenance mode, false otherwise
     */
    public function isDownForMaintenance(): bool
    {
        return file_exists($this->maintenanceFilePath());
    }

    /**
     * Check if the request has a valid bypass token.
     *
     * @param  Request  $request  The HTTP request
     * @return bool True if bypass token is valid
     */
    public function hasValidBypassToken(Request $request): bool
    {
        if (! $this->isDownForMaintenance()) {
            return false;
        }

        $data = $this->getMaintenanceData();

        return isset($data['secret']) && $request->path() === $data['secret'];
    }

    /**
     * Render the maintenance mode view.
     *
     * @return Response The HTTP response containing the maintenance view
     */
    public function render(): Response
    {
        $data = $this->getMaintenanceData();
        $template = $data['template'] ?? config('curtain.default_template', 'default');
        $timer = $this->getTimer();

        return response()->view("curtain::templates.{$template}", [
            'timer' => $timer?->toIso8601String(),
            'message' => $data['message'] ?? null,
            'retry' => $data['retry'] ?? null,
            'refresh' => $data['refresh'] ?? false,
        ], Response::HTTP_SERVICE_UNAVAILABLE);
    }

    /**
     * Set the maintenance mode timer.
     *
     * @param  string  $duration  Duration string (e.g., "PT2H" for 2 hours)
     */
    protected function setTimer(string $duration): void
    {
        $endTime = Carbon::now()->add($duration);
        Cache::put(self::CACHE_KEY, $endTime);
    }

    /**
     * Get the current maintenance timer if set.
     *
     * @return Carbon|null The end time or null if no timer is set
     */
    protected function getTimer(): ?Carbon
    {
        return Cache::get(self::CACHE_KEY);
    }

    /**
     * Clear the maintenance timer.
     */
    protected function clearTimer(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Build the maintenance mode payload from options.
     *
     * @param  array  $options  Configuration options
     * @return array The maintenance payload
     */
    protected function buildMaintenancePayload(array $options): array
    {
        return [
            'time' => Carbon::now()->timestamp,
            'message' => $options['message'] ?? null,
            'retry' => $options['retry'] ?? null,
            'refresh' => $options['refresh'] ?? false,
            'template' => $options['template'] ?? null,
            'secret' => $options['secret'] ?? null,
        ];
    }

    /**
     * Get the full path to the maintenance file.
     *
     * @return string The maintenance file path
     */
    protected function maintenanceFilePath(): string
    {
        return storage_path(self::MAINTENANCE_PATH);
    }

    /**
     * Write the maintenance payload to file.
     *
     * @param  array  $payload  The maintenance configuration
     */
    protected function writeMaintenanceFile(array $payload): void
    {
        File::put(
            $this->maintenanceFilePath(),
            json_encode($payload, JSON_PRETTY_PRINT)
        );
    }

    /**
     * Remove the maintenance file if it exists.
     */
    protected function removeMaintenanceFile(): void
    {
        if (File::exists($this->maintenanceFilePath())) {
            File::delete($this->maintenanceFilePath());
        }
    }

    /**
     * Get the current maintenance configuration.
     *
     * @return array The maintenance configuration
     */
    protected function getMaintenanceData(): array
    {
        return json_decode(
            file_get_contents($this->maintenanceFilePath()),
            true
        );
    }

    /**
     * Get all available maintenance templates.
     *
     * @return array List of available templates
     */
    public function getAvailableTemplates(): array
    {
        $templates = config('curtain.templates', []);

        if (config('curtain.allow_custom_templates', true)) {
            $customTemplates = $this->scanCustomTemplates();
            $templates = array_merge($templates, $customTemplates);
        }

        return $templates;
    }

    /**
     * Scan for custom maintenance templates.
     *
     * @return array List of custom templates found
     */
    protected function scanCustomTemplates(): array
    {
        $path = config('curtain.custom_templates_path');

        if (! is_dir($path)) {
            return [];
        }

        $files = glob($path.'/*.blade.php');
        $templates = [];

        foreach ($files as $file) {
            $name = basename($file, '.blade.php');
            $templates[$name] = [
                'name' => Str::title(str_replace('-', ' ', $name)),
                'view' => "vendor.curtain.templates.{$name}",
            ];
        }

        return $templates;
    }

    /**
     * Check if a path should be allowed through maintenance mode.
     *
     * @param  string  $path  The path to check
     * @return bool True if path should be accessible
     */
    public function shouldPassThroughPath(string $path): bool
    {
        $excludedPaths = config('curtain.excluded_paths', []);

        if (in_array($path, $excludedPaths)) {
            return true;
        }

        foreach ($excludedPaths as $excludedPath) {
            $excludedPath = rtrim((string) $excludedPath, '/');
            $path = rtrim($path, '/');

            if (str_contains($excludedPath, '*')) {
                $pattern = str_replace('*', '.*', $excludedPath);
                if (preg_match('#^'.$pattern.'$#i', $path)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check if an IP address is allowed during maintenance mode.
     *
     * @param  string|null  $ip  The IP address to check
     * @return bool True if IP is whitelisted
     */
    public function isAllowedIp(?string $ip): bool
    {
        $allowedIps = config('curtain.allowed_ips', []);

        if (empty($allowedIps)) {
            return false;
        }

        return in_array($ip, $allowedIps);
    }

    /**
     * Check if a request should be allowed through maintenance mode.
     *
     * @param  Request  $request  The HTTP request
     * @return bool True if request should be allowed
     */
    public function canAccessPath(Request $request): bool
    {
        if (! $this->isDownForMaintenance()) {
            return true;
        }

        if ($this->shouldPassThroughPath($request->path())) {
            return true;
        }

        if ($this->isAllowedIp($request->ip())) {
            return true;
        }

        return $this->hasValidBypassToken($request);
    }
}
