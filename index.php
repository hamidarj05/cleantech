<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CleanMaroc - Services de Nettoyage Professionnels à Tanger</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <span class="logo-text">CleanTech</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">À propos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Avis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">Équipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Notre Travail</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary ms-lg-3" href="login.php">Réservez maintenant</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header id="home" class="hero-section">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-6">
                    <h1>Services de Nettoyage Professionnels à Tanger</h1>
                    <p class="lead">Transformer les espaces avec nos solutions de nettoyage expertes pour les maisons et les entreprises.</p>
                    <a href="#contact" class="btn btn-primary btn-lg me-2">Obtenir un devis</a>
                    <a href="#services" class="btn btn-outline-light btn-lg">Nos Services</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Services Section -->
    <section id="services" class="py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Nos Services</h2>
                <p>Services de nettoyage professionnels adaptés à vos besoins</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-home"></i>
                        <h3>Nettoyage à Domicile</h3>
                        <p>Solutions de nettoyage complètes pour votre maison, garantissant un environnement impeccable et sain.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-hotel"></i>
                        <h3>Nettoyage d'Hôtel</h3>
                        <p>Services de nettoyage professionnels pour les hôtels afin de maintenir les plus hauts standards d'hygiène.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <i class="fas fa-building"></i>
                        <h3>Nettoyage de Bureau</h3>
                        <p>Créez un environnement de travail propre et productif avec nos services de nettoyage de bureau.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5" style="background-color: #ededed;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="images/before-after.gif" alt="About Us" class="img-fluid rounded">
                </div>
                <div class="col-lg-6">
                    <div class="ps-lg-5">
                        <h2>À propos de CleanMaroc</h2>
                        <p>CleanMaroc est un fournisseur de services de nettoyage de premier plan à Tanger, dédié à fournir des solutions de nettoyage exceptionnelles pour les propriétés résidentielles et commerciales. Avec des années d'expérience, nous sommes fiers de notre souci du détail et de notre engagement envers la satisfaction du client.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-primary me-2"></i> Personnel Professionnel et Formé</li>
                            <li><i class="fas fa-check text-primary me-2"></i> Produits de Nettoyage Écologiques</li>
                            <li><i class="fas fa-check text-primary me-2"></i> Garantie de Satisfaction à 100%</li>
                            <li><i class="fas fa-check text-primary me-2"></i> Horaires Flexibles</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Ce que disent nos clients</h2>
                <p>Écoutez nos clients satisfaits</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"Service excellent! Mon appartement n'a jamais été aussi propre. L'équipe est professionnelle et minutieuse."</p>
                        </div>
                        <div class="testimonial-author">
                            <h5>Sarah K.</h5>
                            <p>Client Résidentiel</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"Nous utilisons CleanMaroc pour notre hôtel depuis plus d'un an maintenant. Leur souci du détail est impressionnant."</p>
                        </div>
                        <div class="testimonial-author">
                            <h5>Mohammed R.</h5>
                            <p>Directeur d'Hôtel</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"Service fiable et professionnel. Ils vont toujours au-delà de nos attentes."
                            </p>
                        </div>
                        <div class="testimonial-author">
                            <h5>Leila M.</h5>
                            <p>Responsable de Bureau</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section id="team" class="py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Notre Équipe</h2>
                <p>Rencontrez nos experts en nettoyage professionnels</p>
            </div>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="team-card text-center">
                        <img src="images/picProfilejpg.jpg" alt="Team Member" class="img-fluid rounded-circle mb-3">
                        <h4>Hamid Arjdal</h4>
                        <p class="text-muted">Spécialiste du Nettoyage</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="team-card text-center">
                        <img src="images/picProfilejpg.jpg" alt="Team Member" class="img-fluid rounded-circle mb-3">
                        <h4>Fatima Zahra</h4>
                        <p class="text-muted">Responsable des Opérations</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="team-card text-center">
                        <img src="images/picProfilejpg.jpg" alt="Team Member" class="img-fluid rounded-circle mb-3">
                        <h4>Mohamed Ouali</h4>
                        <p class="text-muted">Quality Control</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="team-card text-center">
                        <img src="images/picProfilejpg.jpg" alt="Team Member" class="img-fluid rounded-circle mb-3">
                        <h4>Fouaad Bakkali</h4>
                        <p class="text-muted">Quality Control</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2>Our Work</h2>
                <p>Some of our recent cleaning projects</p>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="portfolio-item">
                        <img src="images/Residential Cleaning.png" alt="Portfolio 1" class="">
                        <div class="portfolio-overlay">
                            <h5>Residential Cleaning</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-item">
                        <img src="images/Hotel Cleaning.png" alt="Portfolio 2" class="img-fluid">
                        <div class="portfolio-overlay">
                            <h5>Hotel Cleaning</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portfolio-item">
                        <img src="images/Office Cleaning.png" alt="Portfolio 3" class="img-fluid">
                        <div class="portfolio-overlay">
                            <h5>Office Cleaning</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mx-auto text-center">
                    <h2>Get In Touch</h2>
                    <p class="lead">Ready to book our services or have questions? Contact us today!</p>
                    <div class="contact-info mt-4">
                        <p><i class="fas fa-phone me-2"></i> +212 600-123456</p>
                        <p><i class="fas fa-envelope me-2"></i> info@cleanmaroc.ma</p>
                        <p><i class="fas fa-map-marker-alt me-2"></i> Tangier, Morocco</p>
                    </div>
                </div>
            </div>
        </div>
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
                        <li><a href="#home">Home</a></li>
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

    <!-- Back to Top Button -->
    <a href="#" class="back-to-top"><i class="fas fa-arrow-up"></i></a>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="js/main.js"></script>
</body>

</html>