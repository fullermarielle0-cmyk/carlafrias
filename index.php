<?php
session_start();

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user']);
$user = $isLoggedIn ? $_SESSION['user'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Carla SM. Frias | Portfolio</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
</head>
<body>
  <!-- ========== HEADER ========== -->
  <header class="site-header">
    <nav class="container nav">
      <div class="brand">Carla S.M. Frias</div>
      <div class="nav-links">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <?php if (!$isLoggedIn): ?>
          <a href="#register">Register</a>
          <a href="#login">Login</a>
        <?php else: ?>
          <a href="logout.php" class="logout-link">Logout</a>
        <?php endif; ?>
      </div>
    </nav>
  </header>

  <!-- ========== MAIN CONTENT ========== -->
  <main>
    <!-- ========== HERO SECTION ========== -->
    <section id="home" class="hero">
      <div class="container hero-grid">
        <!-- Left Side: Text -->
        <div class="hero-text">
          <p class="eyebrow">Hello, I'm</p>
          <h1>Carla SM. Frias</h1>
          <h2>BSCS | Block A</h2>
          <p>
            I am a student from Tomas Claudio Colleges passionate about
            web development, programming, and creating meaningful digital experiences.
          </p>

          <!-- Social Links -->
          <div class="social-links">
            <a href="https://www.facebook.com/carlafries14" target="_blank" rel="noreferrer">Facebook</a>
            <a href="https://www.instagram.com/carlafries_?stkn=dDlvdjZ1a2Y0YTY5" target="_blank" rel="noreferrer">Instagram</a>
          </div>

          <!-- CTA Buttons -->
          <?php if (!$isLoggedIn): ?>
            <div class="cta-group">
              <a href="#register" class="btn primary">Register</a>
              <a href="#login" class="btn secondary">Login</a>
            </div>
          <?php else: ?>
            <div class="cta-group">
              <span class="welcome-msg">Welcome, <?php echo htmlspecialchars($user['username']); ?>! (<?php echo htmlspecialchars($user['role']); ?>)</span>
            </div>
          <?php endif; ?>
        </div>

        <!-- Right Side: Profile Card -->
        <div class="profile-card">
          <img src="iconcarla.jpg" alt="Profile image" />
          <div class="profile-details">
            <h3>Profile</h3>
            <p><strong>Name:</strong> Carla SM. Frias</p>
            <p><strong>Program:</strong> BSCS</p>
            <p><strong>Section:</strong> Block A</p>
            <p><strong>Email:</strong> friascarla649@gmail.com</p>
            <p><strong>School:</strong> Tomas Claudio Colleges</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ========== ABOUT SECTION ========== -->
    <section id="about" class="about">
      <div class="container">
        <h2>About Me</h2>
        <div class="about-grid">
          <div class="about-card">
            <h3>Education</h3>
            <p>
              I am currently a student at Tomas Claudio Colleges taking up BSCS, where I continue
              developing my skills in software development and digital technology.
            </p>
          </div>
          <div class="about-card">
            <h3>Skills</h3>
            <p>HTML, CSS, JavaScript, Web Design, Problem-Solving, Creativity, Responsive Layouts</p>
          </div>
          <div class="about-card">
            <h3>Interests</h3>
            <p>Programming, learning new tech, personal growth, and building projects that are helpful and meaningful.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- ========== AUTH SECTION ========== -->
    <?php if (!$isLoggedIn): ?>
    <section class="auth-section">
      <div class="container auth-grid">
        <!-- Register Panel -->
        <div id="register" class="panel">
          <h2>Register</h2>
          <?php if (isset($_GET['register_error'])): ?>
            <div class="message error"><?php echo htmlspecialchars($_GET['register_error']); ?></div>
          <?php endif; ?>
          <?php if (isset($_GET['register_success'])): ?>
            <div class="message success"><?php echo htmlspecialchars($_GET['register_success']); ?></div>
          <?php endif; ?>
          <form method="POST" action="register.php">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <select name="role">
              <option value="user">User Account</option>
              <option value="admin">Admin Account</option>
            </select>
            <button type="submit" class="btn primary full">Register</button>
          </form>
        </div>

        <!-- Login Panel -->
        <div id="login" class="panel">
          <h2>Login</h2>
          <?php if (isset($_GET['login_error'])): ?>
            <div class="message error"><?php echo htmlspecialchars($_GET['login_error']); ?></div>
          <?php endif; ?>
          <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" class="btn primary full">Login</button>
          </form>

          <div class="admin-notice">
            <strong>Default Admin Account</strong>
            <p>Username: <b>admin</b></p>
            <p>Password: <b>123</b></p>
          </div>
        </div>
      </div>
    </section>
    <?php else: ?>
    <!-- ========== DASHBOARD SECTION ========== -->
    <section class="dashboard">
      <div class="container">
        <div class="welcome-panel">
          <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</h2>
          <a href="logout.php" class="btn secondary">Logout</a>
        </div>

        <!-- Admin Panel -->
        <?php if ($user['role'] === 'admin'): ?>
        <div class="admin-panel">
          <h3>Admin Panel - All Users</h3>
          <table>
            <thead>
              <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Role</th>
                <th>Created</th>
              </tr>
            </thead>
            <tbody>
              <?php
              // Database connection
              $conn = new mysqli('localhost', 'root', '', 'exam_db');
              if ($conn->connect_error) {
                die('Connection failed: ' . $conn->connect_error);
              }

              $result = $conn->query('SELECT id, username, role, created_at FROM users ORDER BY id DESC');

              if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['username']) . '</td>';
                  echo '<td>' . htmlspecialchars($row['role']) . '</td>';
                  echo '<td>' . date('M d, Y h:i A', strtotime($row['created_at'])) . '</td>';
                  echo '</tr>';
                }
              } else {
                echo '<tr><td colspan="4">No users found</td></tr>';
              }
              $conn->close();
              ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <div class="user-dashboard">
          <p>You are logged in as a regular user. Only admins can view the user list.</p>
        </div>
        <?php endif; ?>
      </div>
    </section>
    <?php endif; ?>
  </main>

  <!-- ========== FOOTER ========== -->
  <footer class="site-footer">
    <p>© 2026 Carla SM. Frias | Tomas Claudio Colleges</p>
  </footer>
</body>
</html>