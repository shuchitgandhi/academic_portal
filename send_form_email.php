<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

if(!isset($_POST['submit']))
{
	//This page should not be accessed directly. Need to submit the form.
	echo "error; you need to submit the form!";
}
if(empty($name)||empty($visitor_email)) 
{
    echo "Name and email are mandatory!";
    exit;
}
if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$name = $_POST['name'];
$to = '201301441@daiict.ac.in';
$contact = $_POST['email'];
$id = $_POST['id'];
$batch = $_POST['batch'];
$subject = $_POST['subject'];
$message = $_POST['message'];

$email_body = "Name: $name.\n".
	"Id: $id".
    "Batch: $batch".
    "Message:\n $message".

$headers = "From: " . strip_tags($contact) . "\r\n";
$headers .= "Reply-To: ". strip_tags($contact) . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
mail($to,$subject,$email_body,$headers) or die("Error");

$email_body2 = "Dear $name,\n".
	"\nThe following complaint was sent to the UG Convener :\n".
	"\n$message\n".
	"\nIf you did not make this complaint or if you believe an unauthorised person has used your Id, you should send an email regarding the same to UG Convener as soon as possible.\n".
	"\nBest wishes,\n".
	"Manik Lal Das".

$headers2 = "From: " . strip_tags($to) . "\r\n";
$headers2 .= "Reply-To: ". strip_tags($to) . "\r\n";
$headers2 .= "MIME-Version: 1.0\r\n";
$headers2 .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($contact,'Your complaint has been updated',$email_body2,$headers2) or die("Error");

header('Location: localhost');

// Function to validate against any email injection attempts
function IsInjected($str)
{
  $injections = array('(\n+)',
              '(\r+)',
              '(\t+)',
              '(%0A+)',
              '(%0D+)',
              '(%08+)',
              '(%09+)'
              );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

?>