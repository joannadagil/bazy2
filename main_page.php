<HTML>
  <HEAD>
    <TITLE> Main Page </TITLE>
    <link rel="stylesheet" href="css/main.css">
  </HEAD>
  <BODY>

    <?PHP
      session_start();
      $_SESSION['LOGIN'] = $_POST['LOGN'];
      $_SESSION['PASS'] = $_POST['PASW'];
      $_SESSION['USER'] = $_POST['USER'];
      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
    	  echo "oci_connect failed\n";
    	  $e = oci_error();
    	  echo $e['message'];
      }
    ?>

    <div class="header">
      <h1>Biblioteka Publiczna</h1>
      <p>im. Ignacego Makowskiego i Joanny Dagil</p>
    </div>

    <div class="topnav">
      <a class="active" href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </div>

    <div class="mainnav">

      <form ACTION="katalog.php" METHOD="POST">
        <input class="mainnav" TYPE="HIDDEN" NAME="search" VALUE=""><BR><BR>
        <input class="mainnav_input" TYPE="SUBMIT" VALUE="Katalog">
      </form>

      <form ACTION="rankingi.php" METHOD="POST">
        <input class="mainnav_input" TYPE="SUBMIT" VALUE="Rankingi">
      </form>

      <form ACTION="login_library.html" METHOD="POST">
        <input class="mainnav_input" TYPE="SUBMIT" VALUE="Logowanie">
      </form>

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
