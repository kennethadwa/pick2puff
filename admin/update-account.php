<?php
include('../connect.php');

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    // Update the account data
    $sql = "UPDATE accounts SET fullname = ?, address = ?, contact = ?, email = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssi", $fullname, $address, $contact, $email, $id);

    if ($stmt->execute()) {
        // Display success alert and redirect with JavaScript
        echo "<script>
                alert('Account updated successfully!');
                window.location.href = 'index.php?pg=user';
              </script>";
    } else {
        // Display error message
        echo "<script>
                alert('Error updating account: " . $stmt->error . "');
              </script>";
    }
    
    // Close statement and connection
    $stmt->close();
    $con->close();
}
?>
