<?php

declare(strict_types=1);

namespace Daycode\Curtain\Commands;

use Daycode\Curtain\Facades\Curtain;

class CurtainTemplatesCommand extends BaseCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'curtain:templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all available maintenance mode templates';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $templates = Curtain::getAvailableTemplates();

        $this->table(
            ['Template', 'Name', 'View'],
            collect($templates)->map(fn ($template, $key): array => [
                $key,
                $template['name'],
                $template['view'],
            ])
        );

        return self::SUCCESS;
    }
}
