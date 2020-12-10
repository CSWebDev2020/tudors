<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}


// Include config file
require_once "config.php";
//Create
// Define variables and initialize with empty values
$url="";
$url_err="";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
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
        // Prepare an insert statement
        $sql = "INSERT INTO memes (url) VALUES (?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_url);
            
            // Set parameters
            $param_url = $url;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("Refresh:0");
                //window.location.reload()
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    //mysqli_close($link);
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
        <title>Tudor's Biscuit World | Admin</title>
        <link rel="canonical" href="/">
        <link rel="shortcut icon" href="../favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../styles/custom.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>
        <noscript>Your browser does not support JavaScript!</noscript>
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
            <h1 class="mb-5" style="font-weight: 800;">COMPANY MEME TREASURY</h1>
            <br/>
            <hr/>
            <h2 class="mr-auto">Hi, 
                <b><?php echo htmlspecialchars($_SESSION["username"]); ?>
                </b>
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-patch-check-fll" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984a.5.5 0 0 0-.708-.708L7 8.793 5.854 7.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                </svg>
            </h2>
            <div class="d-flex flex-row justify-content-between align-items-center w-100">
                <img src="https://avatars3.githubusercontent.com/u/73842122?s=400&u=e280aa7bcfde62de536011414927f977f51f71f1&v=4" alt="Avatar" 
                class="rounded-circle img-thumbnail mr-5">
                <div>
                    <a href="reset-password.php" class="btn btn-outline-dark">Reset Your Password</a>
                    <a href="logout.php" class="btn btn-outline-danger">Sign Out</a>
                </div>
            </div>
            <form 
                action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
                class="d-flex flex-row align-items-center justify-content-center mt-5 mx-auto">
                <div class="form-group mx-sm-3 <?php echo (!empty($url_err)) ? 'has-error' : ''; ?>">
                    <input type="url" name="url"
                    class="form-control" 
                    placeholder="paste meme image url"
                    value="<?php echo $url; ?>"
                    >
                    <span class="text-danger"><?php echo $url_err;?></span>
                </div>
                <button type="submit" class="btn btn-primary">
                    <b>
                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-plus-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                        </svg>
                    </b>
                </button>
            </form>
            <small class="my-5">Click on a meme to view it in fullScreen</small>
            
            <section class="company-memes">
                <?php
                    // Include config file
                    require_once "config.php";
                    // Attempt select query execution
                    $sql = "SELECT * FROM memes ORDER BY id DESC";
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<ul>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<li>";
                                        echo '<a href="' . $row["url"] . '"data-fancybox data-fancybox="gallery">';
                                            echo "<img src='" . $row['url'] . "'alt='' loading='lazy'>";
                                        echo "</a>";
                                        echo "<div>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Meme' data-toggle='tooltip'>
                                                        <svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-pencil-square' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                                            <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                                                            <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                                                        </svg>
                                                </a>"
                                            ;
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Meme' data-toggle='tooltip'>
                                                    <svg width='1em' height='1em' viewBox='0 0 16 16' class='bi bi-x-circle-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                                        <path fill-rule='evenodd' d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z'/>
                                                    </svg>
                                                </a>"
                                            ;
                                        echo "</div>";
                                    echo "</li>";
                                };                          
                            echo "</ul>";
                            mysqli_free_result($result);
                        } else{
                            echo "<p ><em><b>Wow, such empty. No memes yet :(</b></em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                ?>
            </section>
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
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>       
        <script>
            $("[data-fancybox="gallery"]").fancybox({
                buttons : [ 
                    'slideShow',
                    'fullScreen',
                    'close'
                ],
                margin: [20, 60, 20, 60]
            });
        </script>
    </body>
</html>


