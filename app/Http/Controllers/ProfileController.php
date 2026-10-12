<?php

namespace App\Http\Controllers;

use App\Models\FillInTheBlank;
use App\Models\MatchThePair;
use App\Models\MultipleChoice;
use App\Models\Worksheet;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showProfile()
    {
        return view('pages.profile');
    }

    public function showArchive(Request $request)
    {
        $data = $request->all();

        if (isset($data['order'])) {
            if($data['order'] === 'date') {
                $worksheets = Worksheet::orderByRaw('updated_at DESC')->get();
            } else {
                $worksheets = Worksheet::orderByRaw('LOWER(title) ' . $data['order'])->get();
            }

        } else {
            $worksheets = Worksheet::all();
        }

        $worksheets = $worksheets->where('user_id', $request->user()->id);

        return view('pages.archive', compact('worksheets'));
    }

    public function showWorksheet(Request $request)
    {
        $data = $request->validate([
            'wsht-id' => 'required|integer|exists:worksheets,id',
        ]);

        $worksheet = Worksheet::where('id', $data['wsht-id'])->firstOrFail();
        $data['wsht-id'] = $worksheet->id;
        $data['wsht-name'] = $worksheet->title;
        $data['wsht-theme'] = $worksheet->theme;
        $data['wsht-level'] = $worksheet->level;

        $multipleChoices = MultipleChoice::where('worksheet_id', $data['wsht-id'])->get();
        $fillInTheBlanks = FillInTheBlank::where('worksheet_id', $data['wsht-id'])->first();
        $matchThePairs = MatchThePair::where('worksheet_id', $data['wsht-id'])->get();

        // multiple choice
        if ($multipleChoices->count() > 0) {
            $data['multiple-choice'] = 'checked';
            $data['multiple-choice-questions'] = $multipleChoices->count();
            $data['multiple-choice-choices'] = count($multipleChoices[0]?->content['choices']);

            for ($j = 1; $j <= $data['multiple-choice-questions']; $j++) {
                $data['mch_question_' . $j] = $multipleChoices[$j - 1]?->content['question'];

                for ($i = 0; $i < $data['multiple-choice-choices']; $i++) {
                    if (isset($multipleChoices[$j - 1]?->content['choices'][$i]['text']) && isset($multipleChoices[$j - 1]?->content['choices'][$i]['is_correct'])) {
                        $data['mch_choice_text_' . $j . '_' . $i] = $multipleChoices[$j - 1]?->content['choices'][$i]['text'];
                        $data['mch_choice_checkbox_' . $j . '_' . $i] = $multipleChoices[$j - 1]?->content['choices'][$i]['is_correct'] ? 'checked' : '';
                    }
                }
            }
        }

        // fill in the blanks
        if ($fillInTheBlanks) {
            $data['fintb-text'] = $fillInTheBlanks->content;
            $data['fill-in-the-blanks-questions'] = substr_count($data['fintb-text'], '[');
            $data['fill-in-the-blanks'] = 'checked';
        }

        // match the pairs
        if ($matchThePairs->count() > 0) {
            $data['match-the-pairs'] = 'checked';
            $data['match-the-pairs-questions'] = $matchThePairs->count();

            for ($i = 0; $i < $data['match-the-pairs-questions']; $i++) {
                $data['mtp_lp_'.$i] = $matchThePairs[$i]?->left;
                $data['mtp_rp_'.$i] = $matchThePairs[$i]?->right;
            }
        }

        return view('pages.editor', compact('data'));
    }

    public function editProfile(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $request->user()->update([
            'name' => $data['name'] . ' ' . $data['surname'],
            'password' => $data['password'],
        ]);

        return redirect()->back()->with('success','Profile successfully updated.');
    }
}
