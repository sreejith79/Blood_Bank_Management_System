<?php
    // Start session and include DBConnect class
    require_once 'php/DBConnect.php';
    $db = new DBConnect();
    $db->authLogin(); // Redirect if already logged in

    $message = NULL;
    $registrationMessage = NULL;
    $showModal = false; // Flag to determine whether to show the registration modal

    // Handle Login Submission
    if(isset($_POST['loginBtn'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $flag = $db->login($username, $password);
        if($flag) {
            header("Location: http://localhost/Blood_Bank_Management_System/home.php");
            exit();
        } else {
            $message = "Username or password was incorrect.";
        }
    }

    // Handle Registration Submission
    if(isset($_POST['registerBtn'])) {
        $id = trim($_POST['id']);
        $f_name = trim($_POST['f_name']);
        $m_name = trim($_POST['m_name']);
        $l_name = trim($_POST['l_name']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $b_day = $_POST['b_day'];
        $prc_nr = trim($_POST['prc_nr']);
        $designation = trim($_POST['designation']);
        $mobile_nr = trim($_POST['mobile_nr']);

        // Validate required fields
        if(empty($id) || empty($f_name) || empty($l_name) || empty($username) || empty($password) || empty($b_day) || empty($prc_nr) || empty($designation) || empty($mobile_nr)) {
            $registrationMessage = "Please fill in all required fields.";
            $showModal = true; // Show modal again
        } else {
            // Check if the username already exists
            $stmt = $db->db->prepare("SELECT * FROM employees WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->rowCount() >= 1) {
                echo "<script>alert('Username already taken by another one please try another');</script>";
                $showModal = false; // Show modal again
            } else {
                // Insert the new employee into the database
                $stmt = $db->db->prepare("INSERT INTO employees (id, f_name, m_name, l_name, username, password, b_date, prc_nr, designation, mobile_nr) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $success = $stmt->execute([$id, $f_name, $m_name, $l_name, $username, $password, $b_day, $prc_nr, $designation, $mobile_nr]);

                if ($success) {
                    echo "<script>alert('Registration successful. You can now log in.');</script>";
                    $showModal = false; // Hide modal on successful registration
                } else {
                    echo "<script>alert('Registration failed. Please try again.');</script>";
                    $showModal = false; // Show modal again
                }
            }
        }
    }

    $title = "LOGIN";
    include 'layout/_header.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Your existing navigation bar can be included here -->

    <div class="container" style="margin-top: 100px;">
        <div class="row">
            <!-- Login Form -->
            <div class="col-md-6">
                <?php if(isset($message)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($message); ?></div>
                <?php endif; ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="col-md-6">
                            <img src="assets/security-icon.png" class="img img-responsive img-thumbnail" alt="Security Icon">
                        </div>
                        <h5>User Login</h5>
                    </div>
                    <div class="panel-body">
                        <form action="login.php" method="post" class="form-vertical">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group loginBtn">
                                <button type="submit" name="loginBtn" class="btn btn-primary btn-sm">Login</button>
                                <!-- Trigger Registration Modal -->
                                <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#registerModal">I do not have username or password</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Registration Form Modal -->
            <div class="col-md-4">
                <img src="assets/left-index-logo.jpg" class="img img-responsive" alt="Logo">
            </div>
        </div>
    </div>

    <!-- Registration Modal -->
    <div class="modal fade <?php if($showModal) echo 'show'; ?>" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true" <?php if($showModal) echo 'style="display:block;"'; ?>>
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="registerModalLabel">Register New User</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php if(isset($registrationMessage)): ?>
                <div class="alert <?php echo strpos($registrationMessage, 'successful') !== false ? 'alert-success' : 'alert-danger'; ?>">
                    <?= htmlspecialchars($registrationMessage); ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="post">
              <div class="form-group">
                <label for="id">User ID *</label>
                <input type="text" class="form-control" id="id" name="id" required>
              </div>
              <div class="form-group">
                <label for="f_name">First Name *</label>
                <input type="text" class="form-control" id="f_name" name="f_name" required>
              </div>
              <div class="form-group">
                <label for="m_name">Middle Name</label>
                <input type="text" class="form-control" id="m_name" name="m_name">
              </div>
              <div class="form-group">
                <label for="l_name">Last Name *</label>
                <input type="text" class="form-control" id="l_name" name="l_name" required>
              </div>
              <div class="form-group">
                <label for="username_reg">Username *</label>
                <input type="text" class="form-control" id="username_reg" name="username" required>
              </div>
              <div class="form-group">
                <label for="password_reg">Password *</label>
                <input type="password" class="form-control" id="password_reg" name="password" required>
              </div>
              <div class="form-group">
                <label for="b_day">Birth Date *</label>
                <input type="date" class="form-control" id="b_day" name="b_day" required>
              </div>
              <div class="form-group">
                <label for="prc_nr">PRC Number *</label>
                <input type="text" class="form-control" id="prc_nr" name="prc_nr" required>
              </div>
              <div class="form-group">
                <label for="designation">Designation *</label>
                <input type="text" class="form-control" id="designation" name="designation" required>
              </div>
              <div class="form-group">
                <label for="mobile_nr">Mobile *</label>
                <input type="text" class="form-control" id="mobile_nr" name="mobile_nr" required>
              </div>
              <button type="submit" name="registerBtn" class="btn btn-primary">Register</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            <?php if($showModal): ?>
                $('#registerModal').modal('show');
            <?php endif; ?>
        });
    </script>
</body>
</html>
