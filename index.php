<?php
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$supabase_url = "https://uhqqzlpaybcyxrepisgi.supabase.co";
$api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzA4NDAyNzgsImV4cCI6MjA4NjQxNjI3OH0.LNQMIQs7euI7-4MMJWU_maqT6WdXq6lWuueCtF3kE24";

$headers = [
    "apikey: $api_key",
    "Authorization: Bearer $api_key"
];

$query = "?email=eq.$email&password=eq.$password";

$ch = curl_init($supabase_url . $query);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (!empty($data)) {
    $_SESSION['email'] = $email;
    header("Location: dashboard.php");
} else {
    header("Location: index.php");
}
exit();
?>