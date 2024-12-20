<?php

$db_name = 'mysql:host=localhost;dbname=contato';
   $user_name = 'root';
   $user_password = '';

   $conn = new PDO($db_name, $user_name, $user_password);

   function unique_id() {
      $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $rand = array();
      $length = strlen($str) - 1;
      for ($i = 0; $i < 20; $i++) {
          $n = mt_rand(0, $length);
          $rand[] = $str[$n];
      }
      return implode($rand);
   }

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $name = $_POST['name']; 
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email']; 
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $subject = $_POST['subject']; 
   $subject = filter_var($subject, FILTER_SANITIZE_STRING);


   $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND subject = ? AND message = ?");
   $select_contact->execute([$name, $email, $subject, $message]);

   if($select_contact->rowCount() > 0){
      $message[] = 'message sent already!';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `contact`(name, email, subject, message) VALUES(?,?,?,?)");
      $insert_message->execute([$name, $email, $subject, $message]);
      $message[] = 'message sent successfully!';
   }

}

?>

