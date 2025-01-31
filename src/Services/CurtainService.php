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

        $data = json_decode(file_get_contents($this->maintenanceFilePath()), true);

        return isset($data['secret']) &&
               $request->path() === $data['secret'];
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
            'allowed_ips' => $options['allowed_ips'] ?? [],
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
}
