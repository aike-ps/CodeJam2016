<?php

// input file console arg 2
// example: php my_file.php small_input.txt

$small = "small_input.txt";
$big = "big_input.txt";
$input = false;
$file = "result.txt";
$mode = false;
$data = false;
$limit = 100;
$min = 0;
$smal_max = 10;
$big_max = 100;

if(isset($argv[1])){
    $input = $argv[1];
    
    $file = str_replace("input", "output", $input);
    
    if($input == $small){
        
        $mode = "small";
        $max = $smal_max;
        
    }
    else{
        
        $mode = "big";
        $max = $big_max;
        
    }
    
    if(file_exists($input)){
        $data = file($input);
    }
     
    $str = getCount($data, $mode, $limit, $max);
    saveResultFile($str, $file);
    
}

function getCount($data, $mode, $limit, $max){
    
    $text = "";
    $counter = 1;
    $limit = $data[0];
    unset($data[0]);
    foreach ($data as $c => $array){
        $result = array();
        $counter++;
        $case = $counter-1; 
        $count = count($result);
        $iter = 0;
        $check = true;
        $data = returnArray($array);
        
        while($check){
            $notHap = returnNotHappysId($data);
            //var_dump("l1 ",$notHap, $data);
            
            
            if($notHap === false){
                break;
            }
            $iter++;
            $data = maneuver($data, $notHap);
            //var_dump("l2 ",$data,$notHap);
        }
        $text .=  "Case #$case: $iter" . "\n"; 
        
    }
    return $text;
}

function maneuver($array, $stop){
    $result = $array;
    if($stop === 0){
        if($result[0] === "+"){
            $result[0] = "-";
            
        }
        else{
            $result[0] = "+";
        }
        return $result;
    }
    
    for($i = 0; $i <= $stop; $i++){
        if($array[$i] === "+"){
           $result[$i] = "-"; 
        }
        else {
            $result[$i] = "+"; 
        }
    }
    return $result;
}

function whoNext($array, $current){
    $current++;
    if(isset($array[$current])){
        return $array[$current];
    }
    else{
        return false;
    }
}

function returnNotHappysId($array){
    $result = false;
    
    if(count($array) === 1){
        if($array[0] === "-"){
            return 0;
        }
    }
    foreach ($array as $id => $val){
        if($val === "-"){
            if(whoNext($array, $id) === "-"){
                continue;
            }
            return $id;
        }
    }
    return $result;
}

function saveResultFile($str,$file){
    
    file_put_contents($file, $str);
    
}


function returnArray($num){
    $result = array();
    $num = ltrim(trim($num));
    $count = strlen($num);
     
    if($count === 1){
        return $result[0] = $num;
    }
    for($i = 0; $i < $count; $i++){
        $result[$i] = $num[$i];
    }
     
    return $result;        
}

 

?>