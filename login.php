<?php 
include 'database/db_connection.php';  
session_start();
$_SESSION = array();  

function handleSignUp() {
    global $conn;

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone) || empty($password)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header("Location: login.php?tab=signup");
        exit();
    }

    if ($password !== $confirmPassword) {
        $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
        header("Location: login.php?tab=signup");
        exit();
    }
 

    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone, password_hash) VALUES (?, ?, ?, ?, ?)");
    $success = $stmt->execute([$firstName, $lastName, $email, $phone, $password]);

    if ($success) {
        $_SESSION['success'] = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
        header("Location: login.php?tab=login");
        exit();
    } else {
        // To get error info from PDO:
        $errorInfo = $stmt->errorInfo();
        $_SESSION['error'] = "Erreur lors de la création du compte : " . $errorInfo[2];
        header("Location: login.php?tab=signup");
        exit();
    }
    $_POST= array(); // Clear POST data after processing
    unset($_POST);
}

function handleLogin() {
    global $conn;    
    var_dump($_POST);
    
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "L'email et le mot de passe sont requis.";
        header("Location: login.php?tab=login");
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $pu = $user['password'];
    if ($user) {
        if ($password == $user['password_hash']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
            if($user["role"] == "admin") {
                $_SESSION['role'] = "admin";
                header("Location: admin/dashbord.php");
            } else {
                $_SESSION['role'] = "user";
                header("Location: user/dashboard.php");
            }
            exit();
        } else {
            $_SESSION['error'] = "Email ou mot de passe invalide";
            header("Location: login.php?tab=login");
            exit();
        }
    } else {
        $_SESSION['error'] = "Aucun utilisateur trouvé avec cet email.";
        header("Location: login.php?tab=login");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

    if (isset($_POST['CreateAccount'])) {
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
    <title>Connexion - CleanMaroc</title>
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
                        <a class="nav-link active" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#testimonials">Avis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#team">Équipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.html#portfolio">Notre Travail</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-3" href="login.php">Réservez maintenant</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Section -->
    <section class="login-section mt-4">
        <div class="container">
            <div class="login-card">
                <!-- Flash messages -->
                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger m-3" id="error-alert">
                            <?php echo htmlspecialchars($_SESSION['error']); ?>
                    </div>
                            <script>
                            setTimeout(function() {
                                var alert = document.getElementById('error-alert');
                                if (alert) alert.style.display = 'none';
                            }, 5000);
                            </script>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success m-3" id="success-alert">
                        <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
                    </div>
                    <script>
                        setTimeout(function() {
                            var alert = document.getElementById('success-alert');
                            if (alert) alert.style.display = 'none';
                        }, 5000);
                    </script>
                <?php endif; ?>

                <ul class="nav nav-pills nav-justified mb-4" id="authTabs" role="tablist">
                    <li class="nav-item"><button class="nav-link active" id="login-tab" data-bs-toggle="pill"
                            data-bs-target="#login-tab-pane" type="button">Connexion</button></li>
                    <li class="nav-item"><button class="nav-link" id="signup-tab" data-bs-toggle="pill"
                            data-bs-target="#signup-tab-pane" type="button">S'inscrire</button></li>
                </ul>

                <div class="tab-content" id="authTabsContent">
                    <!-- Login Tab -->
                    <div class="tab-pane fade show active" id="login-tab-pane">
                        <div class="login-body p-3">
                            <form method="POST" action="login.php">
                                <div class="mb-3">
                                    <label for="loginEmail">Email</label>
                                    <input type="email" class="form-control" id="loginEmail" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="loginPassword" class="form-label">Mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="loginPassword" placeholder="Entrez votre mot de passe" name="password" required>
                                        <button class="btn btn-outline-secondary toggle-password " id="btnEye" type="button" name="password" data-target="loginPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-login" name="signIn">Se connecter</button>
                            </form>
                        </div>
                    </div>

                    <!-- Sign-Up Tab -->
                    <div class="tab-pane fade" id="signup-tab-pane">
                        <div class="login-body p-3">
                            <form method="POST" action="login.php">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName">Prénom</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName"
                                            required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName">Nom de famille</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="signupEmail">Email</label>
                                    <input type="email" class="form-control" id="signupEmail" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone">Numéro de téléphone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="signupPassword" placeholder="Créer un mot de passe" required  name="password">
                                        <button class="btn btn-outline-secondary toggle-password"  type="button" data-target="signupPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmer le mot de passe</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirmez votre mot de passe" required name="confirmPassword">
                                        <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">J'accepte les conditions et la politique de confidentialité</label>
                                </div>
                                <button type="submit" class="btn btn-primary btn-login" name="CreateAccount">Créer un compte</button>
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
