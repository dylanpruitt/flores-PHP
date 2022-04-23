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
  <a href='index.html'>
      <button class="tabLinks" onclick="post( event, 'Home' )">Home</button>
  </a>
  <button id = "A_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'A'})">A</button>
  <button id = "B_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'B'})">B</button>
  <button id = "C_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'C'})">C</button>
  <button id = "D_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'D'})">D</button>
  <button id = "E_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'E'})">E</button>
  <button id = "F_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'F'})">F</button>
  <button id = "G_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'G'})">G</button>
  <button id = "H_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'H'})">H</button>
  <button id = "I_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'I'})">I</button>
  <button id = "J_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'J'})">J</button>
  <button id = "K_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'K'})">K</button>
  <button id = "L_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'L'})">L</button>
  <button id = "M_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'M'})">M</button>
  <button id = "N_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'N'})">N</button>
  <button id = "O_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'O'})">O</button>
  <button id = "P_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'P'})">P</button>
  <button id = "Q_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'Q'})">Q</button>
  <button id = "R_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'R'})">R</button>
  <button id = "S_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'S'})">S</button>
  <button id = "T_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'T'})">T</button>
  <button id = "U_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'U'})">U</button>
  <button id = "V_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'V'})">V</button>
  <button id = "X_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'W'})">W</button>
  <button id = "Y_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'X'})">X</button>
  <button id = "W_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'Y'})">Y</button>
  <button id = "Z_button" class="tabLinks" onclick="post( 'dictionary.php', {'letter':'Z'})">Z</button>
  <button id="admin" class="tabLinks" onclick="openTab( event, 'Admin'  )">Admin</button>
  </form>
</div>

<div id="alphaTab">
    <table class='words'>
    <?php
        $password = 'anonymous';
        if (!isset($_POST['letter'])) {
            die("Letter unknown");
        }
        $letter = $_POST['letter'];

        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $db = mysqli_connect( 'localhost', 'wordsuser', $password, 'mysql' );

        if (gettype($db) == "boolean") {
            exit("<b>Incorrect Password</b>");
        }

        if ($db->connect_errno) {
            echo "Connection failed.<br />";
        }
        else {
            $select = "select * from words.wordsTable where entry like '$letter%'";
            $result = $db->query( $select );
            $rows = $result->num_rows;
            echo "Number of entries: <b>".number_format($rows)."</b>";

            if ($rows == 0) {
            // no records found
            }
            else {
            // 1+ records found
            for ($i=0; $i<$rows; $i++) {
            $row  = $result->fetch_assoc();
            $word = $row['entry'];
            echo "<tr class='highlight'><td text-align='right'>".($i + 1)."</td><td align='left'>$word</td></tr>";
            
            }
            }
            $db->close();
        }
    ?>

    </table>
</div>

<div id='Admin' class='tabContent'>
  <h3>Admin</h3>
  <form id='password' action="password.php" method="post" onsubmit="return verify(this,'password');">
     <p>
     Password
     <input type="password" name="password" />
     <input type="submit"   value="Login" />
     </p>
  </form>
</div>
<?php
    $buttonID = $letter.'_button';
    echo "<script>
    $(document).ready(function() {
        var   tabDIV   = document.getElementById('alphaTab');
        const alphaTab = '$letter';
       $('body').append(
            $(tabDIV)
                .attr('id', alphaTab)
                .addClass('tabContent')
                .prepend('<h3/><b>' + alphaTab + '</b></h3><hr>')
            );
    
        var aButton = {currentTarget: document.getElementById('$buttonID')};
        openTab(aButton, '$letter');
    });
    </script>" 
?>
</html>