<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\VocabWords;

class TokenizeController extends Controller

{
    public function tokenize(Request $request)
    {
        $words = $request->words;
        $wordIds = array_column($words, 'word_id');
        $foundWords = VocabWords::whereIn('id', $wordIds)->get();
        $responses = [];

        foreach ($words as $word) {
            if (!preg_match("/^[ぁ-んァ-ヶ一-龠々〆〤]+$/u", $word['word'])) {
                continue;
            }
            $dbWord = $foundWords->firstWhere('id', $word['word_id']);
            if (!$dbWord) {
                $jishoResponse = Http::get('https://jisho.org/api/v1/search/words', [
                    'keyword' => $word['word']
                ]);
                if ($jishoResponse->successful()) {
                    $response["word"] = $jishoResponse['data'][0]['slug'];
                    $response["meaning"] = implode(',', $jishoResponse['data'][0]['senses'][0]['english_definitions']);
                    $response["registered"] = false;
                }
            } else {
                $response["word"] = $dbWord->word;
                $response["meaning"] = $dbWord->meaning;;
                $response["registered"] = true;
            }
            $response["word_id"] = $word['word_id'];
            array_push($responses, json_encode($response, JSON_UNESCAPED_UNICODE));
        }

        return response()->json($responses);
    }

    public function store (Request $request)
    {
        $foundWord = VocabWords::where('id', $request->word_id)->first();
        if (!$foundWord) {
            $vocabWord = VocabWords::create([
                'id' => $request->word_id,
                'word' => $request->word,
                'meaning' => $request->meaning,
            ]);
        }

        return response()->json(null, 201);
    }

    public function remove ($id)
    {
        $foundWord = VocabWords::find($id);

        if ($foundWord) {
            $foundWord->delete();
            return response()->json(null, 204);
        }

        return response()->json(null, 404);
    }

    public function index()
    {
        $vocabWords = VocabWords::all();
        return view('vocabwords', ['vocabWords' => $vocabWords]);
    }
}