<script>
    document.body
</script>
<?php
require_once 'vendor/autoload.php';
use HeadlessChromium\BrowserFactory;

$browserFactory = new BrowserFactory();

// starts headless Chrome
$browser = $browserFactory->createBrowser();

try {
    // creates a new page and navigate to an URL
    $page = $browser->createPage();
    $page->navigate('http://bot.gaex.ir/viw.php')->waitForNavigation();

    // get page title
    $pageTitle = $page->evaluate('document.title')->getReturnValue();
    $pageTitl = $page->evaluate('document');
     echo 'موفقیت امیز بود';

    // screenshot - Say "Cheese"! 😄
    $page->screenshot()->saveToFile('img/bar.png');

    // pdf
    //$page->pdf(['printBackground' => false])->saveToFile('bar.pdf');
} finally {
    // bye
    $browser->close();
}