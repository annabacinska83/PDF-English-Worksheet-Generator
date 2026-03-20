<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorksheetController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'wsht-name' => 'required|string',
            'wsht-theme' => 'required|string',
            'grade' => 'required|integer',
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

  //TODO: chýba tu answer key, toto je cisto generovanie PDF pre "deti"

    public function generatePDF(Request $request){
        $data = $request->all();
        $pdf = PDF::loadView('pages.worksheetPDF', compact('data'));
        //return $pdf->download('worksheet.pdf');
        Storage::disk('local')->put('pdfs/' . $data['wsht-name'] . '.pdf', $pdf->output());
    }
}
