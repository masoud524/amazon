<?php
require_once 'vendor/autoload.php';
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
$navigation = $page->navigate('')->waitForNavigation();

// wait for the page to be loaded
//$navigation->waitForNavigation();

$html = $page->getHtml();
$page->setDownloadPath('/files');
file_put_contents('a',$html);
echo $html;
   } finally {
    // bye
    $browser->close();
}