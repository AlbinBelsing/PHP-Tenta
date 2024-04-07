<?php

function browserload(){
    if(!isset($_POST["btnStart"]) && !isset($_POST["btnStopp"]) && !isset($_POST["btnInc"]) && !isset($_POST["btnDec"])) {
        return "Klicka på Start för att starta webbapplikationen";
    }
    return "";
}

function start() {
    if(isset($_POST["btnStart"])) {
        if(!isset($_COOKIE["sumdif"]) && !isset($_COOKIE["nbr"])){
        setcookie("sumdif", "0", time()+3600);
        setcookie("nbr", "0", time()+3600);
        return "<p><strong>Kakorna skapades</strong></p>";
        } else {
            return "<p>Du tryckte på <strong>Start</strong> men kakorna är redan skapade";
        }
    }
    
}

function stopp() {
    if(isset($_POST["btnStopp"])) {
        if(isset($_COOKIE["sumdif"]) && isset($_COOKIE["nbr"])){
            setcookie("sumdif", "", time()-3600);
            setcookie("nbr", "", time()-3600);
            return "<p><strong>Kakorna togs bort</strong></p>";
        } else {
            return "<p>Du tryckte på <strong>Stopp</strong> men kakorna fanns inte</p>";
        }
    }
    return "";
}

function inc() {
    if(isset($_POST["btnInc"])) {
        if(isset($_COOKIE["sumdif"]) && isset($_COOKIE["nbr"])){
            $sumdif = $_COOKIE["sumdif"] + 1;
            $nbr = $_COOKIE["nbr"] + 1;
            setcookie("sumdif", $sumdif, time()+3600 );
            setcookie("nbr", $nbr, time()+3600 );
            return "<p>Kakor ökade: sumdiff = <strong>$sumdif</strong>, nbr = $nbr</p>";
        } else {
            return "<p>Du tryckte på <strong>Inc</strong> men kakorna fanns inte</p>";
        }
    }
    return "";
}

function dec() {
    if(isset($_POST["btnDec"])) {
        if(isset($_COOKIE["sumdif"]) && isset($_COOKIE["nbr"])){
            $sumdif = $_COOKIE["sumdif"] - 1;
            $nbr = $_COOKIE["nbr"] + 1;
            setcookie("sumdif", $sumdif, time()+3600 );
            setcookie("nbr", $nbr, time()+3600 );
            return "<p>Kakor minskade: sumdiff = <strong>$sumdif</strong>, nbr = $nbr</p>";
        } else {
            return "<p>Du tryckte på <strong>Dec</strong> men kakorna fanns inte</p>";
        }
    }
    return "";
}

function executeFunctions() {
    return browserload() . start() . stopp() . inc() . dec();
}

?>
<!DOCTYPE html>
<html lang="eng">
<head>
    <meta charset="utf-8">
    <title>Uppgift 1.</title>
</head>
<body>
    <?php echo("<p>" . executeFunctions() . "</p>"); ?>
    <form action="<?php echo($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <input type="submit" name="btnStart" value="Start">
            <input type="submit" name="btnInc" value="Inc">
            <input type="submit" name="btnDec" value="Dec">
            <input type="submit" name="btnStopp" value="Stopp">
        </div>
    </form>
</body>
</html>
