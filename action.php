<?php
session_start(); // ✅ Required at the top

$nameErr = $emailErr = $websiteErr = $genderErr = "";
$name = $email = $website = $comments = $gender = "";

function test_input($data) {
    return stripslashes(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = test_input($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email cannot be empty";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid Email Format";
        }
    }

    if (!empty($_POST["website"])) {
        $website = test_input($_POST["website"]);
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $websiteErr = "Invalid URL";
        }
    }

    $comments = !empty($_POST["comments"]) ? test_input($_POST["comments"]) : "";

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required";
    } else {
        $gender = test_input($_POST["gender"]);
    }

    if (!$nameErr && !$emailErr && !$websiteErr && !$genderErr) {
        $_SESSION['success'] = compact('name', 'email', 'website', 'comments', 'gender');
        $_SESSION['show_alert'] = true; 
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
}
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <link rel="stylesheet" href="formstyles.css">
</head>
<body>

<!-- <?php
if (isset($_SESSION['success'])) {
    echo "<div class='output'>";
    echo "<h2>Your Input:</h2>";
    echo "<p><strong>Name:</strong> {$_SESSION['success']['name']}</p>";
    echo "<p><strong>Email:</strong> {$_SESSION['success']['email']}</p>";
    echo "<p><strong>Website:</strong> {$_SESSION['success']['website']}</p>";
    echo "<p><strong>Comments:</strong> {$_SESSION['success']['comments']}</p>";
    echo "<p><strong>Gender:</strong> {$_SESSION['success']['gender']}</p>";
    echo "</div>";
    unset($_SESSION['success']);
}
?> -->

<h1>Form Validation</h1>
<div class="container">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

        <div class="form-group">
            <label for="name">Full Name</label>
            <div class="input-wrap">
                <input type="text" name="name" id="name">
                <span class="error">* <?php echo $nameErr; ?></span>
            </div>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-wrap">
                <input type="email" name="email" id="email">
                <span class="error">* <?php echo $emailErr; ?></span>
            </div>
        </div>

        <div class="form-group">
            <label for="website">Website</label>
            <div class="input-wrap">
                <input type="text" name="website" id="website">
                <span class="error">* <?php echo $websiteErr; ?></span>
            </div>
        </div>

        <div class="form-group">
            <label for="comments">Comments</label>
            <textarea name="comments" id="comments" rows="3" cols="50" placeholder="Your comments..."></textarea>
        </div>

        <div class="form-group">
            <label>Gender</label>
            <div class="input-wrap">
                <input type="radio" name="gender" value="male"> Male
                <input type="radio" name="gender" value="female"> Female
                <input type="radio" name="gender" value="others"> Others
                <span class="error">* <?php echo $genderErr; ?></span>
            </div>
        </div>

        <div class="form-group">
            <button type="submit">Submit</button>
        </div>

    </form>
    <?php
    if (isset($_SESSION['show_alert']) && $_SESSION['show_alert'] === true) {
    echo "<script>alert('Form submitted successfully!');</script>";
    unset($_SESSION['show_alert']);
    }
?>
</div>
</body>
</html>