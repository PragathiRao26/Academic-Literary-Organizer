<?php
if (isset($_GET['filename'])) {
    $filename = $_GET['filename'];
    $filepath = 'file/' . $filename . '.pdf'; // Path to your PDF files
    if (file_exists($filepath)) {
        // Set headers for PDF download
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '.pdf"');
        readfile($filepath);
        exit;
    } else {
        echo 'File not found.';
    }
} else {
    echo 'Invalid request.';
}
?>
