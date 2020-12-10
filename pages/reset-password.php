<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm the password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $link->close();
}
?>

<!DOCTYPE html>
<html lang="en-us">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="author" content="Colton,Elsa,Solomon,Victor">
        <meta name="description" content="Order drive-thru or delivery for food that's served fresh-made. See Tudor's latest deals, featured menu items & more.">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#FFFFFF">
        <meta name="keywords" content="Restaurant, Tudor's, Tudor's Biscuit World">
        <title>Tudor's Biscuit World | Reset Password</title>
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
            <img src="https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260"
             class="img-fluid rounded img-center mb-3" 
             width="720"
             alt="Franchise header image">
            <br/>
            <h1 class="mb-4" style="font-weight: 800;">Reset Password</h1>
            <br/>
            <hr/>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                    <span class="help-block"><?php echo $new_password_err; ?></span>
                </div>
                <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                    <label>Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control">
                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a class="btn btn-link" href="welcome.php">Cancel</a>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous" async></script>
        <script src="../javascript/main.js" async></script>
    </body>
</html>




<h2></h2>
        
        