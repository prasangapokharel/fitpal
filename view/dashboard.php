<?php
include_once '../config/db.php';
include_once '../includes/session.php'; // Include session file to handle authentication

// Fetch user data from the database
try {
    $stmt = $db->prepare("
        SELECT 
            u.full_name, u.age, u.weight, u.height, u.weekly_activities, 
            bs.bmi, bs.protein_goal, bs.calories_goal, bs.weight_recommendation, bs.weight_goal
        FROM users u
        LEFT JOIN body_stats bs ON u.user_id = bs.user_id
        WHERE u.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("User not found.");
    }
} catch (Exception $e) {
    die("Error fetching user data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Teko:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Teko', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <?php include_once '../includes/sidebar.php'; ?>

    <!-- Main Content -->
    <div class="ml-[250px] p-6">
        <h1 class="text-4xl font-bold text-blue-800 mb-4">Welcome, <?php echo htmlspecialchars($user['full_name']); ?>!</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- BMI -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-700">Your BMI</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">
                    <?php echo number_format($user['bmi'], 2); ?>
                </p>
            </div>

            <!-- Protein Goal -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-700">Protein Goal</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">
                    <?php echo number_format($user['protein_goal'], 2); ?> g/day
                </p>
            </div>

            <!-- Calories Goal -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-700">Calories Goal</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">
                    <?php echo number_format($user['calories_goal'], 2); ?> kcal/day
                </p>
            </div>

            <!-- Weight Recommendation -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-700">Recommended Weight</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">
                    <?php echo number_format($user['weight_recommendation'], 2); ?> kg
                </p>
            </div>

            <!-- Current Weight -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-700">Current Weight</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">
                    <?php echo number_format($user['weight'], 2); ?> kg
                </p>
            </div>

            <!-- Weight Goal -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-semibold text-blue-700">Goal Weight</h2>
                <p class="text-4xl font-bold text-gray-800 mt-2">
                    <?php echo number_format($user['weight_goal'], 2); ?> kg
                </p>
            </div>

            <!-- Weekly Activities -->
            <div class="bg-white rounded-lg shadow-lg p-6 md:col-span-2 lg:col-span-3">
                <h2 class="text-2xl font-semibold text-blue-700">Weekly Activities</h2>
                <p class="text-xl text-gray-800 mt-2 capitalize">
                    <?php echo htmlspecialchars($user['weekly_activities']); ?>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
