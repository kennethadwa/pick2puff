<?php
include('../connect.php');

// Check if an ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the account data based on ID
    $sql = "SELECT fullname, address, contact, email FROM accounts WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if record exists
    if ($result->num_rows > 0) {
        $account = $result->fetch_assoc();
    } else {
        echo "No record found for the given ID.";
        exit;
    }
} else {
    echo "No ID specified.";
    exit;
}
?>

<style>
    /* Center form in the section */
    section {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }
    /* Form styling */
    .form-card {
        width: 100%;
        max-width: 600px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background-color: #fff;
    }
    .form-card input[type="text"],
    .form-card input[type="email"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .edit-button {
        display: block;
        margin: 20px auto 0;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
</style>

<section>
    <form class="form-card" action="update-account.php" method="POST">
        <h2>Edit Account</h2>

        <!-- Hidden input to pass the account ID -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">

        <label for="fullname">Full Name</label>
        <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($account['fullname']); ?>" required>

        <label for="address">Address</label>
        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($account['address']); ?>" required>

        <label for="contact">Contact</label>
        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($account['contact']); ?>" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($account['email']); ?>" required>

        <!-- Edit button centered at the bottom -->
        <button type="submit" class="edit-button">Edit</button>
    </form>
</section>
