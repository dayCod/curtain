<?php

declare(strict_types=1);

namespace Daycode\Curtain\Http\Controllers;

use Daycode\Curtain\Facades\Curtain;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class PreviewController extends Controller
{
    /**
     * Display the maintenance page.
     */
    public function show(Request $request): View
    {
        abort_unless($request->hasValidSignature(), 403);

        $template = $request->template ?? 'default';
        $timer = $request->timer ? now()->add($request->timer) : null;

        return view("curtain::templates.{$template}", [
            'timer' => $timer?->toIso8601String(),
            'message' => $request->message,
            'refresh' => false,
            'preview' => true,
        ]);
    }

    /**
     * Disable maintenance mode.
     *
     * @throws \Exception
     */
    public function disable(): JsonResponse
    {
        try {
            if (! Curtain::isDownForMaintenance()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Application is not in maintenance mode',
                ], 400);
            }

            Curtain::disable();

            return response()->json([
                'status' => 'success',
                'message' => 'Maintenance mode disabled successfully',
            ], 200);

        } catch (\Exception) {

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to disable maintenance mode',
            ], 500);
        }
    }
}
