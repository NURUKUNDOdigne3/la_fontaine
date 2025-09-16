<?php
include "../connection.php"
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">    
     
 


    <title>Admin Dash</title>
    <style>
    .updateBtn {
      background-color: green;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      margin-right: 5px;
    }
    .deleteBtn {
      background-color: red;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
    }
    .updateBtn:hover {
      background-color: darkgreen;
    }
    .deleteBtn:hover {
      background-color: darkred;
    }
    .action-buttons {
      display: flex;
      gap: 8px; /* space between buttons */
      justify-content: center; /* center align inside cell */
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
                <li style="background-color: white;color: #09610d;"><a href="index.php">
                    <i style="color: #09610d;" class="uil uil-estate"></i>
                    <span  class="link-name" style="color: #09610d;font-weight: bold;">Dashboard</span>
                </a></li> 
              <li>
  <a href="add_event.php">
    <i style="color: white;" class="uil uil-files-landscapes"></i>
    <span class="link-name" style="color: white;">Add Event</span>
  </a>
</li>


                <li><a href="#">
                    <i style="color: white;" class="uil uil-chart"></i>
                    <span class="link-name" style="color:white">Candidates</span>
                </a></li>
                <li><a href="#">
                    <i style="color: white;" class="uil uil-thumbs-up"></i>
                    <span class="link-name" style="color:white;">Donates</span>
                </a></li>
                <li><a href="#">
                    <i style="color: white;" class="uil uil-comments"></i>
                    <span class="link-name" style="color: white;">Contacted</span>
                </a></li>
                <li><a href="#">
                    <i style="color: white;" class="uil uil-share"></i>
                    <span class="link-name" style="color: white;">News Letter mails</span>
                </a></li>
            </ul>
            
            <ul class="logout-mode">
                <li><a href="#">
                    <i style="color: white;" class="uil uil-signout"></i>
                    <span style="color: white;" class="link-name">Logout</span>
                </a></li>
             
            </ul>
        </div>
    </nav>
    <section class="dashboard">
        <div style="background-color:#09610d;" class="top">
            <i style="color: white;" class="uil uil-bars sidebar-toggle"></i>
            <img src="images/profile.jpg" alt="">
        </div>

        <div class="dash-content">
            <div class="overview">
                <div class="title">
                    <i style="background-color: #f7cc2d;" class="uil uil-tachometer-fast-alt"></i>
                    <span class="text">Dashboard</span>
                </div>
                <div class="boxes">
                    <div style="background-color: #09610d;" class="box box1">
                        <i style="color: white;" class="uil uil-comments"></i>
                        <span style="color: white;" class="text">Messages</span>
                        <span style="color: white;" class="number">50,120</span>
                    </div>
                    <div style="background-color: #f7cc2d;" class="box box2">
                        <i style="color: white;" class="uil  uil-thumbs-up"></i>
                        <span style="color: white" class="text">Donations</span>
                        <span style="color: white" class="number">20,120</span>
                    </div>
                    <div style="background-color: black;" class="box box3">
                        <i style="color: white;" class="uil uil-share"></i>
                        <span style="color: white;" class="text">Signed Emails </span>
                        <span style="color: white;" class="number">10,120</span>
                    </div>
                </div>
            </div>
            <div class="activity">
                <div class="title">
                    <i style="background-color: #f7cc2d;" class="uil uil-clock-three"></i>
                    <span class="text">Uploaded Events</span>
                </div>
                <div class="activity-data">
                  <div class="container py-4">
 
  

  
  <div class="table-responsive shadow-sm rounded">
    <table class="table table-bordered table-hover align-middle">
      <thead>
        <tr>
          <th style="background-color: #09610d;color:white;">Event ID</th>
          <th style="background-color: #09610d;color:white;">Event Title</th>
          <th style="background-color: #09610d;color:white;">Event Picture</th>
          <th style="background-color: #09610d;color:white;">Date Event Took Place</th>
          <th style="background-color: #09610d;color:white;">Event Description</th>
         
          
        </tr>
      </thead>
      <tbody>
       
        <tr>
          <td>1</td>
          <td>Charity Concert</td>
          <td><img src="uploads/sample.jpg" width="80" class="rounded"></td>
          <td>2025-09-01</td>
          <td>Fundraising event for local schools.</td>
        

          </tr>          
         <tr>
          <td>1</td>
          <td>Charity Concert</td>
          <td><img src="uploads/sample.jpg" width="80" class="rounded"></td>
          <td>2025-09-01</td>
          <td>Fundraising event for local schools.</td>
          
          
          </tr>          
        
      </tbody>
    </table>
  </div>
</div>


<div class="modal fade" id="addEventModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="insert_event.php" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Add New Event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body row g-3">
          <div class="col-md-6">
            <label class="form-label">Event Title</label>
            <input type="text" name="event_title" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Date Event Took Place</label>
            <input type="date" name="date_event" class="form-control" required>
          </div>
          <div class="col-12">
            <label class="form-label">Event Description</label>
            <textarea name="event_description" class="form-control" rows="3" required></textarea>
          </div>
          <div class="col-12">
            <label class="form-label">Event Picture</label>
            <input type="file" name="event_picture" class="form-control" required>
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
                    
            </div>

                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</body>
</html>

