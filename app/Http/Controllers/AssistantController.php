<?php

namespace App\Http\Controllers;

use App\Services\SiteAssistantService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use UnexpectedValueException;

class AssistantController extends Controller
{
    public function __invoke(Request $request, string $locale, SiteAssistantService $assistant): JsonResponse
    {
        $validated = $request->validate([
            'question' => ['required', 'string', 'min:2', 'max:1000'],
            'website' => ['nullable', 'string', 'max:0'],
        ]);

        try {
            return response()->json([
                'answer' => $assistant->answer($validated['question'], $locale),
                'actions' => $assistant->actions($validated['question'], $locale),
            ]);
        } catch (ConnectionException|RequestException|UnexpectedValueException $exception) {
            report($exception);

            return response()->json([
                'message' => match ($locale) {
                    'uz' => 'Yordamchi hozircha javob bera olmadi. Iltimos, keyinroq urinib ko‘ring yoki biz bilan bog‘laning.',
                    'en' => 'The assistant is temporarily unavailable. Please try again later or contact us.',
                    default => 'Помощник временно недоступен. Попробуйте позже или свяжитесь с нами.',
                },
            ], 502);
        }
    }
}
