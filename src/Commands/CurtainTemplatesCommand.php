<?php

declare(strict_types=1);

namespace Daycode\Curtain\Commands;

use Daycode\Curtain\Facades\Curtain;

class CurtainTemplatesCommand extends BaseCommand
{
    protected $signature = 'curtain:templates';

    protected $description = 'List all available maintenance mode templates';

    public function handle(): int
    {
        $templates = Curtain::getAvailableTemplates();

        $this->table(
            ['Template', 'Name', 'View'],
            collect($templates)->map(fn($template, $key) => [
                $key,
                $template['name'],
                $template['view']
            ])
        );

        return self::SUCCESS;
    }
}
