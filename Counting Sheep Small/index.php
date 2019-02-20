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
$smal_max = 200;
$big_max = pow(10,6);

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
    foreach ($data as $c => $num){
        
        
        $result = array();
        
        $num = str_replace(array("\r", "\n", " "), "", $num);
                
        if($num !== ""){
            $counter++;
            if($num > $max){
               //$text .= "Case #$case: \n"; 
               continue;
            }
             
            $result =   returnArray($num);
           
        }
        else{
               continue;     
        }
        $case = $counter-1; 
        $count = count($result);
        $iter = 1;
        //$max_it = $limit;
        
        $num2 = $num;
         
        while($count < 10){
            //$max_it--;
            if($num == 0){
                $text .= "Case #$case: INSOMNIA\n"; 
                break;
            }
            $iter++;
            $num2 = $iter * $num;
            $tmp = returnArray($num2);
            $result = merge_result_array($result, $tmp);
             
            $count = count($result);
             
        }
        if($num == 0){
            continue;
        }
        $text .=  "Case #$case: $num2" . "\n"; 
        
    }
    return $text;
}

function saveResultFile($str,$file){
    
    file_put_contents($file, $str);
    
}


function returnArray($num){
    $result = array();
    $num = ltrim(trim($num));
    $count = strlen($num);
    if($count === 1){
        return array($num => true);
    }
    for($i = 0; $i < $count; $i++){
        $num[$i] =  (int)$num[$i];
        $result[$num[$i]] = true;
    }
     
    return $result;        
}


function merge_result_array($ar1, $ar2){
   
    $result = array();
    if(!empty($ar2)){
        foreach ($ar2 as $key => $val){
            $result[$key] = $val;
        }
    }
    if(!empty($ar1)){
        foreach ($ar1 as $key => $val){
            $result[$key] = $val;
        }    
    }    
    
     
    return $result;
    
    
}

?>
