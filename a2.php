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
//https://www.amazon.com/s?i=stripbooks&rh=n%3A5%2Cp_30%3Aspringer%2Cp_20%3AEnglish&s=relevanceexprank&Adv-Srch-Books-Submit.x=44&Adv-Srch-Books-Submit.y=-1&p_45=1&p_46=During&p_47=2023&unfiltered=1&ref=sr_adv_b
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
file_put_contents('web/am1.txt'.rand(1,100),json_encode($dat));

$pattern = '/a href=\"([^\"]+)\" aria-label=\"Go to next page/i'; // Pattern to match everything except a double quote (")
preg_match_all($pattern, $html, $match);
/*while($match[1][0]==null){
echo '<script>window.location.replace("http://127.0.0.1/3/mazon/a2.php?li='.$matche[1][0] . '");</script>';
}
while(isset($match[1][0])){
    $navigation = $page->navigate('https://www.amazon.com'.$matche[1][0])->waitForNavigation();

    $daa=[];

    $html = $page->getHtml();
    $pattern = '/-base a-text-normal">([a-zA-Z0-9 ]+)/i'; // Added delimiters / and fixed the pattern
    preg_match_all($pattern, $html, $matches);
    //print_r($matches[1]);
    $daa[]=$matches[1];
    
    $pattern = '/s-no-outline\" href=\"([^\"]+)/i'; // Pattern to match everything except a double quote (")
    preg_match_all($pattern, $html, $matche);
    print_r($matche[1]);
    $daa[]=$matche[1];

    $pattern = '/a href=\"([^\"]+)\" aria-label=\"Go to next page/i'; // Pattern to match everything except a double quote (")
    preg_match_all($pattern, $html, $match);
    file_put_contents('web/a3.txt'.rand(1,100),json_encode($daa));

}*/
//file_put_contents('web/a22.txt',json_encode($dat));
   } finally {
    // bye
    $browser->close();
}