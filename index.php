<html>

<head>
   <style>
      :root{
         display: flex;
         justify-content: center;
         align-items: center;
         margin-top: 25%;
         
      }
      input {
         border: 2px solid;
         border-radius: 6px;
         height: 50px;
         background: white;
         font-weight: bold;
         font-size: 18px;
      }

      input::placeholder {
         font-size: 20px;
      }
      input:invalid{
      border:2px solid red;
      animation:shake 0.2s 2;
      }

      form {
         display: flex;
         flex-direction: column;
      }
      @keyframes shake{
      25%{
      translate: 6px 0px;
      }
      50%{
      translate:-6px 0px;
      }
       75%{
      translate:6px 0px;
      }
      
      
      }
   </style>
</head>

<body>
   <form action='<?php echo $_SERVER['PHP_SELF'];?>' method='post' autocomplete="off">
      <input  style='width:400px;' type='text' name='text' required placeholder="Enter text">
      <br>
      <input style='width:400px;' type='submit'>
   </form>
   <?php
if ($_SERVER["REQUEST_METHOD"]=="POST") {
   $text = htmlspecialchars($_POST['text']);

   $element = "<b>$text</b>";
   echo ('Text : ' .$element);
   
   $conn = new mysqli('10.0.14.23', 'sirajju', '242424', 'test');
   
   if ($conn->connect_errno) {
      die('connect to db failed');
   } else {
      
         $stmt = $conn->prepare("SELECT Name FROM test WHERE Name = ?");
         $stmt->bind_param("s", $text);
         $stmt->execute();
         $result = $stmt->get_result();
 echo "<br>";
      echo "<table border='1'>";
      
      while ($row = mysqli_fetch_assoc($result)) { 
         echo "<tr>";
foreach ($row as $field => $value) { 
            echo "<td>" . htmlspecialchars($value) . "</td>";
         }
  echo "</tr>";
      }
   
 echo "</table>";
      
      if ($result->num_rows != 0) {
         echo "<br>SQL : <b>returned number of rows are ".$result->num_rows;
      } else {
         echo '<br><b>No data found!!</b>';
      }
   }
}


