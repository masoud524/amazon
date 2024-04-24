<?php
set_time_limit(0); // Allows infinite execution time

require_once 'chrom/vendor/autoload.php';
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Exception\OperationTimedOut;
use HeadlessChromium\Exception\NavigationExpired;

$browserFactory = new BrowserFactory();
$browser = $browserFactory->createBrowser([
    'windowSize' => [1920, 20000], // Adjust window size as needed
    'startupTimeout' => 1, // Adjust startup timeout as needed
]);

try {
    $page = $browser->createPage();

    // Navigate to the initial search results page
    $navigation = $page->navigate('https://www.amazon.com/s?k=web&i=stripbooks-intl-ship&ref=nb_sb_noss')->waitForNavigation();

    $data = []; // Initialize an array to store extracted data

    while (true) {
        // Extract product names
        $html = $page->getHtml();
        $pattern = '/-base a-text-normal">([a-zA-Z0-9 ]+)/i';
        preg_match_all($pattern, $html, $matches);
        $data['product_names'][] = $matches[1];

        // Extract product URLs
        $pattern = '/s-no-outline\" href=\"([^\"]+)/i';
        preg_match_all($pattern, $html, $urls);
        $data['product_urls'][] = $urls[1];

        // Check if there is a "Next Page" link
        $pattern = '/a href=\"([^\"]+)\" aria-label=\"Go to next page/i';
        preg_match_all($pattern, $html, $nextPage);
        
        if (empty($nextPage[1][0])) {
            // If there is no next page, break the loop
            break;
        }

        // Navigate to the next page
        $navigation = $page->navigate('https://www.amazon.com' . $nextPage[1][0])->waitForNavigation();
    }

    // Save the extracted data to a JSON file
    file_put_contents('web/amazon_data.json', json_encode($data));

} catch (OperationTimedOut $e) {
    // Handle timeout exception
    echo 'Operation Timed Out: ' . $e->getMessage();
} catch (NavigationExpired $e) {
    // Handle navigation expired exception
    echo 'Navigation Expired: ' . $e->getMessage();
} finally {
    // Close the browser
    $browser->close();
}
