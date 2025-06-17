<?php
include_once 'database/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération et nettoyage des données
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Validation simple
        if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($message)) {
            // Préparation de la requête d'insertion
            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (:name, :email, :message)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':message', $message);

            $stmt->execute();

            // Redirection ou message de confirmation
            $message = "Merci, votre message a été envoyé avec succès.";
            header("Location: user/dashboard.php?success=" . urlencode($message));
        } else {
            echo "Veuillez remplir correctement tous les champs.";
        }
    } else {
        echo "Méthode de requête invalide.";
    }
?>
