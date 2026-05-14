<?php
declare(strict_types=1);

require_once __DIR__ . "/../../Services/AuthService.php";
require_once __DIR__ . "/../../../config/DB.php";

$auth = new \Src\Services\AuthService();

$message = "";
$error = "";

try {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $auth->register(
            $_POST["name"] ?? '',
            $_POST["email"] ?? '',
            $_POST["password"] ?? '',
            (int)($_POST["role"] ?? 0)
        );

        $message = "Account created successfully";
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}

$sql = "SELECT * FROM roles";
$pdo = DB::connect();
$stmt = $pdo->query($sql);
$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>EduQuiz – Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 flex items-center justify-center">

<div class="bg-white rounded-3xl shadow-xl w-full max-w-lg px-12 py-12">

    <h1 class="text-3xl font-bold mb-6 text-center">Create Account</h1>

    <!-- MESSAGE -->
    <?php if (!empty($error)): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

    <?php if ($message): ?>
        <p class="text-green-600 text-center mb-4"><?= $message ?></p>
    <?php endif; ?>

    <!-- FORM -->
    <form method="POST" class="flex flex-col gap-5">

       
        <input
            type="text"
            name="name"
            placeholder="Full Name"
            class="border p-3 rounded-xl"
            >

      
        <input
            type="email"
            name="email"
            placeholder="Email"
            class="border p-3 rounded-xl"
        >

   
        <select name="role" class="border p-3 rounded-xl"  >
            <option value="">Select Role</option>

            <?php foreach ($roles as $role): ?>
                <option value="<?= $role['id'] ?>">
                    <?= $role['name'] ?>
                </option>
            <?php endforeach; ?>

        </select>

        <!-- Password -->
        <input
            type="password"
            name="password"
            placeholder="Password"
            class="border p-3 rounded-xl"
             
        >

    
        <button
            type="submit"
            class="bg-indigo-600 text-white p-3 rounded-xl hover:bg-indigo-700"
        >
            Create Account
        </button>

    </form>

   
    <p class="text-center text-sm mt-6">
        Already have an account?
        <a href="login.php" class="text-indigo-600 font-bold">Login</a>
    </p>

</div>

</body>
</html>