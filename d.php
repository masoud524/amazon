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

    $data = []; // Initialize an array to store extracted data
    $navigation = $page->navigate('https://www.amazon.com')->waitForNavigation();

    // Load JSON data from file
    $jsonContent = file_get_contents('web/amazon_data2.json');
    $decodedData = json_decode($jsonContent, true); // Decode JSON as associative array
    if ($decodedData && isset($decodedData["product_urls"])) {
       foreach ($decodedData["product_urls"] as $urls) {
                
                // Navigate to each URL
                $navigation = $page->navigate('https://www.amazon.com' . $decodedData["product_urls"][1])->waitForNavigation();

                // Extract product names
                $html = $page->getHtml();
                
                $pattern = '/\&lrm\;\s*\<\/span>\s*\<span\>(.*)\<\/span\>/i';

                preg_match_all($pattern, $html, $matches);
                $data[]=$matches[0];
        }

        // Save the extracted data to a JSON file
        file_put_contents('data/amazon_data.json', $data);
        
    } else {
        echo 'Error: Invalid JSON data format or missing product URLs.';
    }

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
