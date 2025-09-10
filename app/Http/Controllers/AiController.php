<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class AiController extends Controller
{
    /**
     * Generates a 15-week topic list for a subject using Google's AI.
     */
    public function generateLessonTopics(Request $request)
    {
        $validated = $request->validate(['subjectName' => 'required|string|max:255']);
        $apiKey = env('GOOGLE_API_KEY');

        if (!$apiKey) {
            return response()->json(['error' => 'Google AI API key is not configured.'], 500);
        }

        $prompt = "Generate a 15-week list of topics for the subject '{$validated['subjectName']}' suitable for early college-level students. IMPORTANT: The output must be a valid JSON object with keys from 'Week 1' to 'Week 15', and the value for each key should be the topic title as a string. Do not include any text or markdown formatting before or after the JSON object.";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}";

        try {
            $response = Http::post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => ['responseMimeType' => 'application/json']
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'Failed to generate topics from Google AI.', 'details' => $response->json()], $response->status());
            }

            $responseText = $response->json()['candidates'][0]['content']['parts'][0]['text'];
            $topics = json_decode($responseText, true);

            return response()->json($topics);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while generating topics.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Generates a detailed lesson plan for a specific topic using Google's AI.
     */
    public function generateLessonPlan(Request $request)
    {
        $validated = $request->validate([
            'subjectName' => 'required|string|max:255',
            'topic' => 'required|string|max:255',
        ]);

        $apiKey = env('GOOGLE_API_KEY');
        if (!$apiKey) {
            return response()->json(['error' => 'Google AI API key is not configured.'], 500);
        }

        $prompt = "Generate a detailed lesson for '{$validated['topic']}' in the subject '{$validated['subjectName']}' for early college-level students. The output must be a valid JSON object with keys: 'topic', 'learning_objectives' (array of objects), 'lesson_plan_table' (array of objects), 'detailed_lesson_content' (Markdown string), and 'assessment' (string). Do not include any text or markdown before or after the JSON.";
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key={$apiKey}";

        try {
            $response = Http::post($url, [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => ['responseMimeType' => 'application/json']
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'Failed to generate lesson plan from Google AI.', 'details' => $response->json()], $response->status());
            }

            $responseText = $response->json()['candidates'][0]['content']['parts'][0]['text'];
            $lessonPlan = json_decode($responseText, true);
            
            return response()->json($lessonPlan);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred while generating the lesson plan.', 'details' => $e->getMessage()], 500);
        }
    }
}