<HTML>
  <HEAD>
    <TITLE> Moje książki </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <style>
      table td input[type=submit] {
        border: none;
        cursor: pointer;
        width: 100%;
        background: #ccc;
        font-size: 17px;
        padding: 6px;
        float: center;
      }
      input[type=submit]:hover {
        background: #bbb;
      }
      table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        padding: 0px 15px;
      }
    </style>
  </HEAD>
  <BODY>
    <div class="header">
      <h1>Moje konto</h1>
    </div>
    <?PHP
      session_start();
      if (!isset($_SESSION['USER'])) {
        header("Location: login_library.html");
        exit;
      }
      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
        $e = oci_error();
        echo $e['message'];
      }
      $genre = 


      $stmt = oci_parse($conn,"SELECT BI.BIID AS ID, B.BTITLE AS TITL, D.DNAME AS NAM, D.DADDRESS AS ADRS, BR.BORROW AS BOR, BR.RETURN AS RET FROM BOOK B, BOOKINSTANCE BI, DEPARTMENT D , BORROWING BR WHERE BI.BOOK = B.BID AND BI.DEPARTMENT = D.DID AND BR.IDBOOK = BI.BIID AND BR.RETURN IS NOT NULL AND BR.IDLENDER = ".$_SESSION['USER']."ORDER BY BR.RETURN DESC FETCH FIRST 100 ROWS ONLY");
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="topnav">
      <a href="main_page.php">Strona główna</a>
      <a href="zwrot.php">Aktywne książki</a>
      <a href="historia_wypozyczen.php">Historia wypożyczeń</a>
      <a href="historia_ocen.php">Historia ocen</a>
      <a class="active" href="polecenie.php">Moja rekomendacja</a>
    </div>
    
    <H2> Rekomendacja specjalnie dla ciebie,</H2>
    <H2> wyselekcjonowana przez AI o niezwykłej złożoności, wykwintnym guście i prawdziwie ludzkiej świadomości </H2>

    <H1> magia tu się ziści <?php echo $TITLE ?> </H1>

    <div class="container">
      <FORM ACTION="polecenie.php" METHOD="POST">    
        <INPUT TYPE="SUBMIT" VALUE="Nowa rekomendacja">
      </FORM>
    </div>

  </BODY>
</HTML>
