<?php
declare(strict_types=1);

require_once __DIR__ . "/../../Services/AuthService.php";

use Src\Services\AuthService;

session_start();

$auth = new AuthService();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $user = $auth->login($email, $password);

    if ($user) {
        $_SESSION["user"] = $user;
        if (($user["role_name"] ?? '') === "teacher") {
            header("Location: ../teacher/dashboard.php");
        } else {
            header("Location: ../student/dashboard.php");
        }

        exit;

    } else {
        $error = "Invalid email or password ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <title>EduQuiz Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

<div class="bg-white p-10 rounded-2xl shadow-lg w-full max-w-md">

    <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

    <?php if (!empty($error)): ?>
        <p class="text-red-500 text-center mb-4">
            <?= $error ?>
        </p>
    <?php endif; ?>

    <form method="POST" class="flex flex-col gap-4">

        <input
                type="email"
                name="email"
                placeholder="Email"
                class="border p-3 rounded-xl"
                required
        >

        <input
                type="password"
                name="password"
                placeholder="Password"
                class="border p-3 rounded-xl"
                required
        >

        <button
                type="submit"
                class="bg-indigo-600 text-white p-3 rounded-xl hover:bg-indigo-700"
        >
            Login
        </button>

    </form>

    <!-- LINK -->
    <p class="text-center text-sm mt-4">
        Don't have an account?
        <a href="register.php" class="text-indigo-600 font-bold">Register</a>
    </p>

</div>

</body>
</html>