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
</head>
<body>
<script src="webLogic.js"></script>
<script>
    function verify( form, name ) {
        var text = form.elements[ name ];

        if ((text.value != null) && (text.value != "")) {
            return confirm("Upload " + text.value + "?");
        }
        alert("Input cannot be empty.");
        return false;
    }

    function confirmDelete(file, map) {
        if (confirm("Really delete all words from database?")) {
            post(file, map);
        }
    }
</script>

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
<?php
if (!isset($_POST['password'])) {
    exit("No password retrieved from form submission.");
}

mysqli_report(MYSQLI_REPORT_ALL ^ MYSQLI_REPORT_STRICT);
@$db = mysqli_connect( 'localhost', 'wordsroot', $_POST['password'], 'mysql' );

if (gettype($db) == "boolean") {
    echo("<div id='Admin' class='tabContent'>
    <h3>Admin</h3><b>Incorrect Password</b><br><br>
    <a href='index.html'><button>Try again</button></a>
    </div><script>
        var admin = document.getElementById('admin');
        admin.click();
    </script>");
    die("<div id='Admin' class='tabContent'>
    <h3>Admin</h3><b>Incorrect Password</b>
    </div>");
}

if ($db->connect_errno) {
    echo "Connection failed.<br />";
}
else {
    $id = null;
    if (!isset($_POST['session-id'])) {
        do {
            $id = md5(microtime().$_SERVER['REMOTE_ADDR']);
        } while (isset($_SESSION[$id]));
    } else {
        $id = $_POST['session-id'];
    }
    
    
    $_SESSION[$id]['password'] = $_POST['password'];
    $db->close();
}
?>

<div id='Admin' class='tabContent'>
  <h3>Admin</h3>
  <form enctype="multipart/form-data" action="upload.php" method="post" onsubmit="return verify(this,'uploaded');">
    <?php
        echo '<input type="hidden" name="session-id" value="'.$id.'" />';
    ?>
    <p><b>Upload data</b></p>
    Filename <input type="file" name="uploaded" size="30" /><input type="submit" value="Upload" />
  </form>
  <p><b>Delete data</b></p>
  <?php
    $deleteStmt = "confirmDelete( 'delete.php', { 'session-id':'".$id."' })";
    $logoutStmt = "post( 'logout.php', { 'session-id':'".$id."' })";
    echo '<button onclick="'.$deleteStmt.'">Delete</button><br><br>
    <button onclick="'.$logoutStmt.'">Logout</button>';
  ?>
</div>


<script>
    var admin = document.getElementById("admin");
    admin.click();
</script>
</html>