<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the book name and new rating from the form
    $bookName = $_POST['book_name']; // Replace with the actual book name
    $newRating = $_POST['rating'];

    // Establish a database connection
    include 'connection.php';

    // Retrieve the existing total rating and review count
    $sql = "SELECT totalrating, rno FROM bookinfo WHERE bname = '$bookName'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $totalRating = $row['totalrating'];
        $rno = $row['rno'];

        // Calculate the new total rating and increment the review count
        $totalRating = ($totalRating + $newRating);
        $rno += 1;

        // Update the database with the new values
        $updateSql = "UPDATE bookinfo SET totalrating = $totalRating, rno = $rno WHERE bname = '$bookName'";
        if (mysqli_query($conn, $updateSql)) {
            header('location: books.php');
        } else {
            echo "Error updating rating: " . mysqli_error($conn);
        }
    } else {
        echo "Book not found in the database.";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
