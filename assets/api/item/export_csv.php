<?php
$data = array(
    array('Name', 'Email', 'Phone'),
    array('John Doe', 'john@example.com', '123-456-7890'),
    array('Jane Doe', 'jane@example.com', '987-654-3210'),
    // Add more rows as needed
);

$filename = 'export.csv';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');

$handle = fopen('php://output', 'w');

foreach ($data as $row) {
    fputcsv($handle, $row);
}

fclose($handle);
?>
