<?php

namespace App\Http\Controllers;

use App\Models\FillInTheBlank;
use App\Models\MatchThePair;
use App\Models\MultipleChoice;
use App\Models\Worksheet;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WorksheetController extends Controller
{
    public function generateMultipleChoice(string $englishLevel, string $topic, int $numOfQuestions, int $numOfOptions)
    {
        try {
            $systemPrompt = <<<SYSPROMPT
        You are a strictly formatted multiple choice questions generator for English learners.

        TASK:
        Generate exactly $numOfQuestions question(s) based on the given topic.
        Generate exactly $numOfOptions possible answers for each question.
        The first option in the list is always the correct one.

        FORMAT:
        question:option:option:option;question:option:option:option;...
        Don't start the question by saying "question"

        RULES:
        - Use a colon (:) to separate an individual question and its options.
        - Use a semicolon (;) to separate a group of a question with options.
        - Do not include spaces.
        - Do not include sentences, explanations, or any extra text.

        EXAMPLE:
        Topic: Animals
        Output: Do you ____ dogs?:like:likes:liked;
        SYSPROMPT;

            $userPrompt = <<<USERPROMPT
        Level: $englishLevel
        Topic: $topic
        USERPROMPT;

            $response = Http::timeout(0)->post('http://127.0.0.1:11434/api/generate', [
                'model' => 'deepseek-r1:8b',
                'system' => $systemPrompt,
                'prompt' => $userPrompt,
                'stream' => false,
                'keep_alive' => 0,
            ]);

            $rawOutput = $response->json('response');
            return $this->getTrimmedResponse($rawOutput);
        } catch(Exception) {
            return null;
        }
    }

    public function generateMatchThePairs(string $englishLevel, string $topic, int $numOfPairs)
    {
        try {
            $systemPrompt = <<<SYSPROMPT
        You are a strictly formatted word pair generator for English learners.

        TASK:
        Generate exactly $numOfPairs pairs of related words based on the given topic.

        FORMAT:
        word1:word2,word3:word4

        RULES:
        - Use a colon (:) to separate words in a pair.
        - Use a comma (,) to separate pairs.
        - Do not include spaces.
        - Do not include sentences, explanations, or any extra text.

        EXAMPLE:
        Topic: Animals
        Output: dog:puppy,cat:kitten,cow:calf
        SYSPROMPT;

            $userPrompt = <<<USERPROMPT
        Level: $englishLevel
        Topic: $topic
        USERPROMPT;

            $response = Http::timeout(0)->post('http://127.0.0.1:11434/api/generate', [
                'model' => 'deepseek-r1:8b',
                'system' => $systemPrompt,
                'prompt' => $userPrompt,
                'stream' => false,
                'keep_alive' => 0,
            ]);

            $rawOutput = $response->json('response');
            return $this->getTrimmedResponse($rawOutput);

        } catch (Exception) {
            return null;
        }
    }

    public function generateFillInTheBlanks(string $englishLevel, string $topic, int $numOfBlanks)
    {
        try {
            $systemPrompt = <<<SYSPROMPT
        You are a strictly formatted exercise generator.

        TASK:
        Write a natural paragraph about the given topic.
        You MUST put exactly $numOfBlanks words or short phrases inside [square brackets] within the paragraph.

        STRICT RULES:
        1. BRACKETS: Every single one of the $numOfBlanks target words MUST be enclosed in [ ]. Example: "I [go] to school."
        2. COUNT: Total count of [ ] pairs must be exactly $numOfBlanks.
        3. DENSITY: Maximum 2 brackets per sentence.
        4. FOCUS:
           - If topic is a TENSE, bracket the verbs: "She [has finished] her work." Use negative, positive sentences and questions.
           - If topic is PREPOSITIONS, bracket them: "The cat is [under] the table."
        5. NO META-TEXT: Do not say "Here is your text". Output ONLY the paragraph.
        6. SINGLE BLOCK: Output as one continuous paragraph.
        SYSPROMPT;

            $userPrompt = <<<USERPROMPT
        Topic: $topic
        Level: $englishLevel
        USERPROMPT;

            $response = Http::timeout(0)->post('http://127.0.0.1:11434/api/generate', [
                'model' => 'deepseek-r1:8b',
                'system' => $systemPrompt,
                'prompt' => $userPrompt,
                'stream' => false,
                'keep_alive' => 0,
            ]);

            $rawOutput = $response->json('response');
            return $this->getTrimmedResponse($rawOutput);

        } catch (ConnectionException) {
            return null;
        }
    }

    public function generateExercise(Request $request)
    {
        $data = $request->all();

        if (!(isset($data['wsht-name']) && isset($data['wsht-theme']) && isset($data['wsht-level']) && isset($data['exercise-type']))) {
            return view('pages.editor', compact('data'))->with('error', 'Error while regenerating the exercise.');
        }

        if ($data['exercise-type'] === 'mc') {
            if (isset($data['multiple-choice']) && isset($data['multiple-choice-choices']) && isset($data['multiple-choice-questions'])) {
                if ($response = $this->handleMultipleChoice($data)) {
                    return $response;
                }
            }
        } else if ($data['exercise-type'] === 'fitb') {
            if (isset($data['fill-in-the-blanks']) && isset($data['fill-in-the-blanks-questions'])) {
                if ($response = $this->handleFillInTheBlanks($data)) {
                    return $response;
                }
            }
        } else if ($data['exercise-type'] === 'mtp') {
            if (isset($data['match-the-pairs']) && isset($data['match-the-pairs-questions'])) {
                if ($response = $this->handleMatchThePairs($data)) {
                    return $response;
                }
            }
        }

        return view('pages.editor', compact('data'));
    }

    public function generateWorksheet(Request $request)
    {
        $data = $request->validate([
            'wsht-name' => 'required|string',
            'wsht-theme' => 'required|string',
            'wsht-level' => 'required|string',
            'multiple-choice' => 'nullable|string',
            'fill-in-the-blanks' => 'nullable|string',
            'match-the-pairs' => 'nullable|string',
            'multiple-choice-questions' => 'nullable|integer',
            'multiple-choice-choices' => 'nullable|integer',
            'fill-in-the-blanks-questions' => 'nullable|integer',
            'match-the-pairs-questions' => 'nullable|integer',
        ]);

        if (!(isset($data['wsht-name']) && isset($data['wsht-theme']) && isset($data['wsht-level']))) {
            return view('pages.editor', compact('data'))->with('error', 'Error while generating exercises.');
        }

        if (isset($data['multiple-choice']) && isset($data['multiple-choice-choices']) && isset($data['multiple-choice-questions'])) {
            if ($response = $this->handleMultipleChoice($data)) {
                return $response;
            }
        }

        if (isset($data['fill-in-the-blanks']) && isset($data['fill-in-the-blanks-questions'])) {
            if ($response = $this->handleFillInTheBlanks($data)) {
                return $response;
            }
        }

        if (isset($data['match-the-pairs']) && isset($data['match-the-pairs-questions'])) {
            if ($response = $this->handleMatchThePairs($data)) {
                return $response;
            }
        }

        return view('pages.editor', compact('data'));
    }

//    public function generateWorksheet(Request $request)
//    {
//        $data = $request->validate([
//            'wsht-name' => 'required|string',
//            'wsht-theme' => 'required|string',
//            'wsht-level' => 'required|string',
//            'multiple-choice' => 'nullable|string',
//            'fill-in-the-blanks' => 'nullable|string',
//            'match-the-pairs' => 'nullable|string',
//            'multiple-choice-questions' => 'nullable|integer',
//            'multiple-choice-choices' => 'nullable|integer',
//            'fill-in-the-blanks-questions' => 'nullable|integer',
//            'match-the-pairs-questions' => 'nullable|integer',
//        ]);
//
//        if (isset($data['fill-in-the-blanks']) && isset($data['fill-in-the-blanks-questions'])) {
//            $fillInTheBlanks = $this->generateFillInTheBlanks($data['wsht-level'], $data['wsht-theme'], $data['fill-in-the-blanks-questions']);
//
//            if ($fillInTheBlanks === null) {
//                return view('pages.editor', compact('data'))->with('error', 'Error while generating the worksheet.');
//            }
//
//            $data['fintb-text'] = $fillInTheBlanks;
//        }
//
//        if (isset($data['match-the-pairs']) && isset($data['match-the-pairs-questions'])) {
//            $matchThePairs = $this->generateMatchThePairs($data['wsht-level'], $data['wsht-theme'], $data['match-the-pairs-questions']);
//
//            if ($matchThePairs === null) {
//                return view('pages.editor', compact('data'))->with('error', 'Error while generating the worksheet.');
//            }
//
//            $rawPairs = explode(",", $matchThePairs);
//
//            for($i = 0; $i < count($rawPairs); $i++) {
//                $pair = explode(':', $rawPairs[$i]);
//
//                if(sizeof($pair) == 2) {
//                    $data['mtp_lp_' . $i] = trim($pair[0]);
//                    $data['mtp_rp_' . $i] = trim($pair[1]);
//                    $data['match_the_pairs_' . $i] = true;
//                }
//            }
//        }
//
//        if (isset($data['multiple-choice']) && isset($data['multiple-choice-choices']) && isset($data['multiple-choice-questions'])) {
//            $multipleChoice = $this->generateMultipleChoice($data['wsht-level'], $data['wsht-theme'], $data['multiple-choice-questions'], $data['multiple-choice-choices']);
//
//            if ($multipleChoice === null) {
//                return view('pages.editor', compact('data'))->with('error', 'Error while generating the worksheet.');
//            }
//
//            //$data['test'] = $multipleChoice;
//
//            $rawMCQs = explode(";" , $multipleChoice);
//
//            // kontrola ci posledny prvok explodu je prazdny
//            $numOfMCQs = empty($rawMCQs[count($rawMCQs) - 1]) ? count($rawMCQs) - 1 : count($rawMCQs);
//
//            for ($i = 0; $i < $numOfMCQs; $i++) {
//                $MCQuestionAndOptions = explode(':', $rawMCQs[$i]);
//                $data['mch_question_' . $i + 1] = trim($MCQuestionAndOptions[0]);
//                $optionsArray = [];
//
//                for ($j = 1; $j < count($MCQuestionAndOptions); $j++) {
//                    $optionsArray[] = ['option'=> trim($MCQuestionAndOptions[$j]), 'checked' => $j == 1 ? "checked" : ""];
//                }
//
//                shuffle($optionsArray);
//
//                for ($j = 1; $j < count($MCQuestionAndOptions); $j++) {
//                    $data['mch_choice_text_' . $i + 1 . '_' . $j - 1] = $optionsArray[$j - 1]['option'];
//                    $data['mch_choice_checkbox_' . $i + 1 . '_' . $j - 1] = $optionsArray[$j - 1]['checked'];
//                }
//            }
//        }
//
//        return view('pages.editor', compact('data'));
//    }

    private function handleMultipleChoice(array &$data)
    {
        $multipleChoice = $this->generateMultipleChoice(
            $data['wsht-level'],
            $data['wsht-theme'],
            $data['multiple-choice-questions'],
            $data['multiple-choice-choices']
        );

        if ($multipleChoice === null) {
            return view('pages.editor', compact('data'))
                ->with('error', 'Error while generating the worksheet.');
        }

        $rawMCQs = explode(';', $multipleChoice);
        $numOfMCQs = empty($rawMCQs[count($rawMCQs) - 1]) ? count($rawMCQs) - 1 : count($rawMCQs);

        for ($i = 0; $i < $numOfMCQs; $i++) {
            $MCQuestionAndOptions = explode(':', $rawMCQs[$i]);
            $data['mch_question_' . ($i + 1)] = trim($MCQuestionAndOptions[0]);

            $optionsArray = [];

            for ($j = 1; $j < count($MCQuestionAndOptions); $j++) {
                $optionsArray[] = [
                    'option' => trim($MCQuestionAndOptions[$j]),
                    'checked' => $j == 1 ? 'checked' : '',
                ];
            }

            shuffle($optionsArray);

            for ($j = 1; $j < count($MCQuestionAndOptions); $j++) {
                $data['mch_choice_text_' . ($i + 1) . '_' . ($j - 1)] = $optionsArray[$j - 1]['option'];
                $data['mch_choice_checkbox_' . ($i + 1) . '_' . ($j - 1)] = $optionsArray[$j - 1]['checked'];
            }
        }

        return null;
    }

    private function handleFillInTheBlanks(array &$data)
    {
        $fillInTheBlanks = $this->generateFillInTheBlanks(
            $data['wsht-level'],
            $data['wsht-theme'],
            $data['fill-in-the-blanks-questions']
        );

        if ($fillInTheBlanks === null) {
            return view('pages.editor', compact('data'))
                ->with('error', 'Error while generating the worksheet.');
        }

        $data['fintb-text'] = $fillInTheBlanks;

        return null;
    }

    private function handleMatchThePairs(array &$data)
    {
        $matchThePairs = $this->generateMatchThePairs(
            $data['wsht-level'],
            $data['wsht-theme'],
            $data['match-the-pairs-questions']
        );

        if ($matchThePairs === null) {
            return view('pages.editor', compact('data'))
                ->with('error', 'Error while generating the worksheet.');
        }

        $rawPairs = explode(',', $matchThePairs);

        for ($i = 0; $i < count($rawPairs); $i++) {
            $pair = explode(':', $rawPairs[$i]);

            if (count($pair) == 2) {
                $data['mtp_lp_' . $i] = trim($pair[0]);
                $data['mtp_rp_' . $i] = trim($pair[1]);
                $data['match_the_pairs_' . $i] = true;
            }
        }

        return null;
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'wsht-id' => 'nullable|numeric|exists:worksheets,id',
            'wsht-name' => 'required|string',
            'wsht-theme' => 'required|string',
            'wsht-level' => 'required|string',
            'multiple-choice' => 'nullable|string',
            'fill-in-the-blanks' => 'nullable|string',
            'match-the-pairs' => 'nullable|string',
            'multiple-choice-questions' => 'nullable|integer',
            'multiple-choice-choices' => 'nullable|integer',
            'fill-in-the-blanks-questions' => 'nullable|integer',
            'match-the-pairs-questions' => 'nullable|integer',
        ]);

        return view('pages.editor', compact('data'));
    }

    public function generatePDF(Request $request)
    {
        $data = $request->all();

        if (!(isset($data['wsht-name']) && isset($data['wsht-theme']) && isset($data['wsht-level']))) {
            return response('Worksheets name, theme and level must be filled in.', 422);
        }

        //kontrola ci je zaskrtnuta aspon jedna spravna odpoved
        $j = 1;
        while (true) {
            if(!isset($data['mch_question_' . $j])){
                break;
            }

            $i = 0;
            $numOfCorrect = false;

            while (!$numOfCorrect) {
                if(isset($data['mch_choice_text_' . $j . '_' . $i])){
                    if(isset($data['mch_choice_checkbox_' . $j . '_' . $i])){
                        $numOfCorrect = true;
                    }
                    $i++;
                } else {
                    break;
                }
            }

            if (!$numOfCorrect) {
                return response('Each question must have at least one correct answer.', 422);
            }

            $j++;
        }

        $pdf = PDF::loadView('pages.worksheetPDF', compact('data'));
        return $pdf->download($data['wsht-name'] . '.pdf');
        //Storage::disk('local')->put('pdfs/' . $data['wsht-name'] . '.pdf', $pdf->output());
    }

    public function generateKeyPDF(Request $request){
        $data = $request->all();

        if (!(isset($data['wsht-name']) && isset($data['wsht-theme']) && isset($data['wsht-level']))) {
            return response('Worksheets name, theme and level must be filled in.', 422);
        }

        $pdf = PDF::loadView('pages.keyPDF', compact('data'));
        return $pdf->download($data['wsht-name'] . '-key.pdf');
        //Storage::disk('local')->put('pdfs/' . $data['wsht-name'] . '-key.pdf', $pdf->output());
    }

    public function saveWorksheet(Request $request)
    {
        $data = $request->all();

        if (!(isset($data['wsht-name']) && isset($data['wsht-theme']) && isset($data['wsht-level']))) {
            $error = 'Could not save the worksheet.';
            return view('pages.editor', compact('data'))->with('error', $error);
        }

        //1. Vytvorenie worksheetu
        $worksheet = Worksheet::where('id', $data['wsht-id'])->first();

        if ($worksheet === null) {
            $worksheet = Worksheet::create(['user_id' => $request->user()->id, 'title' => $data['wsht-name'], 'level' => $data['wsht-level'], 'theme' => $data['wsht-theme']]);
            $data['wsht-id'] = $worksheet->id;
        } else {
            Worksheet::where('id', $worksheet->id)->update(['title' => $data['wsht-name'], 'level' => $data['wsht-level'], 'theme' => $data['wsht-theme']]);
            MatchThePair::where('worksheet_id', $worksheet->id)->delete();
            MultipleChoice::where('worksheet_id', $worksheet->id)->delete();
            FillInTheBlank::where('worksheet_id', $worksheet->id)->delete();
        }

        $j = 1;
        while (isset($data['mch_question_' . $j])) {
            $mch_question = $data['mch_question_' . $j];
            $choices = [];
            $i = 0;

            while (isset($data['mch_choice_text_' . $j . '_' . $i])) {
                $choices[] = [
                    'text' => $data['mch_choice_text_' . $j . '_' . $i],
                    'is_correct' => isset($data['mch_choice_checkbox_' . $j . '_' . $i]),
                ];

                if (isset($data['mch_choice_checkbox_' . $j . '_' . $i])) {
                    $data['mch_choice_checkbox_' . $j . '_' . $i] = "checked"; // kvoli zanechaniu oznacenych spravnych moznosti
                }

                $i++;
            }

            // prvy sposob akym sa da vytvarat riadok v databaze
            MultipleChoice::create(['worksheet_id' => $worksheet->id, 'content' => [
                'question' => $mch_question,
                'choices' => $choices
            ]]);
            $j++;
        }

        if (isset($data['fintb-text']) && $data['fintb-text'] != '') {
            // druhy sposob akym sa da vytvarat riadok v databaze
            $worksheet->fillInTheBlanks()->create([
                'content' => $data['fintb-text'],
            ]);
        }

        $k = 0;
        while (isset($data['mtp_lp_' . $k]) && isset($data['mtp_rp_' . $k])) {
            $worksheet->matchThePairs()->create([
                'left' => $data['mtp_lp_' . $k],
                'right' => $data['mtp_rp_' . $k]
            ]);
            $k++;
        }

        $success = 'Worksheet saved successfully.';
        return view('pages.editor', compact('data'))->with('success', $success);
    }

    public function deleteWorksheet(Request $request)
    {
        $data = $request->all();

        $worksheet = Worksheet::where('id', $data['wsht-id'])->first();

        if ($worksheet === null) {
            return redirect()->back()->with('error', 'Could not delete the worksheet.'); // toto pouzije session('error'), lebo je to redirect()->back()
        } else {
            $worksheet->delete();
            return redirect()->back()->with('success', 'Worksheet deleted successfully.');
        }
    }

    private function getTrimmedResponse(string $rawOutput) {
        $cleanOutput = preg_replace('/<think>.*?<\/think>/s', '', $rawOutput);
        $finalOutput = trim($cleanOutput);
        $finalOutput = str_replace(["\n", "\r"], ' ', $finalOutput);
        return preg_replace('/\s+/', ' ', $finalOutput);
    }
}
