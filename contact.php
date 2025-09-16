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


    <div class="navbar navbar-expand-lg navbar-dark">
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

                    <a href="join.php" class="nav-item nav-link">Join us</a>

                    <a href="contact.php" class="nav-item nav-link active">Contact</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Contact Us</h2>
                </div>
                <div class="col-12">
                    <a href="">Home</a>
                    <a href="">Contact</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->


    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <div class="section-header text-center">
                <p>Get In Touch</p>
                <h2>Nous sommes là pour transformer des vies, rejoignez-nous !</h2>
            </div>
            <div class="contact-img">
                <img src="img/contact_us.jpeg" alt="Image">
            </div>
                            <div class="contact-form">
                    <div id="success">
                        <?php
                        if (isset($success_message)) {
                            echo '<div class="alert alert-success">' . $success_message . '</div>';
                        }
                        ?>
                    </div>

                    <?php
                    // Check if form was submitted
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['send_message'])) {
                        // Validate and sanitize input data
                        $name = trim($_POST['name']);
                        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
                        $subject = trim($_POST['subject']);
                        $message = trim($_POST['message']);

                        // Validate required fields
                        $errors = [];

                        if (empty($name)) {
                            $errors['name'] = "Please enter your name";
                        } elseif (strlen($name) > 100) {
                            $errors['name'] = "Name must be less than 100 characters";
                        }

                        if (empty($email)) {
                            $errors['email'] = "Please enter your email";
                        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $errors['email'] = "Please enter a valid email";
                        } elseif (strlen($email) > 100) {
                            $errors['email'] = "Email must be less than 100 characters";
                        }

                        if (empty($subject)) {
                            $errors['subject'] = "Please enter a subject";
                        } elseif (strlen($subject) > 255) {
                            $errors['subject'] = "Subject must be less than 255 characters";
                        }

                        if (empty($message)) {
                            $errors['message'] = "Please enter your message";
                        }

                        if (empty($errors)) {
                            // Prepare and bind
                            $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("ssss", $name, $email, $subject, $message);

                            // Execute the statement
                            if ($stmt->execute()) {
                                echo '<script>alert("Thank you for your message! We\'ll get back to you soon.");</script>';
                                // Clear form fields
                                $name = $email = $subject = $message = "";
                            } else {
                                $errors['general'] = "Error sending your message: " . $stmt->error;
                            }

                            $stmt->close();
                        }
                    }
                    ?>

                    <form name="sentMessage" method="POST" action="">
                        <div class="control-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required="required" 
                                   data-validation-required-message="Please enter your name" 
                                   value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" />
                            <p class="help-block text-danger">
                                <?php if (!empty($errors['name'])) { echo $errors['name']; } ?>
                            </p>
                        </div>
                        <div class="control-group">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required="required" 
                                   data-validation-required-message="Please enter your email" 
                                   value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" />
                            <p class="help-block text-danger">
                                <?php if (!empty($errors['email'])) { echo $errors['email']; } ?>
                            </p>
                        </div>
                        <div class="control-group">
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Your subject" required="required" 
                                   data-validation-required-message="Please enter a subject" 
                                   value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>" />
                            <p class="help-block text-danger">
                                <?php if (!empty($errors['subject'])) { echo $errors['subject']; } ?>
                            </p>
                        </div>
                        <div class="control-group">
                            <textarea class="form-control" id="message" name="message" placeholder="Kindly place your Message here" 
                                      required="required" data-validation-required-message="Please enter your message"><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                            <p class="help-block text-danger">
                                <?php if (!empty($errors['message'])) { echo $errors['message']; } ?>
                            </p>
                        </div>
                        <div>
                            <button class="btn btn-custom" name="send_message" type="submit" >Send Message</button>
                        </div>
                    </form>
                </div>
        </div>
    </div>
    <!-- Contact End -->

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