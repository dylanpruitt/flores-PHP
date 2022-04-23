<?php
    if(!session_start()) {
        die("Could not start session");
    }
?>
<html>
<head>
<title>Words Galore!</title>
<style type="text/css">
@import url(iwords.css);
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>
<body>
<script>
    function verify( form, name ) {
        var text = form.elements[ name ];

        if ((text.value != null) && (text.value != "")) {
            return true;
        }
        alert("Input cannot be empty.");
        return false;
    }
</script>
<script src="webLogic.js"></script>

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
  <button id="admin" class="tabLinks" onclick="openTab( event, 'Admin'  )">Admin</button>
  </form>
</div>

<div id='Admin' class='tabContent'>
  <h3>Admin</h3>
  <?php
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
        echo "Connection failed.<br />";
    }
    else {
        $select = "delete from words.wordsTable";
        $result = $db->query( $select );
        echo "<b>All data deleted.</b>";
        $db->close();
    }

    $returnStmt = "post( 'password.php', { 'session-id':'".$id."', 'password':'".$_SESSION[$id]['password']."' })";
    echo '<br><br><button onclick="'.$returnStmt.'">Return to admin</button>';
  ?>
</div>


<script>
$(document).ready(function() {
    const alphaTabs = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    
    for (let i = 0; i < alphaTabs.length; i++) {
        $('body').append(
            $('<div/>')
                .attr("id", alphaTabs[i])
                .addClass("tabContent")
                .append("<h3/><b>" + alphaTabs[i] + "</b></h3>")
                );
    }
});

var admin = document.getElementById("admin");
admin.click();
</script>
</html>