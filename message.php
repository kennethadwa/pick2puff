<?php

include('connect.php');

// Getting user's message
$getMesg = mysqli_real_escape_string($con, $_POST['text']);

// Checking user query
$check_data = "SELECT replies FROM chatbot WHERE queries LIKE '%$getMesg%'";
$run_query = mysqli_query($con, $check_data) or die('Error');

if(mysqli_num_rows($run_query) > 0){
    // Fetching the reply
    $fetch_data = mysqli_fetch_assoc($run_query);
    // Outputting the reply
    echo $fetch_data['replies'];
} else {
    echo "Sorry, I can't understand you..";
}

?>
