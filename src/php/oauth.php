<?php
session_start();

if (isset($_GET['code'])) {
    // Process the authorization code (exchange for access token) and authenticate user
    $authorization_code = $_GET['code'];
    // Send authorization code to OAuth provider for validation and exchange for access token
    // Once authenticated, set user session and redirect to home page
    $_SESSION['user_name'] = $uname; // Replace with authenticated user ID
    header("Location: home.php");
    exit();
} else {
    // Redirect to index.php with error if authorization code is missing
    header("Location: index.php?error=" . urlencode("OAuth authorization code is missing"));
    exit();
}
?>