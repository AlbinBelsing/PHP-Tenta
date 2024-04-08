<?php
    function strongOutput1($p1, $p2) {
        return "<p>Du tenterar just nu <strong>$p2</strong> <i>($p1)</i></p>";
    }

    function stringOutput2(&$p1, &$p2){
        return "<p>Du tenterar just nu <strong>$p2</strong> <i>($p1)</i></p>";
        $p1 = "Systemimplementeringsteknik";
        $p2 = "ISBG11";
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8"/>
            <title>U2</title>
</head> 
    <body>
        <?php
            $p1 = 'ISGB11';
            $p2 = 'Systemimplementeringsteknik';
   
            echo(strongOutput1($p1, $p2));
            stringOutput2($p1, $p2);
            echo('<p>Nu innehåller variablerna följande värden: $p1 $p2!</p>');
            ?>
        </body>
    </html>
