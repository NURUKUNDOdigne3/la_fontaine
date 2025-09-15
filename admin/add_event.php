<?php
include "../connection.php";

 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save'])) {
    $event_title = trim($_POST['event_title']);
    $date_event = $_POST['date_event'];
    $event_description = trim($_POST['event_description']);
    
     $target_dir = "../uploads/events/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $imageFileType = strtolower(pathinfo($_FILES["event_picture"]["name"], PATHINFO_EXTENSION));
    $file_name = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $file_name;
    
    $uploadOk = 1;
    $error_msg = "";
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["event_picture"]["tmp_name"]);
    if($check === false) {
        $error_msg = "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check file size (max 5MB)
    if ($_FILES["event_picture"]["size"] > 5000000) {
        $error_msg = "Sorry, your file is too large. Max size is 5MB.";
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        $error_msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["event_picture"]["tmp_name"], $target_file)) {
            // Insert into database
            $stmt = $conn->prepare("INSERT INTO events (event_title, date_event, event_description, event_picture) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $event_title, $date_event, $event_description, $file_name);
            
            if ($stmt->execute()) {
                $success_msg = "Event added successfully!";
            } else {
                $error_msg = "Error saving event: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_msg = "Sorry, there was an error uploading your file.";
        }
    }
}

// Handle event deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    
    // Get the image file name to delete it from server
    $result = $conn->query("SELECT event_picture FROM events WHERE id = $delete_id");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = "../uploads/events/" . $row['event_picture'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }
    
    // Delete from database
    if ($conn->query("DELETE FROM events WHERE id = $delete_id")) {
        $success_msg = "Event deleted successfully!";
    } else {
        $error_msg = "Error deleting event: " . $conn->error;
    }
}

// Fetch all events from the database
$query = "SELECT id, event_title, date_event, event_description, event_picture, created_at FROM events ORDER BY created_at DESC";
$result = mysqli_query($conn, $query);

// Count events
$events_count_query = "SELECT COUNT(*) as total FROM events";
$events_count_result = mysqli_query($conn, $events_count_query);
$events_count = mysqli_fetch_assoc($events_count_result)['total'];

// Count upcoming events (events with date_event in the future)
$today = date('Y-m-d');
$upcoming_events_query = "SELECT COUNT(*) as upcoming FROM events WHERE date_event >= '$today'";
$upcoming_events_result = mysqli_query($conn, $upcoming_events_query);
$upcoming_events = mysqli_fetch_assoc($upcoming_events_result)['upcoming'];

// Count past events
$past_events_query = "SELECT COUNT(*) as past FROM events WHERE date_event < '$today'";
$past_events_result = mysqli_query($conn, $past_events_query);
$past_events = mysqli_fetch_assoc($past_events_result)['past'];
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
    <title>Admin Dash - Events Management</title>
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
        
        .event-img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }
        
        .event-date {
            font-weight: 600;
            color: #09610d;
        }
        
        .event-description {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .btn-add-event {
            background-color: #09610d;
            color: white;
            font-weight: 600;
        }
        
        .btn-add-event:hover {
            background-color: #074a0a;
            color: white;
        }
        
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        
        .modal-header {
            background-color: #09610d;
            color: white;
        }
        
        .modal-header .btn-close {
            filter: invert(1);
        }
        
        .search-container {
            margin-bottom: 20px;
        }
        
        .action-buttons .btn {
            margin: 0 2px;
        }
        
        .event-status {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status-upcoming {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-past {
            background-color: #f8d7da;
            color: #721c24;
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

                <li><a href="add_event.php" class="active">
                    <i class="uil uil-plus-circle"></i>
                    <span class="link-name">Add Event</span>
                </a></li>

                <li>
                    <a href="candidate.php">
                        <i class="uil uil-users-alt"></i>
                        <span class="link-name">Candidates</span>
                    </a>
                </li>

                <li><a href="donate.php">
                    <i class="uil uil-usd-circle"></i>
                    <span class="link-name">Donations</span>
                </a></li>
                <li><a href="contact.php">
                    <i class="uil uil-envelope"></i>
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
            <h1 class="page-title">Events Management</h1>
            
            <!-- Display success/error messages -->
            <?php if (isset($success_msg)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $success_msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_msg)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error_msg; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">
                            <?php echo $events_count; ?>
                        </div>
                        <div class="stats-label">Total Events</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">
                            <?php echo $upcoming_events; ?>
                        </div>
                        <div class="stats-label">Upcoming Events</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-number">
                            <?php echo $past_events; ?>
                        </div>
                        <div class="stats-label">Past Events</div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="search-container">
                    <input type="text" class="form-control" placeholder="Search events..." id="searchInput">
                </div>
                <button class="btn btn-add-event" data-bs-toggle="modal" data-bs-target="#addEventModal">
                    <i class="uil uil-plus"></i> Add New Event
                </button>
            </div>
            
            <div class="activity">
                <div class="title">
                    <i style="background-color: #f7cc2d;" class="uil uil-calendar-alt"></i>
                    <span class="text">All Events</span>
                </div>
                
                <div class="activity-data">
                    <div class="container-fluid">
                        <div class="table-responsive shadow-sm rounded">
                            <table class="table table-bordered table-hover align-middle" id="eventsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Event Title</th>
                                        <th>Event Picture</th>
                                        <th>Event Date</th>
                                        <th>Event Description</th>
                                        <th>Created At</th>
                                        <th>Status</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $event_date = new DateTime($row['date_event']);
                                            $today = new DateTime();
                                            $status_class = $event_date >= $today ? 'status-upcoming' : 'status-past';
                                            $status_text = $event_date >= $today ? 'Upcoming' : 'Past';
                                            
                                            echo "<tr>
                                                    <td>{$row['id']}</td>
                                                    <td>{$row['event_title']}</td>
                                                    <td><img src='../uploads/events/{$row['event_picture']}' class='event-img' alt='Event Image'></td>
                                                    <td class='event-date'>" . date('M j, Y', strtotime($row['date_event'])) . "</td>
                                                    <td class='event-description' title='{$row['event_description']}'>{$row['event_description']}</td>
                                                    <td>" . date('M j, Y', strtotime($row['created_at'])) . "</td>
                                                    <td><span class='event-status $status_class'>$status_text</span></td>
                                                    <td class='text-center action-buttons'>
                                                        <button class='btn btn-sm btn-success'><i class='uil uil-eye'></i></button>
                                                        <button class='btn btn-sm btn-warning'><i class='uil uil-edit'></i></button>
                                                        <a href='?delete_id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this event?\")'><i class='uil uil-trash'></i></a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center'>No events found. Add your first event!</td></tr>";
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

    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Event Title *</label>
                            <input type="text" name="event_title" class="form-control" required maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Event Date *</label>
                            <input type="date" name="date_event" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Event Description *</label>
                            <textarea name="event_description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Event Picture *</label>
                            <input type="file" name="event_picture" class="form-control" accept="image/*" required>
                            <div class="form-text">Allowed formats: JPG, PNG, JPEG, GIF. Max size: 5MB</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="save" class="btn btn-success">Save Event</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
            const rows = document.querySelectorAll('#eventsTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                if (text.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
        
        // Set minimum date for event date input to today
        document.querySelector('input[name="date_event"]').min = new Date().toISOString().split("T")[0];
    </script>
</body>
</html>