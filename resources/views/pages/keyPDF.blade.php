<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ $data['wsht-name'] }}</title>
    <style>
        {!! file_get_contents(resource_path('css/app.css')) !!}
    </style>
</head>
<body>
<div class="pdf-header">
    <img id="website-logo" src="{{ resource_path('images/dark_logo.png') }}" alt="logo">
    <span id="website-name">CoolSheet</span>
    <span>Answer sheet</span>
    <span id="wsht-subject">{{ $data['wsht-theme'] }}</span>
</div>

@if(isset($data['mch_question_1']))
    <p><strong>Multiple choice</strong>:</p>
@endif
@php
    $j = 1;
    while(true) {
        if(isset($data['mch_question_' . $j])) {
            $i = 0;
            $foundCorrect = false;
            while(!$foundCorrect){
                if(isset($data['mch_choice_text_' . $j . '_' . $i]) && isset($data['mch_choice_checkbox_' . $j . '_' . $i])) {
                    @endphp
                    <p>{{ $j . '. '. chr($i + 97) }}</p>
                    @php
                    $foundCorrect = true;
                } else {
                    $i++;
                }
            }
        } else {
        break;
        }
        $j++;
    }

/*<!-- Fill In The Blanks -->*/
if(isset($data['fintb-text'])){
                    @endphp
<br>
<p><strong>Fill In The Blanks</strong>:</p>
@php
    preg_match_all('/\[(.*?)\]/', $data['fintb-text'], $matches);
@endphp

@foreach($matches[1] as $index => $word)
    <p>{{ $index + 1 }}. {{ $word }}</p>
@endforeach

@php

    }

/*Match the Pairs*/
if (isset($data['mtp_lp_0']) && isset($data['mtp_rp_0'])) {
    $pairs = [];
    $i = 0;

    while (isset($data['mtp_lp_' . $i]) && isset($data['mtp_rp_' . $i])) {
        $pairs[] = [
            'left' => $data['mtp_lp_' . $i],
            'right' => $data['mtp_rp_' . $i],
            'original_index' => $i
        ];
        $i++;
    }

    $shuffledRight = $pairs;
    shuffle($shuffledRight);

    $rightLetterMap = [];
    foreach ($shuffledRight as $index => $pair) {
        $rightLetterMap[$pair['original_index']] = chr(97 + $index); // a, b, c...
    }
@endphp

<br>
<p><strong>Match The Pairs</strong>:</p>

@foreach($pairs as $index => $pair)
    <p>{{ $index + 1 }} . {{ $rightLetterMap[$pair['original_index']] }}</p>
@endforeach

@php
    }
@endphp
</body>
</html>
