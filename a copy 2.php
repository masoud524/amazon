<?php
set_time_limit(0); // زمان اجرای بی‌نهایت

require_once 'chrom/vendor/autoload.php';
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Exception\OperationTimedOut;
use HeadlessChromium\Exception\NavigationExpired;
$browserFactory = new BrowserFactory();

$browser = $browserFactory->createBrowser([
    'windowSize'   => [1920, 20000],
    'startupTimeout' => 1,
]);


// starts headless Chrome
$browser = $browserFactory->createBrowser();

try {
    // creates a new page and navigate to an URL
    $page = $browser->createPage();

    $dat=[];
// navigate
$navigation = $page->navigate('https://www.amazon.com'.$_REQUEST["li"])->waitForNavigation();


$html = $page->getHtml();
$pattern = '/-base a-text-normal">([a-zA-Z0-9 ]+)/i'; // Added delimiters / and fixed the pattern
preg_match_all($pattern, $html, $matches);
//print_r($matches[1]);
$dat[]=$matches[1];

$pattern = '/s-no-outline\" href=\"([^\"]+)/i'; // Pattern to match everything except a double quote (")
preg_match_all($pattern, $html, $matche);
print_r($matche[1]);
$dat[]=$matche[1];

//file_put_contents('web/a.txt',$html);
file_put_contents('web/a11.txt',json_encode($dat));

$pattern = '/a href=\"([^\"]+)\" aria-label=\"Go to next page/i'; // Pattern to match everything except a double quote (")
preg_match_all($pattern, $html, $match);

//echo '<script>window.location.replace("https://www.amazon.com/'.$matche[1] . '");</script>';

/*while(!$match[1]==null){
    $navigation = $page->navigate('https://www.amazon.com'.$matche[1][0])->waitForNavigation();


    $html = $page->getHtml();
    $pattern = '/-base a-text-normal">([a-zA-Z0-9 ]+)/i'; // Added delimiters / and fixed the pattern
    preg_match_all($pattern, $html, $matches);
    //print_r($matches[1]);
    $dat[]=$matches[1];
    
    $pattern = '/s-no-outline\" href=\"([^\"]+)/i'; // Pattern to match everything except a double quote (")
    preg_match_all($pattern, $html, $matche);
    print_r($matche[1]);
    $dat[]=$matche[1];

    $pattern = '/a href=\"([^\"]+)\" aria-label=\"Go to next page/i'; // Pattern to match everything except a double quote (")
    preg_match_all($pattern, $html, $match);
    file_put_contents('web/a3.txt',json_encode($dat));

}*/
//file_put_contents('web/a.txt',json_encode($dat));
   } finally {
    // bye
    $browser->close();
}