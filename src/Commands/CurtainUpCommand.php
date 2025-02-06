<?php

declare(strict_types=1);

namespace Daycode\Curtain\Commands;

use Daycode\Curtain\Facades\Curtain;

class CurtainUpCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curtain:up
                          {--timer= : Duration for maintenance mode (e.g., "2 hours", "30 minutes")}
                          {--message= : Custom message to display}
                          {--template= : Template to use}
                          {--secret= : Secret token for bypass}
                          {--refresh : Auto refresh the maintenance page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Put the application into maintenance mode with Curtain';

    /**
     * Execute the console command.
     */
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
                'refresh' => $this->option('refresh'),
            ]);

            $this->components->info('Application is now in maintenance mode.');

            // Show info about whitelisted IPs
            $allowedIps = config('curtain.allowed_ips', []);
            if (! empty($allowedIps)) {
                $this->components->info('Whitelisted IPs: '.implode(', ', $allowedIps));
            }

            if ($timer) {
                $this->components->info("Maintenance mode will be disabled after {$timer}.");
            }

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    /**
     * Generates a secret token for bypassing maintenance mode.
     */
    protected function generateSecret(): string
    {
        return md5(uniqid('', true));
    }
}
