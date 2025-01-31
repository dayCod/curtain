<?php

declare(strict_types=1);

use Daycode\Curtain\Services\CurtainService;
use Illuminate\Support\Facades\Cache;

test('can enable maintenance mode', function (): void {
    $service = new CurtainService;

    $service->enable([
        'message' => 'Test maintenance',
        'timer' => 'PT2H',
    ]);

    expect($service->isDownForMaintenance())->toBeTrue()
        ->and(json_decode(file_get_contents(storage_path('framework/down')), true))
        ->toHaveKey('message', 'Test maintenance');
});

test('can disable maintenance mode', function (): void {
    $service = new CurtainService;

    $service->enable(['message' => 'Test']);
    expect($service->isDownForMaintenance())->toBeTrue();

    $service->disable();
    expect($service->isDownForMaintenance())->toBeFalse();
});

test('can set and get timer', function (): void {
    $service = new CurtainService;

    $service->enable(['timer' => 'PT2H']);

    expect(Cache::has('curtain:timer'))->toBeTrue()
        ->and(Cache::get('curtain:timer'))->toBeInstanceOf(\Carbon\Carbon::class);
});

test('can render maintenance page', function (): void {
    $service = new CurtainService;

    $service->enable([
        'message' => 'Test message',
        'template' => 'default',
    ]);

    $response = $service->render();

    expect($response->status())->toBe(503)
        ->and($response->content())->toContain('Test message');
});
