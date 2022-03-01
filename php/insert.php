<?php

$username = $_POST['username'];
$email  = $_POST['email'];
$address = $_POST['address'];
$mobilenumber = $_POST['mobilenumber'];




if (!empty($username) || !empty($email) || !empty($address) || !empty($mobilenumber) )
{

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "simpledb";



// Create connection
$conn = new mysqli ($host, $dbusername, $dbpassword, $dbname);

if (mysqli_connect_error()){
  die('Connect Error ('. mysqli_connect_errno() .') '
    . mysqli_connect_error());
}
else{
  $SELECT = "SELECT email From sign_in Where email = ? Limit 1";
  $INSERT = "INSERT Into sign_in (username , email ,address, mobilenumber )values(?,?,?,?)";

//Prepare statement
     $stmt = $conn->prepare($SELECT);
     $stmt->bind_param("s", $email);
     $stmt->execute();
     $stmt->bind_result($email);
     $stmt->store_result();
     $rnum = $stmt->num_rows;

     //checking username
      if ($rnum==0) {
      $stmt->close();
      $stmt = $conn->prepare($INSERT);
      $stmt->bind_param("sssi", $username,$email,$address,$mobilenumber);
      $stmt->execute();
      echo "New record inserted sucessfully";
     } else {
      echo "Someone already register using this email";
     }
     $stmt->close();
     $conn->close();
    }
} else {
 echo "All field are required";
 die();
}
?>