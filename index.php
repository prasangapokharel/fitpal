<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitness Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background-color: #f4f4f4;
    color: #333;
}

header {
    background-color: #007bff;
    color: white;
    padding: 20px 10px;
    text-align: center;
}

header .logo h1 {
    margin-bottom: 10px;
}

nav ul {
    list-style-type: none;
}

nav ul li {
    display: inline;
    margin: 0 15px;
}

nav ul li a {
    color: white;
    text-decoration: none;
    font-size: 18px;
}

nav ul li a:hover {
    text-decoration: underline;
}

.dashboard {
    display: flex;
    justify-content: space-around;
    margin: 30px 0;
}

.card {
    background-color: white;
    border-radius: 8px;
    padding: 20px;
    width: 250px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.card h2 {
    color: #2196F3;
    margin-bottom: 15px;
}

.card p {
    color: #555;
}

footer {
    background-color: #007bff;
    color: white;
    text-align: center;
    padding: 15px 0;
    margin-top: 40px;
}


        </style>
</head>
<body>

    <!-- Header Section -->
    <header>
        <div class="logo">MyFitness</div>
        <nav>
            <a href="#">Home</a>
            <a href="#">Dashboard</a>
            <a href="#">Profile</a>
            <a href="#">Settings</a>
        </nav>
    </header>

    <!-- Main Dashboard Section -->
    <section class="dashboard">
        <div class="card">
            <h3>Steps Taken Today</h3>
            <p>8,500 steps</p>
        </div>
        <div class="card">
            <h3>Calories Burned</h3>
            <p>450 kcal</p>
        </div>
        <div class="card">
            <h3>Protein Goal</h3>
            <p>80g</p>
        </div>
        <div class="card">
            <h3>Current Weight</h3>
            <p>70 kg</p>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>© 2024 MyFitness. All rights reserved.</p>
    </footer>

</body>
</html>
