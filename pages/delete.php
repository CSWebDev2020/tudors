<?php
// Process delete operation after confirmation
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Include config file
    require_once "config.php";
    
    // Prepare a delete statement
    $sql = "DELETE FROM memes WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_POST["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            // Records deleted successfully. Redirect to landing page
            header("location: admin.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        
        
        echo '<script>';
        echo 'console.log("Error deleting image, redirecting to admin page!")';
        echo '</script>';
        header("location: login.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Colton,Elsa,Solomon,Victor">
        <meta name="description" content="Order drive-thru or delivery for food that's served fresh-made. See Tudor's latest deals, featured menu items & more.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#FFFFFF">
        <meta name="keywords" content="Restaurant, Tudor's, Tudor's Biscuit World">
        <title>Tudor's Biscuit World | Delete Image</title>
        <link rel="canonical" href="/">
        <link rel="shortcut icon" href="../favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../styles/custom.css">
</head>
<body>
    <header >
        <nav class="navbar navbar-expand-md">
            <div class="container-fluid">
                <a class="navbar-brand " href="/">
                    <img src="../images/tudors-mobile-logo.png" alt="logo" width= "85px"/>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <img src="../Assets/menu.svg" width="30px">
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <div class="navbar-nav ml-auto">
                        <a class="nav_link mr-3" href="../index.html#menu">Menu</a>
                        <a class="nav_link find_tudors mr-3" href="locations.html">
                            <img src="../Assets/pin.svg" width= "25px"/>
                            Find a Tudor's
                        </a>
                        <a class="nav_link grubhub_link" href="https://www.grubhub.com/restaurant/tudors-biscuit-world-3071-university-avenue-morgantown/481069" target="_blank">
                            <img src="../Assets/take-away.svg" width= "35px"/>
                            ORDER PICKUP / DELIVERY 
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <h1 class="mb-5" style="font-weight: 800;">DELETE COMPANY MEME?</h1>
        <br/>
        <hr/>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="alert alert-danger">
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                <p>Are you sure you want to delete this meme?</p><br>
                <p>
                    <input type="submit" value="Yes" class="btn btn-danger">
                    <a href="admin.php" class="btn btn-dark">No</a>
                </p>
            </div>
        </form>
    </main>
    <footer >
        <div class="footer_wrapper">
            <div>
                <a href="../Assets/TudorsNutritionQuickLoad.pdf" target="_blank">
                Nutrition 
                </a>
                <br/>
                <br/> 
                <a href="../pages/franchise.html">
                Franchise 
                </a>
                <br/>
                <br/>
                <a href="../pages/employment.html">
                Employment 
                </a>
                <br/>
                <br/>
                <a href="../pages/contact.html">
                Contact
                </a>
            </div>
            <div class="footer_right">
                <p>
                    © 2020 Tudor's Biscuit World 
                    <br/>
                    <br/>
                    P.O. Box 3603
                    <br/>
                    Charleston, WV 25336
                    <br/>
                    (304) 343-4026
                    <br/>
                    <br/>
                    *Not all items available at all locations.
                </p>
            </div> 
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js" async></script>
</body>
</html>