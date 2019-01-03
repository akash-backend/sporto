<?php

    error_reporting(E_ALL);
      $file ="1532700518230725964-test.doc"; //File here (eg test.docx)
      $file = "test_upload/"; //Path to file here (eg documents/)
      $mailto = "amit885@mailinator.com"; 
      // $from_mail = "akashbaidya442@gmail.com"; //Send mail address
      $from_name = "ajay"; //From name
      $from_mail = "akashbaidya442@gmail.com"; //Email address to reply to
      $subjest = "test"; //Mail subject
      $message = "hello"; //Mail body message
      echo mail_attachment($file,$path,$mailto,$from_mail,$from_name,$from_mail, $subjest, $message);


      // mail_attachment($file_name,$file_path,$subadmin,$from_mail,"Order Placed","creativethoughtsinfo.com","Order For Salesman",$message);


       // mail_attachment($file_name,$file_path,$subadmin,"No-Reply","Order Placed","creativethoughtsinfo.com","Order For Salesman",$message);




function mail_attachment($filename, $path, $mailto, $from_mail, $from_name, $replyto, $subject, $message) {

   $header = "From: ".$from_name." <".$from_mail.">\n";
    $header .= "Reply-To: ".$replyto."\n";
    $header .= "MIME-Version: 1.0\n";
    $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\n\n";
    $emessage= "--".$uid."\n";
    $emessage.= "Content-type:text/plain; charset=iso-8859-1\n";
    $emessage.= "Content-Transfer-Encoding: 7bit\n\n";
    $emessage .= $message."\n\n";
    $emessage.= "--".$uid."\n";
    $emessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\n"; // use different content types here
    $emessage .= "Content-Transfer-Encoding: base64\n";
    $emessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\n\n";
    $emessage .= $content."\n\n";
    $emessage .= "--".$uid."--";
   

    if (mail($mailto,$subject,$emessage,$header))
{
    return "mail_success";
}
else
{
    return "mail_error";
}

}

?>