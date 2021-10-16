<?php
print("<br>Hello Word");
print("<br>Latihan Kirim data dari sisi client ke server");
print("<br>Uji Passing parameter antara client dan server dengan form pada name_age.php");
print("<br>");
print("<br>");
   if( $_GET["name"] || $_GET["age"] ) {
      echo "Hai ". $_GET['name']. "<br />";
      echo "Kamu berumur ". $_GET['age']. " tahun.";
      
      exit();
   }
?>
<html>
   <body>
      <form action = "<?php $_PHP_SELF ?>" method = "GET">
         Nama: <input type = "text" name = "name" />
         Umur: <input type = "text" name = "age" />
         <input type = "submit" />
      </form>
      
   </body>
</html>
