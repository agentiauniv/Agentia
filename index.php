<?php
session_start();

$success = "";
$error = "";
$forceLogin = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $forceLogin = true;

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {

        $supabase_url = "https://uhqqlzpaybcyxrepisgi.supabase.co/rest/v1/login";
        $api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MDg0MDI3OCwiZXhwIjoyMDg2NDE2Mjc4fQ.zgY2AsO71vrf5V1lWW0J35nUtut1qUvfvGTRAHFRz7Y
";

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
<title>UniMate | Academic Portal</title>

<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-200 min-h-screen transition-colors duration-500">

<nav class="fixed top-0 left-0 right-0 z-[100] navbar-blur border-b border-slate-200 dark:border-slate-800">
  <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
    <a href="#/" class="flex items-center gap-2.5 hover:opacity-80 transition-opacity">
      <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm">
         <i class="fa-solid fa-graduation-cap text-base"></i>
      </div>
      <span class="text-xl font-display font-bold tracking-tight text-slate-900 dark:text-white">UniMate</span>
    </a>

    <div class="flex items-center gap-4">
      <button id="theme-toggle" class="w-9 h-9 flex items-center justify-center rounded-lg border border-slate-200 dark:border-slate-800">
        <i id="theme-icon" class="fa-solid fa-moon text-slate-500 dark:text-amber-400"></i>
      </button>

      <a id="nav-login-btn" href="#/login"
         class="px-5 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-[12px] font-bold rounded-lg uppercase tracking-wider">
        LOG IN
      </a>
    </div>
  </div>
</nav>

<div id="view-container"></div>

<!-- HOME TEMPLATE -->
<template id="home-template">
<main class="max-w-6xl mx-auto px-8 md:px-12 pt-36 pb-20 fade-in">
<h1 class="text-4xl font-bold text-center">Welcome to UniMate</h1>
</main>
</template>

<!-- LOGIN TEMPLATE -->
<template id="login-template">
<main class="flex-1 flex flex-col items-center justify-center min-h-screen p-6 sm:p-12 fade-in">

<h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold mb-10 text-center pt-16">
Student Portal
</h1>

<div class="w-full max-w-lg p-8 rounded-2xl shadow-2xl bg-white dark:bg-slate-900 border">

<?php if (!empty($success)): ?>
<p class="text-green-500 text-center mb-4"><?php echo $success; ?></p>
<?php endif; ?>

<?php if (!empty($error)): ?>
<p class="text-red-500 text-center mb-4"><?php echo $error; ?></p>
<?php endif; ?>

<form id="loginForm" method="POST" action="index.php#/login" class="space-y-6">

<div>
<label class="block text-sm font-medium mb-2">University Email</label>
<input type="email" name="email" required
class="w-full p-4 rounded-xl border bg-slate-50">
</div>

<div>
<label class="block text-sm font-medium mb-2">Password (Birthdate)</label>
<input type="text" name="password" id="dob" required maxlength="10"
class="w-full p-4 rounded-xl border bg-slate-50">
</div>

<button type="submit"
class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold">
LOG IN
</button>

</form>
</div>
</main>
</template>

<script>
<?php if ($forceLogin): ?>
window.location.hash = '#/login';
<?php endif; ?>
</script>

<script src="main.js"></script>
</body>
</html>
