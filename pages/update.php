<?php
// Include config file
require_once "config.php";
 
$url="";
$url_err="";

// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];

    // Validate url
    $meme_url = trim($_POST["url"]);
    if(empty($meme_url)){
        $url_err = "Please enter a url.";
    } elseif(!filter_var($meme_url, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/([a-z\-_0-9\/\:\.]*\.(jpg|jpeg|png|gif|webp))/i")))){
        $url_err = "Please enter a valid image url.";
    } else{
        $url = $meme_url;
    }
    
    // Check input errors before inserting in database
    if(empty($url_err)){
        // Prepare an update statement
        $sql = "UPDATE memes SET url=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_url, $param_id);
            
            // Set parameters
            $param_url = $url;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: admin.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM memes WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $urkl = $row["url"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: admin.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: admin.php");
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
        <title>Tudor's Biscuit World | Update Meme</title>
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
        <h1 class="mb-5" style="font-weight: 800;">UPDATE COMPANY MEME</h1>
        <br/>
        <form 
            class="d-flex flex-row align-items-center justify-content-center mt-5 mx-auto"
            action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
            <div class="form-group mx-sm-3 <?php echo (!empty($url_err)) ? 'has-error' : ''; ?>">
                        <input type="url" name="url"
                        class="form-control" 
                        placeholder="paste meme image url replacement"
                        value="<?php echo $url; ?>"
                        >
                        <span class="text-danger"><?php echo $url_err;?></span>
            </div>
            <div>
                <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                <p>
                    <input type="submit" value="Update" class="btn btn-success">
                    <a href="admin.php" class="btn btn-outline-dark">Cancel</a>
                    <input type="hidden" name="id" value="<?php echo $id; ?>"/>
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