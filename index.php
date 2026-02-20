<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $supabase_url = "https://uhqqzlpaybcyxrepisgi.supabase.co/rest/v1/login";
    $api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MDg0MDI3OCwiZXhwIjoyMDg2NDE2Mjc4fQ.zgY2AsO71vrf5V1lWW0J35nUtut1qUvfvGTRAHFRz7Y

";

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
        exit();
    } else {
        header("Location: index.php");
        exit();
    }
}
?>

