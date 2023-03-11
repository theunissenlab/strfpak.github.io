<? 
/**
 * Mailer.php
 *
 * The Mailer class is meant to simplify the task of sending
 * emails to users. Note: this email system will not work
 * if your server is not setup to send mail.
 *
 * If you are running Windows and want a mail server, check
 * out this website to see a list of freeware programs:
 * <http://www.snapfiles.com/freeware/server/fwmailserver.html>
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
 
class Mailer
{
   /**
    * sendWelcome - Sends a welcome message to the newly
    * registered user, also supplying the username and
    * password.
    */
   function sendWelcome($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.
        ">\nX-Mailer: PHP/ . $phpversion()";
      $fromaddr=EMAIL_FROM_ADDR;
      $subject = "Neural Prediction Challenge - Welcome!";
      $body = $user.",\n\n"
             ."Welcome! You've just registered for the Neural Prediction Challenge "
             ."with the following information:\n\n"
             ."Username: ".$user."\n"
             ."Password: ".$pass."\n\n"
             ."If you ever lose or forget your password, a new "
             ."password will be generated for you and sent to this "
             ."email address, if you would like to change your "
             ."email address you can do so by going to the "
             ."My Account page after signing in.\n\n"
             ."- NPC (http://neuralprediction.berkeley.edu)";

      return mail($email,$subject,$body,$from,"-f $fromaddr");
   }
   
   /**
    * sendNewPass - Sends the newly generated password
    * to the user's email address that was specified at
    * sign-up.
    */
   function sendNewPass($user, $email, $pass){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.
        ">\nX-Mailer: PHP/ . $phpversion()";
      $fromaddr=EMAIL_FROM_ADDR;
      $subject = "Neural Prediction Challenge - Your new password";
      $body = $user.",\n\n"
             ."We've generated a new password for you at your "
             ."request, you can use this new password with your "
             ."username to log in to the Neural Prediction Challenge site.\n\n"
             ."Username: ".$user."\n"
             ."New Password: ".$pass."\n\n"
             ."It is recommended that you change your password "
             ."to something that is easier to remember, which "
             ."can be done by going to the My Account page "
             ."after signing in.\n\n"
             ."- NPC (http://neuralprediction.berkeley.edu)";
             
      return mail($email,$subject,$body,$from,"-f $fromaddr");
   }

   /**
    * sendLoginNotice - Tells when someone logs in.
    */
   function sendLoginNotice($user){
      $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.
        ">\nX-Mailer: PHP/ . $phpversion()";
      $fromaddr=EMAIL_FROM_ADDR;
      $subject = "NPC - $user just logged in";
      $body = "$user just logged in http://neuralprediction.berkeley.edu";
      
      return mail("svd@umd.edu",$subject,$body,$from,"-f $fromaddr");
      //return mail("svd@umd.edu",$subject,$body,$from);
   }

   /**
    * sendRegNotice - Tells when someone signs up.
    */
   function sendRegNotice($user){
     global $database;
     
     // this stuff isn't loaded yet, since user isn't logged in
     $userinfo  = $database->getUserInfo($user);
     
     $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.
       ">\nX-Mailer: PHP/ . $phpversion()";
     $fromaddr=EMAIL_FROM_ADDR;
     $subject = "NPC - $user pending approval";
     $body = "User $user just signed up for NPC\n\n".
       "Name: " . $userinfo['fullname'] . "\n".
       "Institution: " . $userinfo['institution'] . "\n".
       "Email: " . $userinfo['email'] . "\n".
       "Justification for using NPC data: " . $userinfo['justification'] . "\n\n".
       "Activate/disable accounts using NPC \"Admin\" tab\n";
     
     //mail("gallant@berkeley.edu",$subject,$body,$from, "-f $fromaddr");
     //mail("zhang6@berkeley.edu",$subject,$body,$from);
     return mail("svd@umd.edu",$subject,$body,$from,"-f $fromaddr");
   }
   
   /**
    * sendActivationNotice - Tells when someone signs up.
    */
   function sendActivationNotice($user){
     global $database;
     
     // this stuff isn't loaded yet, since user isn't logged in
     $userinfo  = $database->getUserInfo($user);
     
     $from = "From: ".EMAIL_FROM_NAME." <".EMAIL_FROM_ADDR.
       ">\nX-Mailer: PHP/ . $phpversion()";
     $fromaddr=EMAIL_FROM_ADDR;
     $subject = "NPC - $user activated";
     $body = "Dear ". $userinfo['fullname'] . ":\n\n" .
       "You recently requested an account on the Neural Prediction Challenge server. Your account has been fully activated. Now you should be able to log in and access data with userid \"". $user . "\" and the password that you entered during registration.\n\n" .
       "Good luck in the challenge!\n".
       "Jack and Stephen.\n";
     
     return mail($userinfo['email'],$subject,$body,$from,"-f $fromaddr");
   }
};

/* Initialize mailer object */
$mailer = new Mailer;
 
?>
