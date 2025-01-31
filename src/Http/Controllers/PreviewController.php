<?php

declare(strict_types=1);

namespace Daycode\Curtain\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PreviewController extends Controller
{
    public function show(Request $request)
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
}
