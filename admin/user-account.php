<style>
    /* Center card in the section */
    section {
        display: flex;
        justify-content: center;
        align-items: flex-start;
        min-height: 100vh;
        padding: 20px;
    }
    /* Card styling */
    .card {
        width: 100%;
        max-width: 900px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        background-color: #fff;
    }
    /* Table styling */
    .card table {
        width: 100%;
        border-collapse: collapse;
        overflow-x: auto;
        display: block;
    }
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    .lightgreen {
        background-color: lightgreen;
    }
    .edit-button {
        padding: 5px 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        text-decoration: none;
    }
    /* Responsive styling */
    @media (max-width: 600px) {
        .card table {
            width: 100%;
            overflow-x: auto;
        }
        th, td {
            font-size: 14px;
            padding: 8px;
        }
    }
</style>

<section>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Address</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Account Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include('../connect.php');

                // Check connection
                if ($con->connect_error) {
                    die("Connection failed: " . $con->connect_error);
                }

                // Query to retrieve only Customer accounts (account_type = 2)
                $sql = "SELECT id, fullname, address, contact, email, account_type FROM accounts WHERE account_type = 2";
                $result = $con->query($sql);

                // Check if there are results
                if ($result->num_rows > 0) {
                    // Loop through each row and output data
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["fullname"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["address"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["contact"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["email"]) . "</td>";
                        echo "<td class='lightgreen' style='color: black; font-weight: bold;'>Customer</td>";
                        echo "<td><a href='index.php?pg=edit-user&id=" . $row['id'] . "' class='edit-button'>Edit</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }

                // Close the database connection
                $con->close();
                ?>
            </tbody>
        </table>
    </div>
</section>
