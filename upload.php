<?php
    if(!session_start()) {
        die("Could not start session");
    }
    ini_set('max_execution_time', 0);
?>
<html>
<title>Words Galore!</title>
<style type="text/css">
@import url(iwords.css);
</style>
<script src="webLogic.js"></script>
<body>
<div class="tab">
  <button class="tabLinks" onclick="openTab( event, 'Home' )">Home</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'A'})">A</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'B'})">B</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'C'})">C</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'D'})">D</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'E'})">E</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'F'})">F</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'G'})">G</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'H'})">H</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'I'})">I</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'J'})">J</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'K'})">K</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'L'})">L</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'M'})">M</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'N'})">N</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'O'})">O</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'P'})">P</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'Q'})">Q</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'R'})">R</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'S'})">S</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'T'})">T</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'U'})">U</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'V'})">V</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'W'})">W</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'X'})">X</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'Y'})">Y</button>
  <button class="tabLinks" onclick="post( 'dictionary.php', {'letter':'Z'})">Z</button>
  <button class="tabLinks" id="admin" onclick="openTab( event, 'Admin'  )">Admin</button>
  </form>
</div>

<div id='Home' class='tabContent'>
  <h3>Words Galore!</h3>
  <p>Welcome to Words Galore! where you can read, search and upload words from a text file.</p>
</div>

<div id='Admin' class='tabContent'>
  <h3>Admin</h3>
  <b>Uploading data</b><br>
<?php

if(!isset($_POST["session-id"])) {
    die("Session ID not recieved");
}

$okay = true;
if ($_FILES[ 'uploaded' ][ 'error' ] > 0) {
    echo 'A problem was detected:<br/>';
    switch ($_FILES[ 'uploaded' ][ 'error' ]) {
    case 1: echo '* File exceeded maximum size allowed by server.<br/>'; break;
    case 2: echo '* File exceeded maximum size allowed by application.<br/>'; break;
    case 3: echo '* File could not be fully uploaded.<br/>'; break;
    case 4: echo '* File was not uploaded.<br/>';
    }
    $okay = false;
    }
if ($okay && $_FILES[ 'uploaded' ][ 'type' ] != 'text/plain') {
    echo 'A problem was detected:<br/>';
    echo '* File is not a text file.<br/>';
    $okay = false;
    }
$filename = 'file.txt';
if ($okay) {
    if (is_uploaded_file($_FILES[ 'uploaded' ][ 'tmp_name' ])) {
        if (!move_uploaded_file($_FILES[ 'uploaded' ][ 'tmp_name' ], $filename)) {
            echo 'A problem was detected:</br>';
            echo '* Could not copy file to final destination.<br/>';
            $okay = false;
        }
    }
    else {
        echo 'A problem was detected:<br/>';
        echo '* File to copy is not an uploaded file.<br/>';
        $okay = false;
    }
}

function processUpload($filename) {
    $id = $_POST["session-id"];
    if (!isset($_SESSION[$id]['password'])) {
        exit("PASSWORD NOT SET FOR SESSION!!!");
    }

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $db = mysqli_connect( 'localhost', 'wordsroot', $_SESSION[$id]['password'], 'mysql' );

    if (gettype($db) == "boolean") {
        exit("<b>Incorrect Password</b>");
    }

    if ($db->connect_errno) {
        exit("Connection failed.<br />");
    }

    $file = fopen ( $filename, 'r' );
    $ready = false;
    $count = 0;
    while (!feof($file)) {
        $line = fgetcsv( $file, 999, "\n" );

        if ($line !== false) {
            if ($ready) {
                $word =  $db->real_escape_string($line[0]);
                $add = "insert into words.wordsTable (entry) values ('$word')";
                $db->query( $add );
                $count++;
            }
            if (strpos($line[0], "---") !== false) {
                $ready = true;
            }
        }    
    }
    echo '<br>Words added: '.number_format($count);
    $db->close();

    $returnStmt = "post( 'password.php', { 'session-id':'".$id."', 'password':'".$_SESSION[$id]['password']."' })";
    echo '<br><br><button onclick="'.$returnStmt.'">Return to admin</button>';
}

if ($okay) {
    processUpload($filename);
}

?>
</div>
</body>
<script>
    var admin = document.getElementById("admin");
    admin.click();
</script>   
</html>