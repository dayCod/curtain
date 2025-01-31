<?php

declare(strict_types=1);

namespace Daycode\Curtain\Commands;

use Daycode\Curtain\Facades\Curtain;

class CurtainUpCommand extends BaseCommand
{
    protected $signature = 'curtain:up
                          {--timer= : Duration for maintenance mode (e.g., "2 hours", "30 minutes")}
                          {--message= : Custom message to display}
                          {--template= : Template to use}
                          {--secret= : Secret token for bypass}
                          {--allow-ip=* : IPs to allow during maintenance}
                          {--refresh : Auto refresh the maintenance page}';

    protected $description = 'Put the application into maintenance mode with Curtain';

    public function handle(): int
    {
        if (($timer = $this->option('timer')) && ! $this->validateTimer($timer)) {
            $this->error('Invalid timer format. Use format like "2 hours" or "30 minutes".');

            return self::FAILURE;
        }

        try {
            Curtain::enable([
                'timer' => $timer ? $this->parseTimer($timer) : null,
                'message' => $this->option('message'),
                'template' => $this->option('template'),
                'secret' => $this->option('secret') ?? $this->generateSecret(),
                'allowed_ips' => $this->option('allow-ip'),
                'refresh' => $this->option('refresh'),
            ]);

            $this->components->info('Application is now in maintenance mode.');

            if ($timer) {
                $this->components->info("Maintenance mode will be disabled after {$timer}.");
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    protected function generateSecret(): string
    {
        return md5(uniqid('', true));
    }
}
