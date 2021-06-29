<?php

$json = file_get_contents('test_task.json');

$parsed_json = json_decode($json,true);

$month = date('M',strtotime($parsed_json[0]['from']));

$result = $month . ' ';

for($i = 0; $i <= count($parsed_json)-1; $i++) {
        $function_result = is_intersect($parsed_json[$i]['from'],$parsed_json[$i]['to'], $parsed_json[$i+1]['from'],$parsed_json[$i+1]['to']);
        if(!$function_result) {
            $result .=   date('j',strtotime($parsed_json[$i]['from'])) . '-' . date('j',strtotime($parsed_json[$i]['to'])) . ' ';
        } else {
            $result .= $function_result;
            $i++;
        }
}

echo $result;


function is_intersect($time_from1, $time_to1, $time_from2, $time_to2) {
    $datetime_start_1 = new DateTime($time_from1);
    $datetime_end_1   = new DateTime($time_to1);
    $datetime_start_2 = new DateTime($time_from2);
    $datetime_end_2   = new DateTime($time_to2);

    $start = max($datetime_start_2,$datetime_start_1);
    $end   = min($datetime_end_1,$datetime_end_2);

    $min_from = min($datetime_start_1,$datetime_start_2)->format(DateTime::RFC3339);
    $max_to   = max($datetime_end_1,$datetime_end_2)->format(DateTime::RFC3339);

    if ($end >= $start) {
        return ' '. date('j',strtotime($min_from)) . '-' . date('j',strtotime($max_to));
    } else {
        if (in_a_row($time_from1, $time_to1, $time_from2, $time_to2)) {
            return ' '. date('j',strtotime($min_from)) . '-' . date('j',strtotime($max_to));
        }
        return false;
    }
}

function in_a_row($time_from1, $time_to1, $time_from2, $time_to2) {
    if(date('j', strtotime($time_from2)) - date('j', strtotime($time_to1)) == 1) {
        return true;
    }
    return false;
}
