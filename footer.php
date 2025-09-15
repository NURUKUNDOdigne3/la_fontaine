<?php
include_once 'connection.php'; ?>

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
                    <a href="index.php">Home Page</a>
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
                  <?php
                  if(isset($_POST['submit'])){
                    
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the connection is valid
    if (!$conn) {
        die("Database connection not established.");
    }

    // Validate and sanitize email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Prepare the statement
        $stmt = $conn->prepare("INSERT INTO newsletter_subscriptions (email) VALUES (?)");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }

        // Bind parameters and execute
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            echo "Subscription successful!";
        } else {
            // Check for duplicate email error (1062 is the error code for duplicate entry)
            if ($stmt->errno == 1062) {
                echo "This email is already subscribed.";
            } else {
                echo "Error: " . htmlspecialchars($stmt->error);
            }
        }
        $stmt->close();
    } else {
        echo "Please enter a valid email address.";
    }
}}
?>
                    <form method="POST">
                        <input class="form-control" name="email" placeholder="Email goes here" type="email" required>
                        <button class="btn btn-custom" name="submit" type="submit">Submit</button>
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