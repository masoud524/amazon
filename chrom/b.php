<?php
require_once 'vendor/autoload.php';
use HeadlessChromium\BrowserFactory;
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
    $page->navigate('http://old.tsetmc.com/Loader.aspx?ParTree=15131F')->waitForNavigation();

    // get page title
    $pageTitle = $page->evaluate('document.title')->getReturnValue();
    $pageTitl = $page->evaluate('document');
     echo 'موفقیت امیز بود';

    // screenshot - Say "Cheese"! 😄
    $page->screenshot()->saveToFile('img/barq.png');

    // pdf
    //$page->pdf(['printBackground' => true])->saveToFile('img/bar.pdf');
} finally {
    // bye
    $browser->close();
}