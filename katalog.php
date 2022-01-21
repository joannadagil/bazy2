<HTML>
  <HEAD>
    <TITLE> Katalog </TITLE>
    <link rel="stylesheet" href="css/main.css">
    <meta charset="utf-8">
    <style>
      *{
        margin: 0;
        padding: 0;
      }
      .rate {
        border: 1px solid #cccccc;
        float: left;
        height: 46px;
        padding: 0 10px;
      }
      .rate:not(:checked) > input {
        position:absolute;
        top:-9999px;
      }
      .rate:not(:checked) > label {
        float:right;
        width:1em;
        overflow:hidden;
        white-space:nowrap;
        cursor:pointer;
        font-size:30px;
        color:#ccc;
      }
      .rate:not(:checked) > label:before {
        content: '★ ';
      }
      .rate > input:checked ~ label {
        color: #ffc700;
      }
      .rate:not(:checked) > label:hover,
      .rate:not(:checked) > label:hover ~ label {
        color: #deb217;
      }
      .rate > input:checked + label:hover,
      .rate > input:checked + label:hover ~ label,
      .rate > input:checked ~ label:hover,
      .rate > input:checked ~ label:hover ~ label,
      .rate > label:hover ~ input:checked ~ label {
        color: #c59b08;
      }
      .topnav input[type=submit] {
        float: right;
        padding: 14px 16px;
        border: none;
        margin-top: 8px;
        margin-right: 16px;
        background: #e9e9e9;
        border: none;
        font-size: 30px;
        width: 100%;
      }

      input[type=submit] {
        border: none;
        float: center;
        width: 100%;
        /*padding: 6px;
        margin-top: 8px;
        margin-right: 16px;*/
        background: #ddd;
        font-size: 17px;
        border: none;
        cursor: pointer;
      }

      input[type=submit]:hover {
        background: #ccc;
      }
    </style>
  </HEAD>
  <BODY>
    <div class="header">
      <h1>Katalog biblioteczny</h1>
    </div>
    <?PHP
      session_start();

      $search = $_GET['search'];

      $conn = oci_connect($_SESSION['LOGIN'],$_SESSION['PASS'],"//labora.mimuw.edu.pl/LABS");
      if (!$conn) {
        echo "oci_connect failed\n";
        $e = oci_error();
        echo $e['message'];
      }
      // Tworzenie wyrazenia SQL-owego. Uzycie fmurlak.naukowiec zamiast naukowiec pozwala na odczytanie tabeli inego uzytkownika.
      $stmt = oci_parse($conn, "SELECT * FROM BOOK WHERE BTITLE LIKE '%".$search."%' ORDER BY BID FETCH FIRST 100 ROWS ONLY");
      // Wykonywanie wyrazenia SQL-owego
      oci_execute($stmt, OCI_NO_AUTO_COMMIT);
    ?>

    <div class="topnav">
      <a href="#home">Strona główna</a>
      <a href="#about">About</a>
      <a href="#contact">Contact</a>
      <div class="search-container">
        <form action="katalog.php">
          <input type="text" placeholder="Search.." name="search">
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>

    <table> <?PHP
      while (($row = oci_fetch_array($stmt, OCI_BOTH))) {
        ?>
        <tr>
          <td><?php echo $row["BID"]; ?></td>
      		<td><?php echo $row["BTITLE"]; ?></td>
          <td><?php echo $row["ISBN"]; ?></td>
          <td>
            <form ACTION="wypozyczanie.php" METHOD="POST">
              <input TYPE="HIDDEN" NAME="available" VALUE="<?php echo $row["BID"];?>">
              <input TYPE="SUBMIT" VALUE="Wypozyczanie">
            </form>
          </td>
          <td>
            <div class="rate">
              <input type="radio" id=<?php echo "\"star5".$row["BID"]."\""?> name="rate" value="5" /><label for=<?php echo "\"star5".$row["BID"]."\""?> title="text">5 stars</label>
              <input type="radio" id=<?php echo "\"star4".$row["BID"]."\""?> name="rate" value="4" /><label for=<?php echo "\"star4".$row["BID"]."\""?> title="text">4 stars</label>
              <input type="radio" id=<?php echo "\"star3".$row["BID"]."\""?> name="rate" value="3" /><label for=<?php echo "\"star3".$row["BID"]."\""?> title="text">3 stars</label>
              <input type="radio" id=<?php echo "\"star2".$row["BID"]."\""?> name="rate" value="2" /><label for=<?php echo "\"star2".$row["BID"]."\""?> title="text">2 stars</label>
              <input type="radio" id=<?php echo "\"star1".$row["BID"]."\""?> name="rate" value="1" /><label for=<?php echo "\"star1".$row["BID"]."\""?> title="text">1 star</label>
            </div>
          </td>
	      </tr>
      <?php
      }
    ?>
    </table>

  </BODY>
</HTML>
