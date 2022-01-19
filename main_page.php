<HTML>
  <HEAD>
    <TITLE> Main Page </TITLE>
    <link rel="stylesheet" href="css/main.css">

    <style> /* idk czemu ale jak to jest w css to nie działa*/

        /* Style the header */
        .header {
        padding: 80px;
        text-align: center;
        background: #1abc9c;
        color: white;
        }

        /* Increase the font size of the h1 element */
        .header h1 {
        font-size: 40px;
        }

        .footer {
          padding: 20px; /* Some padding */
          text-align: center; /* Center text*/
          background: #ddd; /* Grey background */
        }
    </style>

  </HEAD>
  <BODY>

    <div class="header">
      <h1>Biblioteka Publiczna</h1>
      <p>im. Ignacego Makowskiego i Joanny Dagil</p>
    </div>

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

    <FORM ACTION="katalog.php" METHOD="POST">
      <INPUT TYPE="HIDDEN" NAME="search" VALUE=""><BR><BR>
      <INPUT TYPE="SUBMIT" VALUE="Katalog">
    </FORM>

    <a href="logowanie.php">Zaloguj się</a>
    <a href="rankingi.php">Rankingi</a>
    <a href="katalog.php">Katalog</a>

    <div class="topnav">
      <a class="active" href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
    </div>


    <div class="footer">
      <h2>Footer</h2>
    </div>

  </BODY>
</HTML>
