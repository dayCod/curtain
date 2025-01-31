<?php

declare(strict_types=1);

test('curtain:up command enables maintenance mode', function (): void {
    $this->artisan('curtain:up', [
        '--message' => 'Test maintenance',
        '--timer' => '2 hours',
    ])
        ->assertSuccessful();
});
