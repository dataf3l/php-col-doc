<?php
define('MODE_NO_COMMENT',0);
define('MODE_COMMENT',1);
function file2functionlist($sourcecode){
    $lines = explode("\n",$sourcecode);
    $line_number = 1;
    $output = array();
    $comment_buffer = "";
    $mode = MODE_NO_COMMENT;
    foreach($lines as $line){
        #print("$line_number".$line);
        if(MODE_COMMENT==$mode){
            $comment_buffer .= preg_replace("/\s*\*\s*/","",$line);
        }
        if(preg_match_all('/\/\*\*(.*)/',$line,$matches)){
            $comment_buffer .= preg_replace("/\s*\*\s*/","",$line);
            $mode = MODE_COMMENT;
        }
        if(preg_match_all('/\*\//',$line,$matches)){
            $comment_buffer .= preg_replace("/\*\//","",$line);
            $mode = MODE_NO_COMMENT;
        }    
        if(preg_match_all('/function\s*(\w+)/',$line,$matches)){
            #var_dump($matches);
            $output[] = array(
                'name'=>$matches[1][0],
                'start_line'=>$line_number,
                'end_line'=>-1,
                'comment'=>$comment_buffer,
            );
            $comment_buffer = "";
        }
        $line_number++;
    }
    return $output;
}
