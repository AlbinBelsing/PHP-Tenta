<?php 
    function startSession() {
        session_start();
        if(isset($_POST["btnBegin"])) {
            if(!isset($_SESSION["totalamount"]) || !isset($_SESSION["nbrofinteractions"])) {
                $_SESSION["totalamount"] = 0;
                $_SESSION["nbrofinteractions"] = 0;
            }
        }
    }

    function removeSession() {
        session_unset();
        if(ini_get("session.use_cookies")) {
            $sessionCookieData = session_get_cookie_params();
            $path = $sessionCookieData["path"];
			$domain = $sessionCookieData["domain"];
			$secure = $sessionCookieData["secure"];
			$httponly = $sessionCookieData["httponly"];

            setcookie( session_name(), "", time() - 3600, $path, $domain, $secure, $httponly );
        }
        session_destroy();
    }

    function browserload() {
        if(!isset ($_POST["btnBegin"]) && !isset($_POST["btnEnd"]) && !isset($_POST["btnAdd"]) && !isset($_POST["btnSub"] ) ) {
            return "Tryck på <strong>Begin</strong> för att starta webbapplikationen";
        }
    }
    
    function executeFunctions(){
        return browserload() . startSession() . endSession() . myInc() . myDec();
    }

    function infoToUser($totalamount, $nbrofinteractions) {
        return "totalamount: $totalamount nbrofinteractions: $nbrofinteractions";
    }

    function endSession() {
        if(isset($_POST["btnEnd"])) {
            if(isset($_SESSION["totalamount"]) || isset($_SESSION["nbrofinteractions"])) {
                removeSession();
            }
        }
    }

    function myInc(){
        if(isset($_POST["btnAdd"])){
           if(isset($_SESSION["totalamount"]) && isset($_SESSION["nbrofinteractions"])){

            $totalamount = ++$_SESSION["totalamount"];
            $nbrofinteractions = ++$_SESSION["nbrofinteractions"];

            return infoToUser($totalamount, $nbrofinteractions);

           } else {
            return "Börja med att klicka på Begin!";
           }
        }
    }
    
    function myDec() {
        if(isset($_POST["btnSub"])) {
            if(isset($_SESSION["totalamount"]) && isset($_SESSION["nbrofinteractions"])){
               
                $totalamount = --$_SESSION["totalamount"];
                $nbrofinteractions = ++$_SESSION["nbrofinteractions"];

                return infoToUser($totalamount, $nbrofinteractions);

            } else {
                return "Börja med att klicka Begin";
            }
        }
    }
    
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <title>Uppgift 1.</title>
        </head>
        <body>
            <?php echo("<p>" . executeFunctions() . "</p>"); ?>
            <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <input type="submit" name="btnBegin" value="Begin">
                    <input type="submit" name="btnAdd" value="Add">
                    <input type="submit" name="btnSub" value="Sub">
                    <input type="submit" name="btnEnd" value="End">
                </div>
            </form>
        </body>
    </html>


    

   
    
    
