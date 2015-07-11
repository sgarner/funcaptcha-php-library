<!DOCTYPE html>
<?php
//******************************************************************************
/*
	Name:		sample.php

	Purpose:	Provide an example of how to integrate an SwipeAds FunCaptcha on PHP web form.

	Requirements:
			- your web server uses PHP5.3 (or higher).
			- you have read the installation instructions page at:
				https://www.funcaptcha.com/setup
*/
//******************************************************************************

// This is only necessary if you don't have a class autoloader. Adjust the path as necessary.
// require_once('src/SwipeAds/FunCaptcha/FunCaptcha.php');

// Import the FunCaptcha class
use SwipeAds\FunCaptcha\FunCaptcha;

// Instantiate a FunCaptcha object, passing in your keys.
$funcaptcha = new FunCaptcha('YOUR_PUBLIC_KEY', 'YOUR_PRIVATE_KEY');

// OPTIONAL
// Enable FunCaptcha lightbox mode, for more information view our FAQ at https://www.funcaptcha.com/faqs/
// $funcaptcha->setLightboxMode(true);

// OPTIONAL
// Enable FunCaptcha to show a fallback CAPTCHA if a user has JavaScript turned off, we recommend it disabled (default) as bots generally browse with JavaScript off.
// $funcaptcha->setAllowNoscript(true);

// OPTIONAL
// Change FunCaptcha visual theme - see https://www.funcaptcha.com/themes/ for examples
// $funcaptcha->setTheme(1);

// OPTIONAL
// Set the security level of FunCaptcha, for more information view our FAQ at https://www.funcaptcha.com/faqs/
//$funcaptcha->setSecurityLevel(0);



// The form submits to itself, so see if the user has submitted the form.
if (array_key_exists('submit', $_POST))
{
	// Use the funcaptcha object to get verified. Pass in Private Key.
	$verified = $funcaptcha->validate();
	// Check if verified to determine what to do.
	if ($verified)
	{
		echo "Successfully passed!";
	}
	else
	{
		echo "Failed verification, please try again.";
	}
}
?>

<form method="post" action="">
	<p>Please enter your name: <input type="text" name="name"></p>
	<?php
		// Use the funcaptcha object to get the HTML code needed to
		// load and run the FunCaptcha.
		 echo $funcaptcha->render();
	?>
	<input type="Submit" name="submit" value=" GO ">
</form>
