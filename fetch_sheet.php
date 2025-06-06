<?php
// Your published Google Sheet CSV URL
$csvUrl = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTFubFRZzW6KtOochSHlAu4SW8McRa3L-1A1fFBNQkD_GASXWKGgbRiBKIWIgUrq8FSmxB-XVD9GhY7/pub?output=csv";

// Fetch the CSV content from the URL
$csvContent = file_get_contents($csvUrl);
if ($csvContent === false) {
    die("Error fetching data from the Google Sheet.");
}

// Split the CSV content into lines
$lines = explode("\n", $csvContent);
$data = [];

// Parse each line of CSV into an array
foreach ($lines as $line) {
    // Skip any empty lines
    if (trim($line) == "") continue;
    $data[] = str_getcsv($line);
}

// Display the data in an HTML table
echo "<table border='1' cellpadding='5' cellspacing='0'>";
foreach ($data as $row) {
    echo "<tr>";
    foreach ($row as $cell) {
        echo "<td>" . htmlspecialchars($cell) . "</td>";
    }
    echo "</tr>";
}
echo "</table>";
?>
