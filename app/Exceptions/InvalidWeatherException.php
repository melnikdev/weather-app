<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class InvalidWeatherException extends Exception
{
    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('InvalidWeatherException', ['exception' => $this->getMessage()]);
    }

    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): View
    {
        $weather = (object) ['error' => 'Bad Request', 'city' => $request->route('city')];

        return view('weather', ['weather' => $weather]);
    }
}