<?php
include "connection.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>La Fontaine Community Center - Donate</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/logo.png" rel="icon">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap & Icon Libraries -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #09610d;
            --secondary-color: #f7cc2d;
            --light-color: #f9f9f9;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        
        /* Header & Navigation */
        .top-bar {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 0;
        }
        
        .top-bar .text {
            display: inline-block;
            margin-right: 20px;
        }
        
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand img {
            height: 50px;
        }
        
        .nav-item {
            margin: 0 5px;
        }
        
        .nav-item .nav-link {
            color: #333;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .nav-item .nav-link:hover, 
        .nav-item .nav-link.active {
            color: var(--primary-color);
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('img/donate-bg.jpg');
            background-size: cover;
            background-position: center;
            padding: 80px 0;
            color: white;
            text-align: center;
        }
        
        .page-header h2 {
            font-size: 5.5rem;
            font-weight: 700;
            color:#f7cc2d;
        }
        
        .page-header a {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        /* Donation Section */
        .donate-container {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('img/donate.jpeg');
            background-size: cover;
            background-attachment: fixed;
            padding: 60px 0;
            color: white;
            border-radius: 10px;
            margin: 30px auto;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        
        .donate-content h2 {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 20px;
        }
        
        .section-header p {
            color: var(--secondary-color);
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .donate-text {
            font-size: 1.1rem;
            line-height: 1.7;
            padding: 15px 10px;
            margin-bottom: 25px;
        }
        
        .donate-form {
            background: #09610d;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .form-control {
            padding: 12px 15px;
            height: 50px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(9, 97, 13, 0.25);
        }
        
        .amount-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }
        
        .amount-option {
            flex: 1;
            min-width: 100px;
        }
        
        .amount-option input[type="radio"] {
            display: none;
        }
        
        .amount-option label {
            display: block;
            padding: 12px;
            background: #f1f1f1;
            border: 2px solid transparent;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
            color: #333;
        }
        
        .amount-option input[type="radio"]:checked + label {
            background-color: var(--secondary-color);
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .custom-amount {
            margin-top: 15px;
        }
        
        .custom-amount input {
            border: 2px dashed var(--primary-color);
            text-align: center;
            font-weight: bold;
        }
        
        .btn-donate {
            background-color: var(--secondary-color);
            border: none;
            color: var(--primary-color);
            padding: 14px 28px;
            font-weight: 700;
            font-size: 18px;
            border-radius: 5px;
            width: 100%;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn-donate:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .security-note {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #666;
        }
        
        .security-note i {
            color: var(--primary-color);
            margin-right: 5px;
        }
        
        /* Footer */
        .footer {
            background: #09610d;
            color: #fff;
            padding: 60px 0 30px;
        }
        
        .footer h2 {
            color: var(--secondary-color);
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        .footer-contact p {
            margin-bottom: 10px;
        }
        
        .footer-social a {
            display: inline-block;
            margin-right: 10px;
            width: 35px;
            height: 35px;
            line-height: 35px;
            text-align: center;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            transition: all 0.3s;
        }
        
        .footer-social a:hover {
            background: var(--secondary-color);
            color: var(--primary-color);
        }
        
        .footer-link a {
            display: block;
            margin-bottom: 10px;
            color: #bbb;
            transition: all 0.3s;
        }
        
        .footer-link a:hover {
            color: var(--secondary-color);
            text-decoration: none;
        }
        
        .footer-newsletter .form-control {
            background: #222;
            border: 1px solid #444;
            color: #fff;
        }
        
        .footer-newsletter .btn-custom {
            background: var(--primary-color);
            color: white;
            width: 100%;
            margin-top: 10px;
        }
        
        .copyright {
            border-top: 1px solid #222;
            padding-top: 20px;
            margin-top: 30px;
            color: #bbb;
        }
        
        .copyright a {
            color: var(--secondary-color);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .amount-option {
                min-width: 80px;
            }
            
            .donate-container {
                margin: 15px auto;
                padding: 30px 0;
            }
            
            .donate-form {
                padding: 20px;
            }
            
            .page-header {
                padding: 50px 0;
            }
        }
    </style>
</head>

<body>        
    <!-- Top Bar -->
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

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand"><img src="img/logo.png" alt="La Fontaine Community Center"></a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="about.php" class="nav-item nav-link">About</a>
                    <a href="donate.php" class="nav-item nav-link active">Donate</a> 
                    <a href="event.php" class="nav-item nav-link">Events</a>
                    <a href="team.php" class="nav-item nav-link">Team</a>
                    <a href="join.php" class="nav-item nav-link">Join us</a>
                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Donate Now</h2>
                </div>
                <div class="col-12">
                    <a href="index.php">Home</a>
                    <a href="donate.php">Donate</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Donation Section -->
    <div class="container">
        <div class="donate-container">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <div class="donate-content">
                        <div class="section-header">
                            <p>Donate Now</p>
                            <h2>Let's donate to people in need so they can have a better life</h2>
                        </div>
                        <div class="donate-text">
                            <p>Your contribution will make a tangible difference in the lives of children and youth,
                               empowering them to become the driving force behind a more compassionate, creative, and equitable world.</p>
                            <p>Every donation, no matter the size, helps us continue our important work. Thank you for your generosity!</p>
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
                            
                            <h5 class="mb-3" style="color: #333;">Select Donation Amount</h5>
                            <div class="amount-options">
                                <div class="amount-option">
                                    <input required type="radio" id="amount10" name="donation_amount" value="10">
                                    <label for="amount10">$10</label>
                                </div>
                                <div class="amount-option">
                                    <input required type="radio" id="amount25" name="donation_amount" value="25">
                                    <label for="amount25">$25</label>
                                </div>
                                <div class="amount-option">
                                    <input required type="radio" id="amount50" name="donation_amount" value="50" checked>
                                    <label for="amount50">$50</label>
                                </div>
                                <div class="amount-option">
                                    <input required type="radio" id="amount100" name="donation_amount" value="100">
                                    <label for="amount100">$100</label>
                                </div>
                                <div class="amount-option">
                                    <input required type="radio" id="amount250" name="donation_amount" value="250">
                                    <label for="amount250">$250</label>
                                </div>
                            </div>
                            
                            <div class="custom-amount">
                                <input type="number" class="form-control"  name="custom_amount" placeholder="Or enter custom amount" min="1" id="customAmount">
                            </div>
                            
                            <div class="control-group mt-3">
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
                                <i class="fas fa-lock"></i>Your donation is secure and encrypted
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <?php include "footer.php" ?>
    <!-- Back to top button -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
    
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const donationForm = document.getElementById('donationForm');
            const customAmountInput = document.getElementById('customAmount');
            const radioButtons = document.querySelectorAll('input[name="donation_amount"]');
            
            // Handle custom amount input
            customAmountInput.addEventListener('focus', function() {
                radioButtons.forEach(radio => {
                    radio.checked = false;
                });
            });
            
            // When a radio button is selected, clear custom amount
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    customAmountInput.value = '';
                });
            });
            
            // Form submission
            donationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Validate amount selection
                let amount = 0;
                let selectedRadio = document.querySelector('input[name="donation_amount"]:checked');
                
                if (selectedRadio) {
                    amount = selectedRadio.value;
                } else if (customAmountInput.value && customAmountInput.value > 0) {
                    amount = customAmountInput.value;
                } else {
                    alert('Please select or enter a donation amount.');
                    return;
                }
                
                // Validate payment method
                const paymentMethod = document.querySelector('select[name="payment_method"]');
                if (!paymentMethod.value) {
                    alert('Please select a payment method.');
                    return;
                }
                
                // In a real application, you would process the form data here
                // and send it to your server for database storage
                
                alert(`Thank you for your donation of $${amount}! You will be redirected to payment processing.`);
                // donationForm.submit(); // Uncomment in live environment
            });
            
            // Back to top button
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 100) {
                    document.querySelector('.back-to-top').style.display = 'block';
                } else {
                    document.querySelector('.back-to-top').style.display = 'none';
                }
            });
            
            document.querySelector('.back-to-top').addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({top: 0, behavior: 'smooth'});
            });
        });
    </script>
</body>
    </html>