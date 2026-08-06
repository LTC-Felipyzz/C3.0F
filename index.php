‎<?php
‎$student_name = "";
‎$student_age = "";
‎$status_message = "";
‎
‎if ($_SERVER["REQUEST_METHOD"] === "POST") {
‎    $student_name = htmlspecialchars(trim($_POST['name']));
‎    $student_age = htmlspecialchars(trim($_POST['age']));
‎
‎    // --- GITHUB CONFIGURATION ---
‎    $github_token = "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"; // Replace with your GitHub Token
‎    $repo_owner   = "LTC-Felipyzz";              // Replace with your GitHub Username
‎    $repo_name    = "C3.OF";             // Replace with your GitHub Repo Name
‎
‎    // Data payload formatted for GitHub Issues
‎    $data = array(
‎        "title" => "Student Log: " . $student_name,
‎        "body"  => "### Student Record\n- **Name:** " . $student_name . "\n- **Age:** " . $student_age . "\n- **Recorded At:** " . date("Y-m-d H:i:s")
‎    );
‎
‎    // Send payload to GitHub API via cURL
‎    $ch = curl_init("https://api.github.com/repos/$repo_owner/$repo_name/issues");
‎    curl_setopt_array($ch, array(
‎        CURLOPT_HTTPHEADER     => array(
‎            'Content-Type: application/json',
‎            'User-Agent: Student-Record-App',
‎            'Authorization: Bearer ' . $github_token
‎        ),
‎        CURLOPT_RETURNTRANSFER => true,
‎        CURLOPT_POST           => true,
‎        CURLOPT_POSTFIELDS     => json_encode($data)
‎    ));
‎
‎    $response  = curl_exec($ch);
‎    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
‎    curl_close($ch);
‎
‎        if ($http_code === 201) {
‎        $status_message = "Record successfully logged to GitHub!";
‎    } else {
‎        $status_message = "GitHub Error Code ($http_code): " . htmlspecialchars($response);
‎    }
‎}
‎?>
‎
‎<!DOCTYPE html>
‎<html lang="en">
‎<head>
‎    <meta charset="UTF-8">
‎    <meta name="viewport" content="width=device-width, initial-scale=1.0">
‎    <title>Student Information System</title>
‎    <style>
‎        body { font-family: Arial, sans-serif; background-color: #f4f6f9; padding: 30px; }
‎        .container { max-width: 420px; background: #ffffff; padding: 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
‎        .form-group { margin-bottom: 15px; }
‎        label { display: block; font-weight: bold; margin-bottom: 5px; }
‎        input[type="text"], input[type="number"] { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
‎        button { width: 100%; padding: 10px; background-color: #2da44e; color: white; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; }
‎        button:hover { background-color: #2c974b; }
‎        .output-card { margin-top: 20px; padding: 15px; background: #f0f7ff; border-left: 4px solid #0969da; border-radius: 4px; }
‎        .status { font-size: 13px; color: #57606a; margin-top: 8px; }
‎    </style>
‎</head>
‎<body>
‎
‎<div class="container">
‎    <h2>Student Entry Form</h2>
‎    <form method="POST" action="">
‎        <div class="form-group">
‎            <label for="name">Full Name:</label>
‎            <input type="text" id="name" name="name" placeholder="e.g., John Doe" required>
‎        </div>
‎        <div class="form-group">
‎            <label for="age">Age:</label>
‎            <input type="number" id="age" name="age" placeholder="e.g., 20" min="1" max="120" required>
‎        </div>
‎        <button type="submit">Submit Details</button>
‎    </form>
‎
‎    <?php if ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
‎        <div class="output-card">
‎            <h3>Student Information</h3>
‎            <p><strong>Name:</strong> <?php echo $student_name; ?></p>
‎            <p><strong>Age:</strong> <?php echo $student_age; ?> years old</p>
‎            <p class="status"><em><?php echo $status_message; ?></em></p>
‎        </div>
