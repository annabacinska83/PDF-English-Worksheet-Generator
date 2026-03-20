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
    <span id="website-name">Coolname</span>
    <span>Worksheet</span>
    <span id="wsht-subject">{{ $data['wsht-theme'] }}</span>
</div>

<!--Multiple choice questions-->
@if(isset($data['mch_question_1']))
    <p><strong>Multiple choice</strong>: Choose the correct answer.</p>
@endif
@php
    $j = 1;
    while(true) {
        if(isset($data['mch_question_' . $j])) {
@endphp
<h4>{{ $j . ". " . $data['mch_question_' . $j] }}</h4>
@php
    $i = 0;
    while(true){
        if(isset($data['mch_choice_text_' . $j . '_' . $i])){
@endphp
<p class="mch-choice-text">{{ chr($i + 97) . ') ' . $data['mch_choice_text_' . $j . '_' . $i]  }}</p>
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

/*<!-- Fill In The Blanks -->*/
if(isset($data['fintb_text'])){
@endphp
<br>
<p><strong>Fill In The Blanks</strong>: Write the correct answer from the box.</p>
@php
    //najdem vsetky zhody
    preg_match_all('/\[(.*?)\]/', $data['fintb_text'], $matches);
    //I am very [happy] today
    $result = $data['fintb_text'];
    if(!empty($matches[0])){
        $avg = 0;
        foreach ($matches[0] as $match) {
            //echo($match);
            $avg += strlen($match);
        }
        $avg /= count($matches[0]);
        $replacement = str_repeat('_',$avg);
        $index = 0;


        $result = preg_replace_callback('/\[(.*?)\]/', function($match) use ($replacement, &$index){
            $index++;

            return $replacement . '(' . $index . ')';
        },$data['fintb_text']);
@endphp
<p>{{ $result }}</p>
@php
    }

}
// Match The Pair
if (isset($data['mtp_lp_1']) && isset($data['mtp_rp_1'])) {
@endphp
<br>
<p><strong>Match The Pairs</strong>: Connect the pairs that belong together.</p>

<div class="mtp-container">
    <div class="mtp-col">
        @php
            $y = 1;
            while (isset($data['mtp_lp_' . $y])) {
        @endphp
        <p>{{ $data['mtp_lp_' . $y] }}</p>
        @php
            $y++;
        }
        @endphp
    </div>

    <div class="mtp-col">
        @php
            $z = 1;
            $rightPairs = [];
            while (isset($data['mtp_rp_' . $z])) {
                $rightPairs[] = $data['mtp_rp_' . $z];
                $z++;
            }
            shuffle($rightPairs);
        @endphp
        @foreach($rightPairs as $rp)
            <p>{{ $rp }}</p>
        @endforeach
    </div>
</div>
@php
    }
@endphp
</body>
</html>
