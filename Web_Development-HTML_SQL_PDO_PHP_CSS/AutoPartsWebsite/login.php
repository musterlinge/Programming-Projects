<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="./style.css">
  <title>Dream Team Auto Part</title>
</head>
<body>
<?php
// login.php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password']; // The password from the form

    // Check if the credentials are correct
    if ($email === "kh@gmail.com" && $password === "kh") {
        // Redirect to the workstation.html if correct
        header("Location: workstation.html");
        exit();
    } 
    // Check if the credentials are correct
    else if ($email === "sj@gmail.com" && $password === "sj") 
    {
      // Redirect to the workstation.html if correct
      header("Location: workstation.html");
      exit();
    }
    else if ($email === "ww@gmail.com" && $password === "ww") 
    {
      // Redirect to the workstation.html if correct
      header("Location: workstation.html");
      exit();
    }
    else if ($email === "admin@gmail.com" && $password === "admin") 
    {
      // Redirect to the workstation.html if correct
      header("Location: admin.php");
      exit();
    }
    else 
    {
        // Redirect back to login.html with an error message if not correct
        $_SESSION['error'] = 'Please enter a valid email';
        header("Location: login.php");
        exit();
    }
}
?>
  <header class="main-header">
    <div class="logo-container">
      <img class="logoImage" src="/images/logo.PNG" alt="Logo">
    </div>
    <nav class="nav-menu">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="product.php">Products</a></li>
        <li><a href="login.php">Sign in</a></li>
      </ul>
    </nav>
  </header>

  <div class="signin-login">
    <form action="login.php" method="POST">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br>
    <label for="pwd">Password:</label><br>
    <input type="password" id="pwd" name="password" required><br>
    <input type="submit" value="Sign In">
  </form>
  <?php if(isset($_SESSION['error'])): ?>
      <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
  <?php endif; ?>
  </div>
</body>
</html>

