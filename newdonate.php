<?php

include "connection.php";

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
                <a href="index.html" class="navbar-brand"><img src="img/logo.png" alt=""></a>
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                    <div class="navbar-nav ml-auto">
                        <a href="index.html" class="nav-item nav-link">Home</a>
                        <a href="about.html" class="nav-item nav-link">About</a>
                        <a href="donate.html" class="nav-item nav-link  active">Donate</a> 
                        <a href="event.html" class="nav-item nav-link">Events</a>
                        <a href="team.html" class="nav-item nav-link">Team</a>
                       
                        <a href="join.html" class="nav-item nav-link">Join us</a>

                        <a href="contact.html"   class="nav-item nav-link">Contact</a>
                    </div>
                </div>
            </div>
        </div>

        
        
        <!-- Page Header Start -->
        <div class="page-header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>Donate Now</h2>
                    </div>
                    <div class="col-12">
                        <a href="">Home</a>
                        <a href="">Donate</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Header End -->
        
        
        <!-- Donate Start -->
        <div class="container">
            <div class="donate" data-parallax="scroll" data-image-src="img/donate.jpeg">
                <div class="row align-items-center">
                    <div class="col-lg-7">
                        <div class="donate-content">
                            <div class="section-header">
                                <p>Donate Now</p>
                                <h2>Let's donate to people in need so they can have a better life</h2>
                            </div>
                            <div class="donate-text">
                                <p> Your contribution will make a tangible difference in the lives of children and youth,
                                     empowering them to become the driving force behind a more compassionate, creative, and equitable world.
                       </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="donate-form">
                            <?php
                        // Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $donor_name = trim($_POST['donor_name']);
    $telephone = trim($_POST['telephone']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $address = trim($_POST['address']);
    $message = trim($_POST['message']);
    $payment_method = trim($_POST['payment_method']);
    
     if (!empty($_POST['custom_amount'])) {
        $donation_amount = floatval($_POST['custom_amount']);
    } else {
        $donation_amount = floatval($_POST['donation_amount']);
    }
    
     $errors = [];
    if (empty($donor_name)) $errors[] = "Full name is required";
    if (empty($telephone)) $errors[] = "Telephone is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email is required";
    if (empty($donation_amount) || $donation_amount <= 0) $errors[] = "Valid donation amount is required";
    if (empty($payment_method)) $errors[] = "Payment method is required";
    
     if (empty($errors)) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO donations (donor_name, telephone, email, donation_amount, payment_method, address, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdsss", $donor_name, $telephone, $email, $donation_amount, $payment_method, $address, $message);
        
         if ($stmt->execute()) {
            $success_message = "Thank you for your donation! Your reference number is: #" . $stmt->insert_id;
        } else {
            $errors[] = "Error processing your donation: " . $stmt->error;
        }
        
        // Close statement
        $stmt->close();
    }
}

// Close connection
$conn->close();
?>
                           <form  method="post">
                            <div class="control-group">
                                <input type="text" class="form-control" required name="donor_name" placeholder="Full Name" required>
                            </div>
                            <div class="control-group">
                                <input type="tel" class="form-control" required name="telephone" placeholder="Telephone" required>
                            </div>
                            <div class="control-group">
                                <input type="email" class="form-control" required name="email" placeholder="Email Address" required>
                            </div>
                            <div class="control-group">
                                <input type="text" class="form-control" required name="address" placeholder="Address (Optional)">
                            </div>
                            <div class="control-group">
                                <textarea class="form-control"   name="message" placeholder="Message (Optional)" rows="3"></textarea>
                            </div>
                            
                            <h5 class=" text-white" style="color: white !important;">Select Donation Amount</h5>
                            <div class="amount-options donate-form flex justify-content-between mb-3">
                                <div class="amount-option">
                                    <input class="btn btn-custom" required type="radio" id="amount10" name="donation_amount" value="10">
                                    <label for="amount10">$10</label>
                                </div>
                                <div class="amount-option">
                                    <input class="btn btn-custom" required type="radio" id="amount25" name="donation_amount" value="25">
                                    <label for="amount25">$25</label>
                                </div>
                                <div class="amount-option">
                                    <input class="btn btn-custom" required type="radio" id="amount50" name="donation_amount" value="50" checked>
                                    <label for="amount50">$50</label>
                                </div>
                                <div class="amount-option">
                                    <input class="btn btn-custom" required type="radio" id="amount100" name="donation_amount" value="100">
                                    <label for="amount100">$100</label>
                                </div>
                                <div class="amount-option">
                                    <input class="btn btn-custom" required type="radio" id="amount250" name="donation_amount" value="250">
                                    <label for="amount250">$250</label>
                                </div>
                            </div>
                            
                            <div class="custom-amount">
                                <input type="number" class="form-control"  name="custom_amount" placeholder="Or enter custom amount" min="1" id="customAmount">
                            </div>
                            
                            <div class="control-group mt-3 text-black">
                                <select class="form-control" required name="payment_method" required>
                                    <option value="" disabled selected>Select Payment Method</option>
                                    <option value="credit_card">Credit Card</option>
                                    <option value="paypal">PayPal</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="mobile_money">Mobile Money</option>
                                </select>
                            </div>
                            
                            <div>
                                <button class="btn btn-donate" type="submit">
                                    <i class="fas fa-heart me-2"></i>Donate Now
                                </button>
                            </div>
                            
                            <div class="security-note">
                                <i style="color:white;" class="fas fa-lock"></i>Your donation is secure and encrypted
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Donate End -->

  <!-- Footer Start -->
        <div class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-contact">
                            <h2>Our Head Office</h2>
                            <p><i class="fa fa-map-marker-alt"></i>Huye Distict</p>
                            <p><i class="fa fa-phone-alt"></i>+250-787-691-062</p>
                            <p><i class="fa fa-envelope"></i>info@lafontaine.org</p>
                            <div class="footer-social">
                              
                                <a class="btn btn-custom" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-custom" href=""><i class="fab fa-instagram"></i></a>
                                <a class="btn btn-custom" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-link">
                            <h2>Popular Links</h2>
                             <a href="index.html">Home Page</a>
                            <a href="">About Us</a>
                            <a href="">Contact Us</a>
                            <a href="">Events</a>
                        </div>
                    </div>   
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-link">
                            <h2>Useful Links</h2>
                            <a href="">Privacy policy</a>
                            <a href="">Cookies</a>
                            <a href="">Help</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-newsletter">
                            <h2>Newsletter</h2>
                            <form>
                                <input class="form-control" placeholder="Email goes here">
                                <button class="btn btn-custom">Submit</button>
                                <label>Don't worry, we don't spam!</label>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container copyright">
                <div class="row">
                    <div class="col-md-6">
                        <p>&copy; <a href="#">La Fontaine</a>, All Right Reserved.</p>
                    </div>
                    <div class="col-md-6">
                        <p>Developed By <a href="https://lerony.netlify.app/" target="_blank">Lerony.co.RW</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer End -->
        
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
