<?php
$input = file_get_contents("code.txt");
require("function.file2functionlist.php");
#echo($input);
print_r(file2functionlist($input));
