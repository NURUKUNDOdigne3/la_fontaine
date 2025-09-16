<?php
include "../connection.php";

// Fetch all contact messages
$query = "SELECT id, name, email, subject, message, submission_date, status 
      FROM contact_messages 
      ORDER BY submission_date DESC";
$result = mysqli_query($conn, $query);

// Count messages
$total_messages_query = "SELECT COUNT(*) as total FROM contact_messages";
$total_messages_result = mysqli_query($conn, $total_messages_query);
$total_messages = 0;
if ($total_messages_result && $row = mysqli_fetch_assoc($total_messages_result)) {
    $total_messages = $row['total'];
}

$new_messages_query = "SELECT COUNT(*) as new FROM contact_messages WHERE status = 'new'";
$new_messages_result = mysqli_query($conn, $new_messages_query);
$new_messages = 0;
if ($new_messages_result && $row = mysqli_fetch_assoc($new_messages_result)) {
    $new_messages = $row['new'];
}

$read_messages_query = "SELECT COUNT(*) as read FROM contact_messages WHERE status = 'read'";
$read_messages_result = mysqli_query($conn, $read_messages_query);
$read_messages = 0;
if ($read_messages_result && $row = mysqli_fetch_assoc($read_messages_result)) {
    $read_messages = $row['read'];
}

$replied_messages_query = "SELECT COUNT(*) as replied FROM contact_messages WHERE status = 'replied'";
$replied_messages_result = mysqli_query($conn, $replied_messages_query);
$replied_messages = 0;
if ($replied_messages_result && $row = mysqli_fetch_assoc($replied_messages_result)) {
    $replied_messages = $row['replied'];
}
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
  <title>Admin Dash - Contact Messages</title>
  <style>
    body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; }
    nav { background-color: #09610d; color: white; height: 100vh; position: fixed; width: 250px; transition: all 0.5s ease; }
    .dashboard { min-height: 100vh; transition: all 0.5s ease; }
    .top { background-color: #09610d; padding: 15px 30px; color: white; display: flex; justify-content: space-between; align-items: center; }
    .dash-content { padding: 30px; }
    .table-responsive { background-color: white; border-radius: 10px; overflow: hidden; box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); }
    .table th { background-color: #09610d; color: white; font-weight: 600; padding: 15px; }
    .table td { padding: 15px; vertical-align: middle; }
    .status-badge { padding: 5px 10px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; }
    .status-new { background-color: #fff3cd; color: #856404; }
    .status-read { background-color: #d4edda; color: #155724; }
    .status-replied { background-color: #cce5ff; color: #004085; }
    .btn-action { padding: 5px 10px; font-size: 0.85rem; margin: 0 2px; }
    .logo-name { padding: 20px; display: flex; align-items: center; border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
    .logo-image img { width: 40px; height: 40px; object-fit: contain; margin-right: 10px; }
    .menu-items { padding: 20px 0; }
    .nav-links li { list-style: none; margin-bottom: 5px; }
    .nav-links a { display: flex; align-items: center; padding: 12px 20px; text-decoration: none; color: rgba(255, 255, 255, 0.7); transition: all 0.3s ease; }
    .nav-links a:hover, .nav-links a.active { background-color: rgba(255, 255, 255, 0.1); color: white; }
    .nav-links i { margin-right: 10px; font-size: 1.2rem; }
    .logout-mode { padding: 20px; border-top: 1px solid rgba(255, 255, 255, 0.1); }
    .page-title { color: #09610d; margin-bottom: 20px; font-weight: 700; }
    .stats-card { background: white; border-radius: 10px; padding: 20px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); margin-bottom: 20px; transition: transform 0.3s ease; }
    .stats-card:hover { transform: translateY(-5px); }
    .stats-number { font-size: 2rem; font-weight: 700; color: #09610d; }
    .stats-label { color: #6c757d; font-size: 0.9rem; }
    .message-text { max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .search-container { margin-bottom: 20px; }
    .submission-date { font-size: 0.85rem; color: #6c757d; }
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
        <li><a href="index.php"><i class="uil uil-estate"></i><span class="link-name">Dashboard</span></a></li> 
        <li><a href="add_event.php"><i class="uil uil-plus-circle"></i><span class="link-name">Add Event</span></a></li>
        <li><a href="candidate.php"><i class="uil uil-users-alt"></i><span class="link-name">Volunteers</span></a></li>
        <li><a href="donate.php"><i class="uil uil-usd-circle"></i><span class="link-name">Donations</span></a></li>
        <li><a href="contact.php" class="active"><i class="uil uil-envelope"></i><span class="link-name">Contacted</span></a></li>
        <li><a href="email.php"><i class="uil uil-share"></i><span class="link-name">News Letter</span></a></li>
      </ul>
      <ul class="logout-mode">
        <li><a href="#"><i class="uil uil-signout"></i><span class="link-name">Logout</span></a></li>
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
      <h1 class="page-title">Contact Messages</h1>
      <div class="row mb-4">
        <div class="col-md-3">
          <div class="stats-card">
            <div class="stats-number"><?php echo $total_messages; ?></div>
            <div class="stats-label">Total Messages</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stats-card">
            <div class="stats-number"><?php echo $new_messages; ?></div>
            <div class="stats-label">New Messages</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stats-card">
            <div class="stats-number"><?php echo $read_messages; ?></div>
            <div class="stats-label">Read Messages</div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="stats-card">
            <div class="stats-number"><?php echo $replied_messages; ?></div>
            <div class="stats-label">Replied Messages</div>
          </div>
        </div>
      </div>
      <div class="search-container">
        <input type="text" class="form-control" placeholder="Search messages..." id="searchInput">
      </div>
      <div class="activity">
        <div class="title">
          <i style="background-color: #f7cc2d;" class="uil uil-envelope"></i>
          <span class="text">All Contact Messages</span>
        </div>
        <div class="activity-data">
          <div class="container-fluid">
            <div class="table-responsive shadow-sm rounded">
              <table class="table table-bordered table-hover align-middle" id="messagesTable">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Submission Date</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                      $status_class = 'status-' . $row['status'];
                      echo "<tr>
                          <td>{$row['id']}</td>
                          <td>{$row['name']}</td>
                          <td>{$row['email']}</td>
                          <td>{$row['subject']}</td>
                          <td class='message-text' title='{$row['message']}'>{$row['message']}</td>
                          <td class='submission-date'>" . date('M j, Y g:i A', strtotime($row['submission_date'])) . "</td>
                          <td><span class='status-badge $status_class'>{$row['status']}</span></td>
                          <td class='text-center'>
                            <button class='btn btn-sm btn-success btn-action' title='View Details'><i class='uil uil-eye'></i></button>
                            <button class='btn btn-sm btn-warning btn-action' title='Edit'><i class='uil uil-edit'></i></button>
                            <button class='btn btn-sm btn-danger btn-action' title='Delete'><i class='uil uil-trash'></i></button>
                          </td>
                        </tr>";
                    }
                  } else {
                    echo "<tr><td colspan='8' class='text-center'>No contact messages found</td></tr>";
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
    const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
      link.addEventListener('click', function() {
        navLinks.forEach(l => l.classList.remove('active'));
        this.classList.add('active');
      });
    });
    document.getElementById('searchInput').addEventListener('keyup', function() {
      const searchText = this.value.toLowerCase();
      const rows = document.querySelectorAll('#messagesTable tbody tr');
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
