<?php




if(isSet($_COOKIE[$cookie_name]))
{
// remove 'site_auth' cookie
setcookie ($cookie_name, '', time() - $cookie_time);
}

header("Location: login/login.php");
exit;

?>