<?php
set_time_limit(0); // Allows infinite execution time

require_once 'chrom/vendor/autoload.php';
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Exception\OperationTimedOut;
use HeadlessChromium\Exception\NavigationExpired;
use \HeadlessChromium\Exception\BrowserConnectionFailed;

$browserFactory = new BrowserFactory();
$browser = $browserFactory->createBrowser([
    'windowSize' => [1920, 20000], // Adjust window size as needed
    'startupTimeout' => 1, // Adjust startup timeout as needed
    //'headless' => false, // disable headless mode
    'connectionDelay' => 0.8,            // add 0.8 second of delay between each instruction sent to Chrome,
    'debugLogger'     => 'php://stdout', // will enable verbose mode
    'enableImages' => false,
]);


try {
    $page = $browser->createPage();

    $data = []; // Initialize an array to store extracted data
    $page->setUserAgent('my user-agen');

    // Load JSON data from file
    $jsonContent = file_get_contents('web/amazon_data2.json');
    $decodedData = json_decode($jsonContent, true); // Decode JSON as associative array

    if ($decodedData && isset($decodedData["product_urls"])) {
        // Loop through a limited number of URLs (e.g., first 10)
        for ($i = 53; $i < 100 && $i < count($decodedData["product_urls"]); $i++) {
            $url = $decodedData["product_urls"][$i];
            // Navigate to each URL
            $navigation = $page->navigate('https://www.amazon.com' . $url)->waitForNavigation();
            //file_get_contents('https://www.amazon.com/errors/validateCaptcha?amzn=ipem2oIf%2BeXCPP1FTBFYdA%3D%3D&amzn-r=%2FHundred-Page-Machine-Learning-Book%2Fdp%2F1777005477%2Fref%3Dsr_1_1%3Famp%26crid%3D3FIK051RH3YB4%26dib%3DeyJ2IjoiMSJ9.P2wogo_PeudlIWW1rCheSrZP_bdTVty6Gell5iDmFTVDlA1-3iNGs1Hxx6nmEYpBmHCnPUAF6AmHd0mvHdmzWrtlOJXqBqSwCWg3mFWgkGUTzi94P33QGN0iiYMchFDIpNaD2HliP9uZfj9Coe_tV-wuVL8WcsDFZ4eW-eYVH5sioKnHoZJ-xIBR-Xp4rp64cJi3oEZKzMTXERmVUiikVhIV9khLHMsS_VExMAw6FqI.kKnVmc1br1IcNgCI2fRt7Zort4G-VEIO3c-apK9AcqE%26dib_tag%3Dse%26keywords%3Dmachine%2Blearning%26qid%3D1713804074%26s%3Dbooks%26sprefix%3Dma%252Cstripbooks-intl-ship%252C2282%26sr%3D1-1&field-keywords=YBMGEX');

            // Extract product names
            $html = $page->getHtml();
            $pattern = '/\s*\<\/span>\s*\<span\>(.*)\<\/span\>/i';
            preg_match_all($pattern, $html, $matches);
            file_put_contents('data/amazon_data'.$i.'.html', $html);

            // Store the extracted data
            if (!empty($matches[1])) {
                $data[] = [
                    'url' => $url,
                    'product_names' => $matches[0],
                ];
            }
        }

        // Save the extracted data to a JSON file
        file_put_contents('data/amazon_data3.json', json_encode($data));
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
