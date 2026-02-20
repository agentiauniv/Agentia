<?php
$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $supabase_url = "https://uhqqlzpaybcyxrepisgi.supabase.co/rest/v1/login";
    $api_key = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InVocXF6bHBheWJjeXhyZXBpc2dpIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MDg0MDI3OCwiZXhwIjoyMDg2NDE2Mjc4fQ.zgY2AsO71vrf5V1lWW0J35nUtut1qUvfvGTRAHFRz7Y
"; // mets ta vraie clé ici

    $query = $supabase_url . "?email=eq." . urlencode($email) . "&password=eq." . urlencode($password);

    $ch = curl_init($query);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $api_key",
        "Authorization: Bearer $api_key"
    ]);

    $response = curl_exec($ch);
    echo $response;
    exit();
    curl_close($ch);

    $data = json_decode($response, true);

    if (is_array($data) && count($data) > 0) {
        $success = "Login successful ✅";
    } else {
        $error = "Invalid email or password ❌";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="main.css">
</head>

<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-slate-200 min-h-screen transition-colors duration-500">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-[100] navbar-blur border-b border-slate-200 dark:border-slate-800">
      <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="#/" class="flex items-center gap-2.5">
          <div class="w-9 h-9 flex items-center justify-center rounded-lg bg-blue-600 text-white shadow-sm">
             <i class="fa-solid fa-graduation-cap text-base"></i>
          </div>
          <span class="text-xl font-display font-bold tracking-tight text-slate-900 dark:text-white">UniMate</span>
        </a>

        <div class="flex items-center gap-4">
          <a id="nav-login-btn" href="#/login" class="px-5 py-2 bg-slate-900 text-white text-[12px] font-bold rounded-lg uppercase tracking-wider">
            LOG IN
          </a>
        </div>
      </div>
    </nav>

    <!-- View Container -->
    <div id="view-container"></div>

    <!-- Messages -->
    <?php if (!empty($success)): ?>
    <div class="fixed top-24 left-1/2 -translate-x-1/2 bg-green-100 text-green-700 px-6 py-3 rounded-xl shadow z-50">
        <?php echo $success; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
    <div class="fixed top-24 left-1/2 -translate-x-1/2 bg-red-100 text-red-700 px-6 py-3 rounded-xl shadow z-50">
        <?php echo $error; ?>
    </div>
    <?php endif; ?>

    <!-- Templates -->

    <template id="home-template">
        <main class="max-w-6xl mx-auto px-8 md:px-12 pt-36 pb-20 fade-in">
            <h1 class="text-4xl font-bold text-center">
                Welcome to UniMate
            </h1>
        </main>
    </template>

    <template id="login-template">
        <main class="flex-1 flex flex-col items-center justify-center min-h-screen p-6 sm:p-12 fade-in">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-display font-extrabold mb-10 text-center text-slate-900 dark:text-white pt-16 md:pt-20">
                Student Portal
            </h1>

            <div class="w-full max-w-lg p-8 sm:p-10 rounded-2xl shadow-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800">

                <form id="loginForm" method="POST" action="index.php#/login" class="space-y-6">

                    <div>
                        <label class="block text-sm font-medium mb-2 text-slate-500 dark:text-slate-400">
                            University Email
                        </label>
                        <input type="email" name="email" required
                            class="w-full p-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 outline-none focus:ring-2 focus:ring-blue-500/50">
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2 text-slate-500 dark:text-slate-400">
                            Password
                        </label>
                        <input type="text" name="password" id="dob" required
                            class="w-full p-4 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 outline-none focus:ring-2 focus:ring-blue-500/50">
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-bold text-lg">
                        LOG IN
                    </button>

                </form>
            </div>
        </main>
    </template>

    <script src="main.js"></script>

</body>
</html>


