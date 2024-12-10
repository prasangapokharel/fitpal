<?php
include_once '../config/db.php';
include_once '../includes/session.php';

// OpenRouter and Gemini API keys
$openRouterApiKey = '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';
$geminiApiKey = 'AIzaSyBoJ8pwhV9TsJTZdGR48ByTz9r9PGF3Kt0';

// Function to call OpenRouter AI API
function getWorkoutPlanFromOpenRouter($prompt) {
    $url = 'https://openrouter.ai/api/v1/chat/completions';

    $data = [
        'model' => 'openai/gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $GLOBALS['openRouterApiKey']
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return false; // Return false on error
    }

    curl_close($ch);

    $responseData = json_decode($response, true);
    return $responseData['choices'][0]['message']['content'] ?? false; // Return false if no valid content
}

// Function to call Gemini API
function getWorkoutPlanFromGemini($prompt) {
    $url = "https://generativelanguage.googleapis.com/v1beta2/models/text-bison-001:generateText?key=" . $GLOBALS['geminiApiKey'];

    $data = [
        'prompt' => [
            'text' => $prompt
        ]
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return false; // Return false on error
    }

    curl_close($ch);

    $responseData = json_decode($response, true);
    return $responseData['candidates'][0]['output'] ?? false; // Return false if no valid content
}

// Fetch user and body stats data
try {
    $stmt = $db->prepare("
        SELECT 
            u.full_name, u.age, u.weight, u.height, u.gender, 
            bs.bmi 
        FROM users u
        LEFT JOIN body_stats bs ON u.user_id = bs.user_id
        WHERE u.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("User data not found.");
    }

    // Prepare the prompt
    $prompt = "Create a 7-day personalized home workout plan for a "
        . $user['age'] . "-year-old " . strtolower($user['gender'])
        . " with BMI " . $user['bmi'] . ", weight " . $user['weight'] . "kg, and height "
        . $user['height'] . "cm. Include bodyweight exercises only, suitable for home workouts.";

    // Try OpenRouter AI first
    $workoutPlan = getWorkoutPlanFromOpenRouter($prompt);

    // If OpenRouter fails, fallback to Gemini
    if (!$workoutPlan) {
        $workoutPlan = getWorkoutPlanFromGemini($prompt);
    }

    // If both fail, display an error
    if (!$workoutPlan) {
        $workoutPlan = "Unable to generate workout plan. Please try again later.";
    }
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workouts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Barlow', sans-serif;
        }
        .workout-plan {
            background-color: #fef3c7; /* Light yellow background */
            color: #374151; /* Dark gray text */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .workout-day {
            font-weight: 600;
            font-size: 18px;
            color: #1f2937; /* Slightly darker text for headings */
            margin-bottom: 10px;
        }
        .workout-exercise {
            font-size: 16px;
            margin-left: 20px;
            margin-bottom: 5px;
        }
        .error-message {
            color: #dc2626; /* Red text for errors */
            font-size: 16px;
        }
    </style>
</head>
<body class="bg-blue-100 text-gray-800">
    <?php include_once '../includes/sidebar.php'; ?>
    <div class="ml-64 p-8">
        <h1 class="text-3xl font-bold mb-6">Workouts</h1>
        <div class="bg-white p-6 shadow-lg rounded-lg">
            <h2 class="text-xl font-semibold mb-4">Today's Personalized Workout</h2>
            
            <div id="workout-container">
                <?php
                if (strpos($workoutPlan, "Unable to generate") === false) {
                    echo nl2br(htmlspecialchars($workoutPlan)); // Display formatted workout plan
                } else {
                    echo "<div class='error-message'>$workoutPlan</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
