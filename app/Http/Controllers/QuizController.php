<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizController extends Controller
{
    public function index()
    {
        return view('quiz.index');
    }

    public function start(Request $request): JsonResponse
    {
        // If user already exists, return existing user; otherwise create a new one
        $user = User::whereRaw('LOWER(name) = ?', [strtolower($request->name)])->first();

        if (! $user) {
            $user = User::create(['name' => $request->name]);
        }

        // Save user_id in session
        session(['user_id' => $user->id]);

        // First random question
        $question = Question::with('answers')->inRandomOrder()->first();

        return response()->json([
            'user_id' => $user->id,
            'question' => $question
        ]);
    }

    public function nextQuestion(Request $request): JsonResponse
    {
        $used = $request->used ?? [];

        $question = Question::with('answers')
            ->whereNotIn('id', $used)
            ->inRandomOrder()
            ->first();

        return response()->json(['question' => $question]);
    }

    public function submitResult(Request $request): JsonResponse
    {
        Result::create([
            'user_id' => $request->user_id,
            'correct' => $request->correct,
            'wrong'   => $request->wrong,
            'skipped' => $request->skipped,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function results()
    {
        $results = Result::where('user_id', session('user_id'))
                        ->latest()
                        ->get();

        return view('quiz.result', compact('results'));
    }

}
