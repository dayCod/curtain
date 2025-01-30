<?php

declare(strict_types=1);

namespace Daycode\Curtain\Commands;

use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    protected function validateTimer(?string $timer): bool
    {
        if (!$timer) {
            return true;
        }

        // Explicit boolean return untuk memastikan return type bool
        return (bool) preg_match('/^\d+\s*(second|minute|hour|day|week)s?$/', $timer);
    }

    protected function parseTimer(string $timer): string
    {
        preg_match('/^(\d+)\s*(second|minute|hour|day|week)s?$/', $timer, $matches);

        $amount = (int) $matches[1];
        $unit = strtolower($matches[2]);

        // Convert ke format DateInterval yang valid
        return match($unit) {
            'second' => "PT{$amount}S",
            'minute' => "PT{$amount}M",
            'hour' => "PT{$amount}H",
            'day' => "P{$amount}D",
            'week' => "P" . ($amount * 7) . "D",
            default => throw new \InvalidArgumentException("Invalid time unit: {$unit}")
        };
    }
}
