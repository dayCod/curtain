<?php

declare(strict_types=1);

namespace Daycode\Curtain\Commands;

use Daycode\Curtain\Facades\Curtain;

class CurtainDownCommand extends BaseCommand
{
    protected $signature = 'curtain:down';

    protected $description = 'Bring the application out of maintenance mode';

    public function handle(): int
    {
        try {
            Curtain::disable();

            $this->components->info('Application is now live.');

            return self::SUCCESS;
        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
