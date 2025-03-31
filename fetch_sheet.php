<?php
require_once 'vendor/autoload.php';

// Create a new Google client
$client = new Google_Client();
$client->setApplicationName('My Google Sheets API PHP App');
$client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);

// Path to the credentials JSON file downloaded from Google Cloud Console
$client->setAuthConfig('path/to/credentials.json'); // Replace with the actual path

// Create an instance of the Google Sheets API service
$service = new Google_Service_Sheets($client);

// The ID of the spreadsheet to retrieve data from
$spreadsheetId = '18HIPN_7I3-U0akiPYu0obcOjE707B5wBJdz-zvaP1vE'; // Replace with your actual sheet ID

// The range of cells to read (e.g., Sheet1!A2:A)
$range = 'Sheet1!A2:O';

// Fetch the data from the spreadsheet
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

if (empty($values)) {
    echo "No data found.\n";
} else {
    // Display the data in an HTML table
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    foreach ($values as $row) {
        echo "<tr>";
        foreach ($row as $cell) {
            echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
?>
