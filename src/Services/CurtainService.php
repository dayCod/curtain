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
    protected const CACHE_KEY = 'curtain:timer';

    protected const MAINTENANCE_PATH = 'framework/down';

    public function enable(array $options = []): void
    {
        $payload = $this->buildMaintenancePayload($options);

        $this->writeMaintenanceFile($payload);

        if (isset($options['timer'])) {
            $this->setTimer($options['timer']);
        }
    }

    public function disable(): void
    {
        $this->removeMaintenanceFile();
        $this->clearTimer();
    }

    public function isDownForMaintenance(): bool
    {
        return file_exists($this->maintenanceFilePath());
    }

    public function hasValidBypassToken(Request $request): bool
    {
        if (! $this->isDownForMaintenance()) {
            return false;
        }

        $data = $this->getMaintenanceData();

        return isset($data['secret']) && $request->path() === $data['secret'];
    }

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

    protected function setTimer(string $duration): void
    {
        $endTime = Carbon::now()->add($duration);
        Cache::put(self::CACHE_KEY, $endTime);
    }

    protected function getTimer(): ?Carbon
    {
        return Cache::get(self::CACHE_KEY);
    }

    protected function clearTimer(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

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

    protected function maintenanceFilePath(): string
    {
        return storage_path(self::MAINTENANCE_PATH);
    }

    protected function writeMaintenanceFile(array $payload): void
    {
        File::put(
            $this->maintenanceFilePath(),
            json_encode($payload, JSON_PRETTY_PRINT)
        );
    }

    protected function removeMaintenanceFile(): void
    {
        if (File::exists($this->maintenanceFilePath())) {
            File::delete($this->maintenanceFilePath());
        }
    }

    protected function getMaintenanceData(): array
    {
        return json_decode(
            file_get_contents($this->maintenanceFilePath()),
            true
        );
    }

    public function getAvailableTemplates(): array
    {
        $templates = config('curtain.templates', []);

        if (config('curtain.allow_custom_templates', true)) {
            $customTemplates = $this->scanCustomTemplates();
            $templates = array_merge($templates, $customTemplates);
        }

        return $templates;
    }

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

    public function isAllowedIp(?string $ip): bool
    {
        $allowedIps = config('curtain.allowed_ips', []);

        if (empty($allowedIps)) {
            return false;
        }

        return in_array($ip, $allowedIps);
    }

    public function canAccessPath(Request $request): bool
    {
        if (! $this->isDownForMaintenance()) {
            return true;
        }

        if ($this->shouldPassThroughPath($request->path())) {
            return true;
        }

        if ( $this->isAllowedIp($request->ip())) {
            return true;
        }

        return $this->hasValidBypassToken($request);
    }
}
