<?php
session_start();

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {

$supabase_url = "https://uhqqlzpaybcyxrepisgi.supabase.co/rest/v1/login";
$api_key = "sb_publishable_8zJ55HCmtuFhw1ClkAed2g_NdQ1GNqZ";

        $query = "?email=eq." . urlencode($email) . "&password=eq." . urlencode($password);

        $ch = curl_init($supabase_url . $query);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "apikey: $api_key",
            "Authorization: Bearer $api_key",
            "Content-Type: application/json"
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        if (!empty($data)) {
            $success = "Connexion réussie ✅";
        } else {
            $error = "Email ou mot de passe incorrect ❌";
        }
    } else {
        $error = "Veuillez remplir tous les champs ❌";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>UniMate Login</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 min-h-screen flex items-center justify-center">

<div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">

<h2 class="text-2xl font-bold mb-6 text-center">Student Portal</h2>

<?php if (!empty($success)): ?>
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">
        <?php echo $success; ?>
    </div>
<?php endif; ?>

<?php if (!empty($error)): ?>
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST" action="" class="space-y-4">

    <div>
        <label class="block mb-1 text-sm font-medium">University Email</label>
        <input type="email" name="email" required
               class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
        <label class="block mb-1 text-sm font-medium">Password (Birthdate)</label>
        <input type="text" name="password" required
               placeholder="dd/mm/yyyy"
               class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500">
    </div>

    <button type="submit"
            class="w-full bg-blue-600 text-white p-3 rounded-lg font-bold hover:bg-blue-700 transition">
        LOG IN
    </button>

</form>

</div>

</body>
</html>
