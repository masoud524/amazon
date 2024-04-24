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
$navigation = $page->navigate('https://www.aparat.com/v/BoSUi')->waitForNavigation();
$page->addPreScript($script, ['onLoad' => true]);

// wait for the page to be loaded
//$navigation->waitForNavigation();

$html = $page->getHtml();
echo $html;
   } finally {
    // bye
    $browser->close();
}