<?php
include "connection.php"
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>La Fontaine Community Center</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        
        <link href="img/logo.png" rel="icon">

        
       <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        
        
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">        
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body>        
        <div class="top-bar d-none d-md-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-8">
                        <div class="top-bar-left">
                            <div class="text">
                                <i class="fa fa-phone-alt"></i>
                                <p>+250-787-691-062</p>
                            </div>
                            <div class="text">
                                <i class="fa fa-envelope"></i>
                                <p>info@lafontaine.org</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="top-bar-right">
                            <div class="social">
                                <a href=""><i class="fab fa-twitter"></i></a>
                                <a href=""><i class="fab fa-linkedin-in"></i></a>
                                <a href=""><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div  class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a href="index.php" class="navbar-brand"><img src="img/logo.png" alt=""></a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav ml-auto">
                        <a href="index.php" class="nav-item nav-link">Home</a>
                        <a href="about.php" class="nav-item nav-link">About</a>
                        <a href="donate.php" class="nav-item nav-link">Donate</a> 
                        <a href="event.php" class="nav-item nav-link">Events</a>
                        <a href="team.php" class="nav-item nav-link">Team</a>
                       
                        <a href="join.php" class="nav-item nav-link active">Join us</a>

                        <a href="contact.php"   class="nav-item nav-link">Contact</a>
                    </div>
                </div>
            </div>
        </div>
        
        
        <!-- Page Header Start -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Join us</h2>
                    </div>
                    <div class="col-12">
                        <a href="">Home</a>
                        <a href="">Join us Page</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->
        
                        
  
        
        <!-- Volunteer Start -->
        <div id="join_us" class="volunteer" data-parallax="scroll" data-image-src="img/join_us.jpeg">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-5">
                        <div class="volunteer-form">
                     <?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['volunteer_submit'])) {
    // Validate and sanitize input data
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $motivation = trim($_POST['motivation']);
    
    // Validate required fields
    $errors = [];
    
    if (empty($full_name)) {
        $errors[] = "Full name is required";
    } elseif (strlen($full_name) > 100) {
        $errors[] = "Full name must be less than 100 characters";
    }
    
    if (empty($phone)) {
        $errors[] = "Phone number is required";
    } elseif (strlen($phone) > 20) {
        $errors[] = "Phone number must be less than 20 characters";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email address is required";
    } elseif (strlen($email) > 100) {
        $errors[] = "Email must be less than 100 characters";
    }
    
    if (empty($motivation)) {
        $errors[] = "Motivation statement is required";
    }
    
    // If no errors, proceed with database insertion
    if (empty($errors)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO volunteer_applications (full_name, phone, email, motivation) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $phone, $email, $motivation);
        
        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "Thank you for your application! We'll be in touch soon.";
            
            // Clear form fields
            $full_name = $phone = $email = $motivation = "";
        } else {
            $errors[] = "Error submitting your application: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    }
}
?>

<!-- Display success/error messages -->
<?php if (isset($success_message)): ?>
    <div class="alert alert-success mt-3">
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger mt-3">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Volunteer Application Form -->
<form action="" method="POST">
    <div class="control-group">
        <input type="text" class="form-control" name="full_name" placeholder="Name" required 
               value="<?php echo isset($full_name) ? htmlspecialchars($full_name) : ''; ?>">
    </div>
    <div class="control-group">
        <input type="tel" class="form-control" name="phone" placeholder="Phone" required 
               value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">
    </div>
    <div class="control-group">
        <input type="email" class="form-control" name="email" placeholder="Email" required 
               value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
    </div>
    <div class="control-group">
        <textarea class="form-control" name="motivation" placeholder="Why do you want to become a volunteer?" required><?php echo isset($motivation) ? htmlspecialchars($motivation) : ''; ?></textarea>
    </div>
    <div>
        <button style="background-color: #f7cc2d;color: black;border: none;" class="btn btn-custom" type="submit" name="volunteer_submit">Join Now</button>
    </div>
</form>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="volunteer-content">
                            <div class="section-header">
                                <p style="text-transform: none;">Become a Volunteer</p>
                                <h2>Let’s make a difference in the lives of others</h2>
                            </div>
                            <div class="volunteer-text">
                                <p>
                                  Join us in making a meaningful impact. Volunteer your time and skills to support our charity events, help communities in need, and be part of a compassionate movement that changes lives for the better.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Volunteer End -->
        

  <?php include "footer.php" ?>
        
        <!-- Back to top button -->
        <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
        
        <!-- Pre Loader -->
        <div id="loader" class="show">
            <div class="loader"></div>
        </div>

       
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/parallax/parallax.min.js"></script>
      
        <script src="mail/jqBootstrapValidation.min.js"></script>
        <script src="mail/contact.js"></script>

        
        <script src="js/main.js"></script>
    </body>
</html>
