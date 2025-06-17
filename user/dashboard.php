<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}
include_once '../database/db_connection.php';
$message = '';

if (isset($_POST['submit_reservation'])) {
    $user_id = $_SESSION['user_id'];
    $reservation_date = $_POST['reservation_date'] ?? null;
    $adresse = $_POST['adresse'] ?? null;
    $amount = $_POST['amount'] ?? null;
    $status = 'en attente';

    // Validation basique
    if ($reservation_date && $adresse && $amount) {
        // Préparer et insérer en base
        $stmt = $conn->prepare("INSERT INTO reservations (user_id, reservation_date, adresse, amount, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $reservation_date, $adresse, $amount, $status]);

        $message = "Réservation enregistrée avec succès !";
    } else {
        $message = "Veuillez remplir tous les champs correctement.";
    }
    
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CleanTech - Accueil</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../css/style.css">

    <style>
        /* Style custom inspiré de Molly Maid */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f9fa;
            color: #333;
        }
        .navbar-brand img {
            height: 40px;
        }
        .navbar {
            box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
            background-color: white;
        }
        .nav-link {
            font-weight: 500;
            color: #2a2a2a !important;
        }
        .nav-link:hover {
            color: #0d6efd !important;
        }
        .btn-contact {
            background-color: #0d6efd;
            color: white;
            font-weight: 600;
            padding: 8px 18px;
            border-radius: 25px;
            transition: background-color 0.3s ease;
        }
        .btn-contact:hover {
            background-color: #084dbc;
            color: white;
        } 
    </style>
</head>
<body> 
<!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span class="logo-text">CleanTech</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto"> 
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a href="#contact" class="btn btn-contact">Contact</a>
                    </li>
                    
                    <li class="nav-item ms-lg-3">
                        <a href="../deconnexion.php" class="btn btn-danger">Deconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="alertTop">  
        <?php if ($message): ?>  
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const alertTop = document.querySelector('.alertTop');  
    setTimeout(() => {
        if (alertTop) {
            alertTop.style.display = 'none';  
        }
    }, 3000);})
    </script>
<!-- Hero Section -->
<header id="home" class="hero-section">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6">
                    <h1>Professional Cleaning Services in Tangier</h1>
                    <p class="lead">Transforming spaces with our expert cleaning solutions for homes and businesses.</p>
                    <a href="#contact" class="btn btn-primary btn-lg me-2">Get a Quote</a>
                    <a href="#services" class="btn btn-outline-light btn-lg">Our Services</a>
                </div>
            </div>
        </div>
    </header>
<!-- Exemple de sections pour Services et About -->
<section id="services" class="container my-5">
    <h2 class="mb-4">Nos Services</h2>
    <div class="row g-4">
        <?php 
        // Exemple tableau services (id, nom, description, prix, image)
        $services = [
            ['id'=>1, 'name'=>'Nettoyage de maison', 'desc'=>'Service complet de nettoyage', 'price'=>100, 'img'=>'../images/cleaning1.jpg'],
            ['id'=>2, 'name'=>'Nettoyage de hotel', 'desc'=>'Service complet de nettoyage', 'price'=>100, 'img'=>'../images/cleaning1.jpg'],
            ['id'=>3, 'name'=>'Nettoyage de office', 'desc'=>'Service complet de nettoyage', 'price'=>100, 'img'=>'../images/cleaning1.jpg']
        ];

        foreach ($services as $service): ?>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <img src="<?= htmlspecialchars($service['img']); ?>?auto=format&fit=crop&w=600&q=80" class="card-img-top" alt="<?= htmlspecialchars($service['name']); ?>" />
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($service['name']); ?></h5>
                    <p class="card-text"><?= htmlspecialchars($service['desc']); ?></p>
                    <p><strong>Prix :</strong> <?= number_format($service['price'], 2); ?>DH</p>
                    <button class="btn btn-primary btn-reserve" data-service-id="<?= $service['id'] ?>" data-service-name="<?= htmlspecialchars($service['name']) ?>" data-service-price="<?= $service['price'] ?>">Réserver</button>

                    <!-- Formulaire caché -->
                    <form method="post" class="reservation-form mt-3 d-none" data-service-id="<?= $service['id'] ?>">
                        <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                        <div class="mb-3">
                            <label for="reservation_date_<?= $service['id'] ?>" class="form-label">Date de réservation</label>
                            <input type="datetime-local" id="reservation_date_<?= $service['id'] ?>" name="reservation_date" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="adresse_<?= $service['id'] ?>" class="form-label">Adresse</label>
                            <textarea id="adresse_<?= $service['id'] ?>" name="adresse" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Montant (DH)</label>
                            <input type="text" name="amount" class="form-control" value="<?= number_format($service['price'], 2); ?>" readonly>
                        </div>
                        <button type="submit" name="submit_reservation" class="btn btn-success">Confirmer la réservation</button>
                        <button type="button" class="btn btn-secondary btn-cancel">Annuler</button>
                    </form>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<script>
document.querySelectorAll('.btn-reserve').forEach(button => {
    button.addEventListener('click', () => {
        const serviceId = button.getAttribute('data-service-id');

        // Cacher tous les formulaires
        document.querySelectorAll('.reservation-form').forEach(form => {
            form.classList.add('d-none');
        });

        // Afficher le formulaire lié
        const form = document.querySelector(`.reservation-form[data-service-id="${serviceId}"]`);
        if (form) {
            form.classList.remove('d-none');
        }
    });
});

document.querySelectorAll('.btn-cancel').forEach(button => {
    button.addEventListener('click', () => {
        button.closest('form').classList.add('d-none');
    });
});
</script>


<section id="about" class="py-5" style="background-color: #ededed;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="../images/before-after.gif" alt="About Us" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-5">
                        <h2>About CleanMaroc</h2>
                        <p>CleanMaroc is a leading cleaning service provider in Tangier, dedicated to delivering
                            exceptional cleaning solutions for both residential and commercial properties. With years of
                            experience, we take pride in our attention to detail and commitment to customer
                            satisfaction.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-primary me-2"></i> Professional and Trained Staff</li>
                            <li><i class="fas fa-check text-primary me-2"></i> Eco-Friendly Cleaning Products</li>
                            <li><i class="fas fa-check text-primary me-2"></i> 100% Satisfaction Guarantee</li>
                            <li><i class="fas fa-check text-primary me-2"></i> Flexible Scheduling</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
</section>


<section id="contact" class="container my-5">
    <h2>Contactez-nous</h2>
    <form action="../contact_handler.php" method="post" class="row g-3">
        <div class="col-md-6">
            <label for="name" class="form-label">Nom</label>
            <input type="text" class="form-control" id="name" name="name" required />
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">Adresse Email</label>
            <input type="email" class="form-control" id="email" name="email" required />
        </div>
        <div class="col-12">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
    </form>
</section>

<!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>CleanMaroc</h5>
                    <p>Professional cleaning services in Tangier for homes and businesses.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled"> 
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Follow Us</h5>
                    <div class="social-links">
                        <a href="#" class="me-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-2"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; 2025 CleanMaroc. All rights reserved.</p>
            </div>
        </div>
    </footer>
<!-- Bootstrap JS (Popper + Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
