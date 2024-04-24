<?php
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
// navigate
$navigation = $page->navigate('https://www.amazon.com/s?i=stripbooks&rh=n%3A5%2Cp_30%3Aspringer%2Cp_20%3AEnglish&s=relevanceexprank&Adv-Srch-Books-Submit.x=44&Adv-Srch-Books-Submit.y=-1&p_45=1&p_46=During&p_47=2023&unfiltered=1&ref=sr_adv_b')->waitForNavigation();


$html = $page->getHtml();
file_put_contents('data/a.txt',$html);
echo $html;
   } finally {
    // bye
    $browser->close();
}