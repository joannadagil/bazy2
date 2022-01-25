<HTML>
  <HEAD>
    <TITLE> Main Page </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <style>
      /* -------------------- main navi -------------------- */
      .mainnav {
        padding: 20px 50px;
      }

      .mainnav input[type=submit] {
        padding: 30px;
        background: #e9e9e9;
        border: none;
        font-size: 30px;
        width: 100%;
      }

      .mainnav input[type=submit]:hover {
        padding: 30px;
        background: #ccc;
        border: none;
        font-size: 30px;
        width: 100%;
      }
    </style>
  </HEAD>
  <BODY>

    <?PHP
      session_start();
      $_SESSION['LOGIN'] = 'scott';
      $_SESSION['PASS'] = 'tiger';
      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
    	  echo "oci_connect failed\n";
    	  $e = oci_error();
    	  echo $e['message'];
      }
      $NAME = $_POST['NAME'];
      $BIRTH = $_POST['BIRTHDATE'];

      $stmt = oci_parse($conn, "SELECT MAX(MID) AS MAX_ID FROM member");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
      $row = oci_fetch_array($stmt, OCI_BOTH);
      $ID = $row[MAX_ID];

      $stmt2 = oci_parse($conn, "INSERT INTO MEMBER VALUES (".$ID.",'".$NAME."',DATE '".$BIRTH."');");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($stmt2, OCI_NO_AUTO_COMMIT);
      oci_commit($conn);
    ?>

    <div class="header">
      <h1>Rejestracja</h1>
    </div>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </div>


    <H2> Witaj, <?php echo $NAME ?></H2>

    <H2> Twój numer użytkownika to <?php echo $ID ?> </H2>



    <div class="container">
      <FORM ACTION="main_page.php" METHOD="POST">
        <input type="hidden" name="USER" value="<?php $ID ?>">    
        <INPUT TYPE="SUBMIT" VALUE="Kontynuuj">
      </FORM>
    </div>

    <div class="footer">
      <p style="text-align:left;">
        Biblioteka Publiczna im. Ignacego Makowskiego i Joanny Dagil
        <span style="float:right;">
        All rights reserved
        </span>
      </p>
    </div>

  </BODY>
</HTML>
