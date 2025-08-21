<?php
session_start();
$department = $_GET['department'] ?? 'general';


include 'db.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = isset($_POST['email']) ? trim($_POST['email']) : '';
  $password = isset($_POST['password']) ? trim($_POST['password']) : '';

  $servername = "localhost";
  $dbUSERname = "root";
  $dbPassword = "";
  $dbName = "student_portal";

  try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbName", $dbUSERname, $dbPassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sqlAdmin = "SELECT * FROM admins WHERE email = ?";
    $stmtAdmin = $conn->prepare($sqlAdmin);
    $stmtAdmin->execute([$email]);
    $admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

    if ($admin) {
      if ($password === $admin['password']) {
        $_SESSION['email'] = $admin['email'];
        $_SESSION['role'] = 'admin';
        $_SESSION['first_name'] = $admin['first_name'];
        header('Location: admin_dashboard.php');
        exit;
      } else {
        echo "❌ Incorrect password for admin.";
        exit;
      }
    }

    // Check in students table
    $sqlStudent = "SELECT * FROM students WHERE email = ?";
    $stmtStudent = $conn->prepare($sqlStudent);
    $stmtStudent->execute([$email]);
    $student = $stmtStudent->fetch(PDO::FETCH_ASSOC);

    if ($student) {
      if ($password === $student['password']) {
        $_SESSION['email'] = $student['email'];
        $_SESSION['role'] = 'student';
        header('Location: student_dashboard.php');
        exit;
      } else {
        echo "❌ Incorrect password for student.";
        exit;
      }
    }


    echo "❌ User not found. Please check your email.";
  } catch (PDOException $e) {
    echo "❌ Something went wrong: " . $e->getMessage();
  }
}






?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome to our student portal</title>
  <link rel="stylesheet" href="./styles/style.css" />
</head>

<body>
  <header>
    <h2 class="logo">Welcome to Our Student Portal </h2>
    <div class="hamburger" id="hamburger">
      &#9776;

    </div>
    <nav class="navigation" id="navigation">
      <a href="#">Home</a>
      <div class="dropdown">
        <a href="#" class="dropbtn">Department</a>
        <div class="dropdown-content">
          <a href="computer_science.php">Computer Science</a>
          <a href="physics.php">Physics</a>
          <a href="math.php">Math</a>
          <a href="chemistry.php">Chemistry</a>
        </div>
      </div>

      <button class="btnLogin-popup">Login</button>
    </nav>

  </header>


  <div class="wrapper" id="loginWrapper">
    <span class="icon-close" id="closeBtn">
      <ion-icon name="close-outline"></ion-icon>
    </span>

    <div class="form-box login">
      <h2>Login</h2>
      <form method="POST" action="index.php">


        <div class="input-box">
          <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
          <input type="email" name="email" required>
          <label>Email </label>
        </div>
        <div class="input-box">
          <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
          <input type="password" name="password" required>
          <label>Password</label>
        </div>
        <div class="remember-forgot">
          <label><input type="checkbox"> Remember me</label>
          <a href="#">Forgot Password?</a>
        </div>
        <button type="submit" class="btn">Login</button>
      </form>
    </div>
  </div>





  </div>

  <div class="header">📢 General Announcements</div>
  <div class="announcements">
    <?php include 'get_announcements.php';
    ?>
  </div>



  <script src="scripts/index.js"></script>

  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>