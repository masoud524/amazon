<?php 
$data = file_get_contents('data/a'.$_GET["n"]);
$pattern = '/-base a-text-normal">([a-zA-Z0-9 ]+)/i'; // Added delimiters / and fixed the pattern
preg_match_all($pattern, $data, $matches);
print_r($matches[1]);
echo '</br>';

$pattern = '/s-no-outline\" href=\"([^\"]+)/i'; // Pattern to match everything except a double quote (")
preg_match_all($pattern, $data, $matche);
print_r($matche[1]);

$pattern = '/class=\"s-pagination-item s-pagination-disabled\" aria-disabled=\"true\"\>([0-9]+)/i'; // Pattern to match everything except a double quote (")
preg_match_all($pattern, $data, $match);
print_r($match[1]);
 
$pattern = '/a href=\"([^\"]+)\" aria-label=\"Go to next page/i'; // Pattern to match everything except a double quote (")
preg_match_all($pattern, $data, $matche);
print_r($matche[1]);