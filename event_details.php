<?php
include "connection.php";

// Get event id from URL
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch single event
$event = null;
if ($event_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    $stmt->close();
}

// Fetch all events for Recent Post
$recent_events = [];
$res = $conn->query("SELECT id, event_title, event_picture FROM events ORDER BY date_event DESC LIMIT 5");
while ($row = $res->fetch_assoc()) {
    $recent_events[] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>La Fontaine Community Center</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/logo.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Top Bar and Navbar (unchanged) -->
    <!-- ... your existing top bar and navbar code ... -->

    <!-- Page Header Start -->
    <div class="page-header">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2>Event Details</h2>
                </div>
                <div class="col-12">
                    <a href="index.php">Home</a>
                    <a href="">Detail</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="single">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="single-content">
                        <?php if ($event): ?>
                            <img src="uploads/events/<?php echo htmlspecialchars($event['event_picture']); ?>" alt="Event Image" />
                            <h2><?php echo htmlspecialchars($event['event_title']); ?></h2>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($event['date_event']); ?></p>
                            <p><?php echo nl2br(htmlspecialchars($event['event_description'])); ?></p>
                        <?php else: ?>
                            <h2>Event not found</h2>
                            <p>The event you are looking for does not exist.</p>
                        <?php endif; ?>
                    </div>
                    <!-- Related Post, Comments, Comment Form (unchanged) -->
                    <!-- ... your existing related post, comments, and comment form code ... -->
                </div>
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <div class="search-widget">
                                <form>
                                    <input class="form-control" type="text" placeholder="Search Keyword">
                                    <button class="btn"><i class="fa fa-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <h2 class="widget-title">Recent Post</h2>
                            <div class="recent-post">
                                <?php foreach ($recent_events as $recent): ?>
                                    <div class="post-item">
                                        <div class="post-img">
                            <img src="uploads/events/<?php echo htmlspecialchars($event['event_picture']); ?>" alt="Event Image" />
                                        </div>
                                        <div class="post-text">
                                            <a href="event_details.php?id=<?php echo $recent['id']; ?>">
                                                <?php echo htmlspecialchars($recent['event_title']); ?>
                                            </a>
                                            <!-- Optionally add meta info here -->
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <!-- Sidebar images (unchanged) -->
                        <!-- ... your existing sidebar image widgets ... -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Post End-->

    <?php include "footer.php" ?>

    <!-- Back to top button and loader (unchanged) -->
    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
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
