<?php

declare(strict_types=1);

namespace Daycode\Curtain\Commands;

use Daycode\Curtain\Facades\Curtain;

class CurtainDownCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curtain:down';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bring the application out of maintenance mode';

    /**
     * Execute the console command.
     */
    public function handle()
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
