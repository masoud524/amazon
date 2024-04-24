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
    'headless' => false, // disable headless mode
    'connectionDelay' => 0.8,            // add 0.8 second of delay between each instruction sent to Chrome,
    'debugLogger'     => 'php://stdout', // will enable verbose mode
    'enableImages' => false,
]);

try {
    $page = $browser->createPage();

    $data = []; // Initialize an array to store extracted data

    // Load JSON data from file
    $jsonContent = file_get_contents('web/amazon_data2.json');
    $decodedData = json_decode($jsonContent, true); // Decode JSON as associative array

    if ($decodedData && isset($decodedData["product_urls"])) {
        // Loop through a limited number of URLs (e.g., first 10)
        for ($i = 0; $i < 1 && $i < count($decodedData["product_urls"]); $i++) {
            $url = $decodedData["product_urls"][$i];
            // Navigate to each URL
        //$navigation = $page->navigate('https://www.amazon.com/errors/validateCaptcha?amzn=5J623zRfrg7fKGOa7lrzFA%3D%3D&amzn-r=%2FMachine-Learning-AI-Essential-Questions%2Fdp%2F1718503768%2Fref%3Dsr_1_2%3Famp%253Bdib%3DeyJ2IjoiMSJ9.P2wogo_PeudlIWW1rCheSrZP_bdTVty6Gell5iDmFTVDlA1-3iNGs1Hxx6nmEYpBmHCnPUAF6AmHd0mvHdmzWrtlOJXqBqSwCWg3mFWgkGUTzi94P33QGN0iiYMchFDIpNaD2HliP9uZfj9Coe_tV-wuVL8WcsDFZ4eW-eYVH5sioKnHoZJ-xIBR-Xp4rp64cJi3oEZKzMTXERmVUiikVhIV9khLHMsS_VExMAw6FqI.kKnVmc1br1IcNgCI2fRt7Zort4G-VEIO3c-apK9AcqE%26amp%253Bdib_tag%3Dse%26amp%253Bkeywords%3Dmachine%2Blearning%26amp%253Bqid%3D1713804074%26amp%253Bs%3Dbooks%26amp%253Bsprefix%3Dma%252Cstripbooks-intl-ship%252C2282%26amp%253Bsr%3D1-2%26crid%3D3FIK051RH3YB4&field-keywords=HXBGGA')->waitForNavigation();
            $navigation = $page->navigate('https://www.amazon.com/Deep-Learning-Foundations-Christopher-Bishop/dp/3031454677/ref=sr_1_1?Adv-Srch-Books-Submit.x=44&Adv-Srch-Books-Submit.y=-1&dib=eyJ2IjoiMSJ9.107ziSqe3T_40oSBvOEb_pzYPm-gt3Rw6g6gjwDwTLi9N6bFf7-CNN9bzb2CS5ea1su8gwGFgG8--eoajcE_1IUK3ZEEH5KChfoKXEFl6qpqE2faV--3NsPn4FrrZQQysyqra2bnjYRF8f4u3h8zaClRxILgwtEMteGNERuyJSyx9a69Ruv3QPanWtzmfQAgNQGvgsBPpp979W2Qa25VFSP0GEAFI5w8oO-JWaF3eZw.IwXvieuwpeqlUPBf1YadxrZ39UHJFJrmxTH5ocLyJ9Q&dib_tag=se&p_45=18&p_46=During&p_47=2023&qid=1713879816&refinements=p_30%3Aspringer%2Cp_20%3AEnglish&s=books&sr=1-1&unfiltered=1')->waitForNavigation();

            // Extract product names
            $html = $page->getHtml();
            $pattern = '/\&lrm\;\s*\<\/span>\s*\<span\>(.*)\<\/span\>/i';
            preg_match_all($pattern, $html, $matches);
            file_put_contents('data/amazon_data3.html', $html);

            // Store the extracted data
            if (!empty($matches[1])) {
                $data[] = [
                    'url' => $url,
                    'product_names' => $matches[1],
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
