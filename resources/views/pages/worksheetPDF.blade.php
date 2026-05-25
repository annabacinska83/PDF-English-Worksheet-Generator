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
    <span>Worksheet</span>
    <span id="wsht-subject">{{ $data['wsht-theme'] }}</span>
</div>
<div class="mtp-container">
    <div class="mtp-col">
        <p><strong>Name:</strong></p>
    </div>
    <div class="mtp-col">
        <p><strong> Date:</strong></p>
    </div>
    <br>
</div>

@php
    $exerciseNum = 1;
   /* <!-- Multiple choice questions -->*/
    if (isset($data['mch_question_1'])) {
@endphp

<p><strong>{{ $exerciseNum }}. Multiple choice</strong>: Choose the correct answer.</p>
@php
    $exerciseNum++;
    $j = 1;
    while (true) {
        if (isset($data['mch_question_' . $j])) {
@endphp

<h4>{{ $j . ". " . $data['mch_question_' . $j] }}</h4>

@php
    $i = 0;
    while (true) {
        if (isset($data['mch_choice_text_' . $j . '_' . $i])) {
@endphp

<p class="mch-choice-text">
    {{ chr($i + 97) . ') ' . $data['mch_choice_text_' . $j . '_' . $i] }}
</p>

@php
    } else {
        break;
    }
    $i++;
}
} else {
break;
}
$j++;
}
}

/*<!-- Fill In The Blanks -->*/
if(isset($data['fintb-text'])){
@endphp
<br>
<p><strong>{{ $exerciseNum }}. Fill In The Blanks</strong>: Write the correct answer from the box.</p>
@php
    $exerciseNum++;
    //najdem vsetky zhody
    preg_match_all('/\[(.*?)\]/', $data['fintb-text'], $matches);

    $result = $data['fintb-text'];
    if(!empty($matches[0])){
        $avg = 0;
        foreach ($matches[0] as $match) {
            $avg += strlen($match);
        }
        $avg /= count($matches[0]);
        $replacement = str_repeat('_',$avg);
        $index = 0;

        $result = preg_replace_callback('/\[(.*?)\]/', function($match) use ($replacement, &$index) {
            $index++;
            return $replacement . ' (' . $index . ')';
        }, $data['fintb-text']);
@endphp
<table class="box">
    <tr>
        @foreach($matches[1] as $match)
            <td>{{ $match }}</td>
        @endforeach
    </tr>
</table>
<p>{{ $result }}</p>
@php
    }
}

// Match The Pair
    if (isset($data['mtp_lp_0']) && isset($data['mtp_rp_0'])) {
@endphp
<br>
<p><strong>{{ $exerciseNum }}. Match The Pairs</strong>: Connect the pairs that belong together.</p>
@php
    $exerciseNum++;

    $leftPairs = [];
    $rightPairs = [];

    $y = 0;
    while (isset($data['mtp_lp_' . $y])) {
        $leftPairs[] = $data['mtp_lp_' . $y];
        $y++;
    }

    $z = 0;
    while (isset($data['mtp_rp_' . $z])) {
        $rightPairs[] = $data['mtp_rp_' . $z];
        $z++;
    }

    shuffle($rightPairs);
@endphp

<table class="mtp-table">
    <tr>
        <td class="mtp-cell">
            @foreach($leftPairs as $index => $lp)
                <p>{{ ($index + 1) . ') ' . $lp }}</p>
            @endforeach
        </td>
        <td class="mtp-cell">
            @foreach($rightPairs as $index => $rp)
                <p>{{ chr($index + 97) . ') ' . $rp }}</p>
            @endforeach
        </td>
    </tr>
</table>
@php
    }
@endphp
</body>
</html>
