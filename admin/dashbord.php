<?php 
session_start(); 


if ($_SESSION['role'] != "admin"){
    header("Location: ../login.php");
    exit();
}
include_once '../database/db_connection.php';

// Count the number of users
$stmt = $conn->query("SELECT COUNT(*) FROM users");
$usersCount = $stmt->fetchColumn();

// Count the total number of reservations
$stmt = $conn->query("SELECT COUNT(*) FROM reservations");
$ordersCount = $stmt->fetchColumn();

// Calculate the sum of the amounts of validated reservations (status = 'confirmed' for example)
$stmt = $conn->prepare("SELECT SUM(amount) FROM reservations WHERE status = ?");
$stmt->execute(['confirmed']);
$revenue = $stmt->fetchColumn();

// If you want to count all the revenue regardless of the status, you can simply do:
// $stmt = $conn->query("SELECT SUM(amount) FROM reservations");
// $revenue = $stmt->fetchColumn();

// Handling the case where there are no reservations yet

if ($revenue === null) {
    $revenue = 0;
}
if ($usersCount === null) {
    $usersCount = 0;
}
if ($ordersCount === null) {
    $ordersCount = 0;
}
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Professional Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar {
            height: 100vh;
            background: #343a40;
            color: #fff;
            padding-top: 20px;
        }
        .sidebar a {
            color: #fff;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background: #495057;
        }
        .content {
            margin-left: 220px;
            padding: 30px;
        }
        .header {
            background: #fff;
            padding: 20px;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <div class="sidebar position-fixed p-3">
            <h3 class="text-center mb-4">My Dashboard</h3> 
            <a href="?page=users">Users</a>
            <a href="?page=orders">Orders</a>
            <a href="?page=stats">Statistics</a>
            <a href="?page=messages">Messages</a>
            <a href="../deconnexion.php" class="btn btn-danger">Logout</a>
        </div>
        <div class="content flex-grow-1">
            <div class="header mb-4">
                <h2>Welcome, <?php echo isset($_SESSION['first_name']) ? htmlspecialchars($_SESSION['first_name']) : 'User'; ?> !</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card text-bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Users</h5>
                            <p class="card-text fs-2"><?php echo $usersCount; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Orders</h5>
                            <p class="card-text fs-2"><?php echo $ordersCount; ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Revenue (€)</h5>
                            <p class="card-text fs-2"><?php echo $revenue; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content flex-grow-1"> 

    <?php if ($page == 'users'): ?>
        <!-- Users table -->
        <?php
        $stmt = $conn->query("SELECT id, first_name, email, role FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <h3>List of Users</h3>
        <table class="table table-striped">
            <thead>
                <tr><th>Username</th><th>Email</th><th>Role</th></tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr> 
                    <td><?= htmlspecialchars($user['first_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($page == 'messages'): ?>
        <?php
        // Contact messages table
        $stmt = $conn->query("SELECT id, name, email, message FROM contact_messages ORDER BY id DESC");
        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);  
        ?>
        <h3>Contact Messages</h3>
        <table class="table table-striped">
            <thead>
                <tr><th>Name</th><th>Email</th><th>Message</th></tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $message): ?>
                <tr> 
                    <td><?= htmlspecialchars($message['name']) ?></td>
                    <td><?= htmlspecialchars($message['email']) ?></td>
                    <td><?= htmlspecialchars($message['message']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($page == 'orders'): ?>
    <!-- Orders table -->
    <?php
    // Retrieving orders
    $stmt = $conn->query("SELECT r.id, u.first_name, r.reservation_date, r.status, r.adresse, r.amount FROM reservations r JOIN users u ON r.user_id = u.id ORDER BY r.reservation_date DESC");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // If the form is submitted, update the status
    if (isset($_POST['update_status'])) {
        $order_id = $_POST['order_id'];
        $new_status = $_POST['status'];

        // Prepared query to update the status
        $stmt = $conn->prepare("UPDATE reservations SET status = :status WHERE id = :id");
        $stmt->bindParam(':status', $new_status);
        $stmt->bindParam(':id', $order_id);
        $stmt->execute();

        // Redirect to avoid reloading the form with the same data
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    }
    ?>

    <h3>List of Orders</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Reservation Date</th>
                <th>Status</th>
                <th>Address</th>
                <th>Amount (€)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['first_name']) ?></td>
                <td><?= htmlspecialchars($order['reservation_date']) ?></td>
                <td><?= htmlspecialchars($order['status']) ?></td>
                <td><?= htmlspecialchars($order['adresse']) ?></td>
                <td><?= htmlspecialchars($order['amount']) ?></td>
                <td>
                    <!-- Status update form -->
                    <form action="" method="POST">
                        <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                        <select name="status" class="form-select" required>
                            <option value="confirmed" <?= $order['status'] == 'confirmed' ? 'selected' : ''; ?>>Confirmed</option>
                            <option value="pending" <?= $order['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="canceled" <?= $order['status'] == 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-sm btn-primary mt-2">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php elseif ($page == 'stats'): ?> 
        <!-- Example chart with Chart.js -->
        <canvas id="revenueChart" style="max-width: 600px; margin-top: 30px;"></canvas> 
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Users', 'Orders', 'Revenue (€)'],
                    datasets: [{
                        label: 'Statistics',
                        data: [<?php echo $usersCount; ?>, <?php echo $ordersCount; ?>, <?php echo $revenue; ?>],
                        backgroundColor: ['#0d6efd', '#198754', '#ffc107']
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        </script> 
        
    <?php else: ?>
        <!-- Dashboard home page or default message -->
        <p>Select a section in the sidebar.</p>
    <?php endif; ?>
</div>

        </div>
    </div>
</body>
</html>