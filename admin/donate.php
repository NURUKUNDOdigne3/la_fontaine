<?php
include "../connection.php";

 $query = "SELECT id, donor_name, telephone, email, donation_amount, donation_date, payment_status, payment_method 
          FROM donations ORDER BY donation_date DESC";
$result = mysqli_query($conn, $query);

 $total_donations_query = "SELECT COUNT(*) as total FROM donations";
$total_donations_result = mysqli_query($conn, $total_donations_query);
$total_donations = mysqli_fetch_assoc($total_donations_result)['total'];

$total_amount_query = "SELECT SUM(donation_amount) as total FROM donations WHERE payment_status = 'completed'";
$total_amount_result = mysqli_query($conn, $total_amount_query);
$total_amount = mysqli_fetch_assoc($total_amount_result)['total'] ?? 0;

$today = date('Y-m-d');
$today_donations_query = "SELECT COUNT(*) as today FROM donations WHERE DATE(donation_date) = '$today'";
$today_donations_result = mysqli_query($conn, $today_donations_query);
$today_donations = mysqli_fetch_assoc($today_donations_result)['today'];

$pending_donations_query = "SELECT COUNT(*) as pending FROM donations WHERE payment_status = 'pending'";
$pending_donations_result = mysqli_query($conn, $pending_donations_query);
$pending_donations = mysqli_fetch_assoc($pending_donations_result)['pending'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Dash - Donations</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        nav {
            background-color: #09610d;
            color: white;
            height: 100vh;
            position: fixed;
            width: 250px;
            transition: all 0.5s ease;
        }
        
        .dashboard {
            /* margin-left: 250px; */
            min-height: 100vh;
            transition: all 0.5s ease;
        }
        
        .top {
            background-color: #09610d;
            padding: 15px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dash-content {
            padding: 30px;
        }
        
        .table-responsive {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        .table th {
            background-color: #09610d;
            color: white;
            font-weight: 600;
            padding: 15px;
        }
        
        .table td {
            padding: 15px;
            vertical-align: middle;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-failed {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .btn-action {
            padding: 5px 10px;
            font-size: 0.85rem;
            margin: 0 2px;
        }
        
        .logo-name {
            padding: 20px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo-image img {
            width: 40px;
            height: 40px;
            object-fit: contain;
            margin-right: 10px;
        }
        
        .menu-items {
            padding: 20px 0;
        }
        
        .nav-links li {
            list-style: none;
            margin-bottom: 5px;
        }
        
        .nav-links a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover, .nav-links a.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }
        
        .nav-links i {
            margin-right: 10px;
            font-size: 1.2rem;
        }
        
        .logout-mode {
            padding: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .page-title {
            color: #09610d;
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #09610d;
        }
        
        .stats-label {
            color: #6c757d;
            font-size: 0.9rem;
        }
        
        .amount {
            font-weight: 600;
            color: #09610d;
        }
        
        .donation-date {
            font-size: 0.85rem;
            color: #6c757d;
        }
        
        .payment-method {
            padding: 3px 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            font-size: 0.8rem;
            display: inline-block;
        }
        
        .search-container {
            margin-bottom: 20px;
        }
        
        .export-btn {
            background-color: #f7cc2d;
            border: none;
            color: #333;
            font-weight: 600;
        }
        
        .export-btn:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
               <img src="../img/logo.png" alt="">
            </div>
            <span class="logo_name" style="color:#f7cc2d;">La Fontaine</span>
        </div>
        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="index.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li> 

                <li><a href="add_event.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Add event</span>
                </a></li>

                <li>
                    <a href="candidate.php">
                        <i class="uil uil-files-landscapes"></i>
                        <span class="link-name">Candidates</span>
                    </a>
                </li>

                <li><a href="donate.php" class="active">
                    <i class="uil uil-thumbs-up"></i>
                    <span class="link-name">Donations</span>
                </a></li>
                <li><a href="contact.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Contacted</span>
                </a></li>
                <li><a href="email.php">
                    <i class="uil uil-share"></i>
                    <span class="link-name">News Letter</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="#">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <div class="admin-info">
                <span>Welcome, Admin</span>
                <img src="images/profile.jpg" alt="">
            </div>
        </div>

        <div class="dash-content">
            <h1 class="page-title">Donations Management</h1>
            
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">
                            <?php echo $total_donations; ?>
                        </div>
                        <div class="stats-label">Total Donations</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">
                            $<?php echo number_format($total_amount, 2); ?>
                        </div>
                        <div class="stats-label">Total Amount</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">
                            <?php echo $today_donations; ?>
                        </div>
                        <div class="stats-label">Today's Donations</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number">
                            <?php echo $pending_donations; ?>
                        </div>
                        <div class="stats-label">Pending Payments</div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="search-container">
                    <input type="text" class="form-control" placeholder="Search donations..." id="searchInput">
                </div>
                <button class="btn export-btn">
                    <i class="uil uil-export"></i> Export CSV
                </button>
            </div>
            
            <div class="activity">
                <div class="title">
                    <i style="background-color: #f7cc2d;" class="uil uil-money-bill"></i>
                    <span class="text">All Donations</span>
                </div>
                
                <div class="activity-data">
                    <div class="container-fluid">
                        <div class="table-responsive shadow-sm rounded">
                            <table class="table table-bordered table-hover align-middle" id="donationsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Donor Name</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Donation Date</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $status_class = 'status-' . $row['payment_status'];
                                            echo "<tr>
                                                    <td>{$row['id']}</td>
                                                    <td>{$row['donor_name']}</td>
                                                    <td>{$row['email']}</td>
                                                    <td>{$row['telephone']}</td>
                                                    <td class='amount'>$" . number_format($row['donation_amount'], 2) . "</td>
                                                    <td><span class='payment-method'>{$row['payment_method']}</span></td>
                                                    <td class='donation-date'>" . date('M j, Y g:i A', strtotime($row['donation_date'])) . "</td>
                                                    <td><span class='status-badge $status_class'>{$row['payment_status']}</span></td>
                                                    <td class='text-center'>
                                                        <button class='btn btn-sm btn-success btn-action' title='View Details'><i class='uil uil-eye'></i></button>
                                                        <button class='btn btn-sm btn-warning btn-action' title='Edit'><i class='uil uil-edit'></i></button>
                                                        <button class='btn btn-sm btn-danger btn-action' title='Delete'><i class='uil uil-trash'></i></button>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9' class='text-center'>No donations found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Simple sidebar toggle functionality
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            const nav = document.querySelector('nav');
            const dashboard = document.querySelector('.dashboard');
            
            if (nav.style.width === '0px' || nav.style.width === '') {
                nav.style.width = '250px';
                dashboard.style.marginLeft = '250px';
            } else {
                nav.style.width = '0px';
                dashboard.style.marginLeft = '0px';
            }
        });
        
        // Add active class to clicked nav items
        const navLinks = document.querySelectorAll('.nav-links a');
        navLinks.forEach(link => {
            link.addEventListener('click', function() {
                navLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('#donationsTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>