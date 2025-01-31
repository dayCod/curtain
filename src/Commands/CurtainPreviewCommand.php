<?php

declare(strict_types=1);

namespace Daycode\Curtain\Commands;

use Illuminate\Support\Facades\URL;

class CurtainPreviewCommand extends BaseCommand
{
    protected $signature = 'curtain:preview
                          {--timer= : Preview with timer (e.g., "2 hours", "30 minutes")}
                          {--message= : Preview with custom message}
                          {--template= : Template to preview}';

    protected $description = 'Preview maintenance mode page';

    public function handle(): int
    {
        if (($timer = $this->option('timer')) && ! $this->validateTimer($timer)) {
            $this->error('Invalid timer format. Use format like "2 hours" or "30 minutes".');

            return self::FAILURE;
        }

        try {
            // Generate temporary signed URL tanpa token
            $url = URL::temporarySignedRoute(
                'curtain.preview',
                now()->addMinutes(5),
                [
                    'timer' => $timer ? $this->parseTimer($timer) : null,
                    'message' => $this->option('message'),
                    'template' => $this->option('template'),
                ]
            );

            $this->components->info("Preview URL (valid for 5 minutes): {$url}");

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
