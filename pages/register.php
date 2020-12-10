<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";

        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();

                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if($stmt = $link->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
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
<html lang="en">
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
    <header>
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
        <h1 class="mb-4" style="font-weight: 800;">SIGN UP</h1>
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
                <small class="text-danger"><?php echo $username_err; ?></small>
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
                <small class="text-danger"><?php echo $password_err; ?></small>
            </div>
            <button type="submit" name="submit" class="btn btn-success" value="Submit">SIGN UP</button>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
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
