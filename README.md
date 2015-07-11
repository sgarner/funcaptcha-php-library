funcaptcha-php-library
======================

Stop spam with a free, fun, fast CAPTCHA game
Spammers abuse your site, but users hate typing out twisty letters. This significantly reduces user conversions, and it’s just not OK any more. FunCaptcha presents a mini-game that blocks the bots while giving your users a few moments of fun. It’s a real security solution hardened by experts and automatically updated to provide the best protection.

Users complete these little games faster than other CAPTCHAs, with no frustrating failures and no typing. FunCaptcha works on all browsers and mobile devices. It’s easy to implement, so join thousands of other sites and try it!

You can get started and view a demo at our [website](https://www.funcaptcha.com).

## PHP setup
Our PHP code makes it easy to use FunCaptcha on your site. It’s just like adding any other popular captcha.

## Registration
You’ll need to register on our [website](https://www.funcaptcha.com) and add your domains.  Once you have registered, you can add your website URL which will generate a private and public key. These keys are used in the php library to authenticate your website with our servers.

## Setup Requirements

This release of the FunCaptcha library requires PHP 5.3 or later to work.

## Installation from Composer

1. Install [Composer](https://getcomposer.org/), if you haven't already.

2. Run `composer require swipeads/funcaptcha` to add the library to your project.

3. The library will be added to your vendors dir and available for autoloading.

## Manual Installation

1. Copy the `src/SwipeAds/FunCaptcha/FunCaptcha.php` file to a directory on your web server.

2. Include it in your php code.

  ```php
require_once('path/to/FunCaptcha.php');
```

## Usage

1. Create an instance of the FunCaptcha object, passing in your keys. Get your keys by [registering](https://www.funcaptcha.com/register/).

  ```php
   $funcaptcha = new SwipeAds\FunCaptcha\FunCaptcha('YOUR_PUBLIC_KEY', 'YOUR_PRIVATE_KEY');
  ```

2. Call the render() method to get the HTML for the FunCaptcha in your form.

  ```php
  echo $funcaptcha->render();
  ```

3. When the user submits the form, where you are validating your form results, add a check to see if FunCaptcha is validated.

  ```php
$verified = $funcaptcha->validate();
if ($verified) {
echo 'Successfully passed!';
} else {
echo 'Failed verification, please try again.';
}
```

Everything should now be up and working. Please [contact us](https://www.funcaptcha.com/contact-us/) if you have any issues or questions. Some further options are shown in the sample.php.

