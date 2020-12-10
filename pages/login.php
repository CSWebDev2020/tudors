<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to admin page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: admin.php");
    exit;
}

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";

        echo '<script>';
        echo 'console.log("line 41 Success")';
        echo '</script>';


        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirect user to admin page
                            header("location: admin.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                    echo '<script>';
                    echo 'console.log("line 74 Success")';
                    echo '</script>';
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                }
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
        <title>Tudor's Biscuit World | Login</title>
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
            <h1 class="mb-4" style="font-weight: 800;">ADMIN LOGIN</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="mb-3 <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                    <label class="form-label">USERNAME</label>
                    <input type="text" 
                    class="form-control"  
                    name="username"
                    placeholder="Username" 
                    value="<?php echo $username; ?>"
                    autocomplete="on"
                    required>
                    <span class="help-block"><?php echo $username_err; ?></span>
                </div>
                <div class="mb-3 <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                    <label class="form-label">PASSWORD</label>
                    <input type="password" 
                    name="password" 
                    class="form-control"
                    placeholder="Password..." 
                    value="<?php echo $password; ?>"
                    data-kwimpalastatus="alive"
                    autocomplete="off"
                    required>
                    <span class="help-block"><?php echo $password_err; ?></span>
                </div>
                <button type="submit" name="submit" class="btn btn-success" value="Login">LOGIN</button>
                <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
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


