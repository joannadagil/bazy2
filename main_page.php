<HTML>
  <HEAD>
    <TITLE> Main Page </TITLE>
    <link rel="stylesheet" href="css/main.css">

    <style> /* idk czemu ale jak to jest w css to nie działa, a navibar wciąz działa xd?*/
      body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      }

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
        <input TYPE="HIDDEN" NAME="search" VALUE=""><BR><BR>
        <input TYPE="SUBMIT" VALUE="Katalog">
      </form>

      <form ACTION="rankingi.php" METHOD="POST">
        <input TYPE="SUBMIT" VALUE="Rankingi">
      </form>

      <form ACTION="login_library.html" METHOD="POST">
        <input TYPE="SUBMIT" VALUE="Logowanie">
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
