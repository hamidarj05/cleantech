why doesn't work <?php
session_start();
    include 'database/db_connection.php';

function handleSignUp(){
    // Include database connection

    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate input
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: login.php");
        exit();
    }
    // Check if passwords match
     if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Passwords do not match.";
        header("Location: login.php");
        exit();
    }
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $firstName, $lastName, $email, $phone, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Account created successfully. You can now log in.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error'] = "Error creating account: " . $stmt->error;
        header("Location: login.php");
        exit();
    }
}
function handleLogin(){ 

    // Get form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate input
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Email and password are required.";
        header("Location: login.php");
        exit();
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['success'] = "Login successful. Welcome back!";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid email or password.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "No user found with that email.";
        header("Location: login.php");
        exit();
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    echo '<script>'.implode("/",$_POST).'</script>';
    if(isset($_POST['CreateAccount'])) {
        handleSignUp();
    } elseif (isset($_POST['signIn'])) { 
        handleLogin();
    }
    
} 




?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CleanMaroc</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .login-section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('images/hero-bg.webp') no-repeat center center/cover;
            padding: 2rem 0;
        }

        .login-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            max-width: 500px;
            margin: 0 auto;
        }

        .login-header {
            background: var(--primary-color);
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .login-header img {
            max-width: 150px;
            margin-bottom: 1rem;
        }

        .login-body {
            padding: 2rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .btn-login {
            background: var(--primary-color);
            border: none;
            padding: 0.75rem;
            font-weight: 600;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-login:hover {
            background: #2980b9;
        }

        .login-footer {
            text-align: center;
            padding: 1.5rem;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }

        .login-footer a {
            color: var(--primary-color);
            font-weight: 500;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <span class="logo-text">CleanTech</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#testimonials">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#team">Team</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#portfolio">Our Work</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-3" href="login.php">Book Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="login-section mt-4">
        <div class="container">
            <div class="login-card">
                <ul class="nav nav-pills nav-justified mb-4" id="authTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="login-tab" data-bs-toggle="pill" data-bs-target="#login-tab-pane" type="button" role="tab">Login</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="signup-tab" data-bs-toggle="pill" data-bs-target="#signup-tab-pane" type="button" role="tab">Sign Up</button>
                    </li>
                </ul>
                
                <div class="tab-content" id="authTabsContent">
                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="login-tab-pane" role="tabpanel" aria-labelledby="login-tab">
                        <div class="login-body">
                            <form id="loginForm" method="POST" action="login.php">
                                <div class="mb-3">
                                    <label for="loginEmail" class="form-label">Email address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="loginEmail" placeholder="Enter your email" name="email" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="loginPassword" placeholder="Enter your password" required>
                                        <button class="btn btn-outline-secondary toggle-password " id="btnEye" type="button" name="password" data-target="loginPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberMe">
                                    <label class="form-check-label" for="rememberMe">Remember me</label>
                                    <a href="forgot-password.html" class="float-end">Forgot password?</a>
                                </div>
                                <button type="submit" class="btn btn-primary btn-login w-100" name="signIn" >Sign In</button>
                            </form> 
                        </div>
                    </div>
                    
                    <!-- Sign Up Tab -->
                    <div class="tab-pane fade" id="signup-tab-pane" role="tabpanel" aria-labelledby="signup-tab">
                        <div class="login-body">
                            <form id="signupForm" method="POST" action="login.php">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="signupEmail" class="form-label">Email address</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="signupEmail" name="Email" placeholder="Enter your email" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="signupPassword" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="signupPassword" placeholder="Create a password" required  name="password">
                                        <button class="btn btn-outline-secondary toggle-password"  type="button" data-target="signupPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text">Password must be at least 8 characters long and include a number and a special character.</div>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password" required name="confirmPassword">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                                    </label>
                                </div> 

                                <button type="submit" class="btn btn-primary btn-login w-100"  name="CreateAccount" >Create Account</button>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     
    <script>
        document.querySelectorAll('.toggle-password').forEach(function (toggle) {
            toggle.addEventListener('click', function () {
                const target = document.getElementById(this.dataset.target);
                if (target.type === 'password') {
                    target.type = 'text';
                    this.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    target.type = 'password';
                    this.innerHTML = '<i class="fas fa-eye"></i>';
                }
            });
        });
    </script>
</body>

</html>