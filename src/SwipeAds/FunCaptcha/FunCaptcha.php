<?php

namespace SwipeAds\FunCaptcha;

class FunCaptcha
{
    const VERSION = '2.0.0';

    const HOST = 'funcaptcha.com';
    const API_TYPE = 'php';

    const SECURITY_LEVEL_AUTOMATIC = 0;
    const SECURITY_LEVEL_ENHANCED = 20;

    const THEME_DEFAULT = 0;

    const LANG_DEFAULT = 'en';

    /**
     * FunCaptcha public key.
     *
     * @var string
     */
    protected $publicKey;

    /**
     * FunCaptcha private key.
     *
     * @var string
     */
    protected $privateKey;

    /**
     * Form field name.
     *
     * @var string
     */
    protected $fieldName;

    /**
     * Enable lightbox mode.
     *
     * @var bool
     */
    protected $lightboxMode = false;

    /**
     * ID of button to be used to display lightbox.
     *
     * @var string
     */
    protected $lightboxButtonId;

    /**
     * Name of javascript function to call on lightbox FunCaptcha completion.
     *
     * @var string
     */
    protected $lightboxCallbackName;

    /**
     * @var int
     */
    protected $securityLevel = self::SECURITY_LEVEL_AUTOMATIC;

    /**
     * @var int
     */
    protected $theme = self::THEME_DEFAULT;

    /**
     * @var string
     */
    protected $language = self::LANG_DEFAULT;

    /**
     * If true, an alternative captcha will be rendered for users without Javascript enabled.
     *
     * @var bool
     */
    protected $allowNoscript = false;

    /**
     * @var string
     */
    private $host = self::HOST;

    /**
     * @var string
     */
    private $sessionToken;

    /**
     * @var string
     */
    private $challengeUrl;

    /**
     * FunCaptcha constructor.
     *
     * @param string $publicKey
     * @param string $privateKey
     * @param string $host
     */
    public function __construct($publicKey, $privateKey, $fieldName = 'fc-token', $host = null)
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->fieldName = $fieldName;

        if ($host !== null) {
            $this->host = $host;
        }
    }

    /**
     * @return string
     */
    public function getPublicKey()
    {
        return $this->publicKey;
    }

    /**
     * @param string $publicKey
     *
     * @return $this
     */
    public function setPublicKey($publicKey)
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getPrivateKey()
    {
        return $this->privateKey;
    }

    /**
     * @param string $privateKey
     *
     * @return $this
     */
    public function setPrivateKey($privateKey)
    {
        $this->privateKey = $privateKey;

        return $this;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @param string $fieldName
     *
     * @return $this
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLightboxMode()
    {
        return $this->lightboxMode;
    }

    /**
     * @param bool $lightboxMode
     *
     * @return $this
     */
    public function setLightboxMode($lightboxMode)
    {
        $this->lightboxMode = $lightboxMode;

        return $this;
    }

    /**
     * @return string
     */
    public function getLightboxButtonId()
    {
        return $this->lightboxButtonId;
    }

    /**
     * @param string $lightboxButtonId
     *
     * @return $this
     */
    public function setLightboxButtonId($lightboxButtonId)
    {
        $this->lightboxButtonId = $lightboxButtonId;

        return $this;
    }

    /**
     * @return string
     */
    public function getLightboxCallbackName()
    {
        return $this->lightboxCallbackName;
    }

    /**
     * @param string $lightboxSubmitJavascript
     *
     * @return $this
     */
    public function setLightboxCallbackName($lightboxCallbackName)
    {
        $this->lightboxCallbackName = $lightboxCallbackName;

        return $this;
    }

    /**
     * @return int
     */
    public function getSecurityLevel()
    {
        return $this->securityLevel;
    }

    /**
     * Set security level of FunCaptcha.
     *
     * Possible options are:
     * 0 - Automatic-- security rises for suspicious users
     * 20 - Enhanced security-- always use Enhanced security
     *
     * See our website for more details on these options
     *
     * @param int $securityLevel
     *
     * @return $this
     */
    public function setSecurityLevel($securityLevel)
    {
        $this->securityLevel = $securityLevel;

        return $this;
    }

    /**
     * @return int
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param int $theme
     *
     * @return $this
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAllowNoscript()
    {
        return $this->allowNoscript;
    }

    /**
     * @param bool $allowNoscript
     *
     * @return $this
     */
    public function setAllowNoscript($allowNoscript)
    {
        $this->allowNoscript = $allowNoscript;

        return $this;
    }

    /**
     * Fetch session token and return HTML for rendering the FunCaptcha.
     *
     * @throws \Exception
     *
     * @return string
     */
    public function render()
    {
        // send your public key, your site name, the users ip and browser type.
        $data = [
            'public_key'         => $this->getPublicKey(),
            'site'               => $_SERVER['SERVER_NAME'],
            'userip'             => $this->determineClientIp(),
            'userbrowser'        => $_SERVER['HTTP_USER_AGENT'],
            'api_type'           => self::API_TYPE,
            'plugin_version'     => self::VERSION,
            'security_level'     => $this->getSecurityLevel(),
            'language'           => $this->getLanguage(),
            'noscript_support'   => $this->isAllowNoscript(),
            'lightbox'           => $this->isLightboxMode(),
            'lightbox_button_id' => $this->getLightboxButtonId(),
            'lightbox_submit_js' => $this->getLightboxCallbackName(),
            'theme'              => $this->getTheme(),
            'args'               => [],
        ];

        $sessionData = $this->post('/fc/gt/', $data);

        $this->sessionToken = $sessionData->token;
        if (!$this->sessionToken) {
            throw new \Exception('Failed to retrieve session token');
        }

        $this->challengeUrl = $sessionData->challenge_url;
        if (!$this->challengeUrl) {
            throw new \Exception('Failed to retrieve challenge URL');
        }

        $scriptUrl = 'https://'.$this->host.$this->challengeUrl.'?cache='.time();

        if ($this->isAllowNoscript()) {
            $fallbackHtml = $sessionData->noscript;
        } else {
            $fallbackHtml = <<<'HTML'
<noscript><p>Please enable JavaScript to continue.</p></noscript>
HTML;
        }

        $html = <<<HTML
<div id="FunCaptcha"></div>
<input type="hidden" id="FunCaptcha-Token" name="{$this->fieldName}" value="{$this->sessionToken}">
<script src="{$scriptUrl}" type="application/javascript"></script>
{$fallbackHtml}
HTML;

        return $html;
    }

    /**
     * Check if the submitted token is valid.
     *
     * @throws \Exception
     *
     * @return bool
     */
    public function validate()
    {
        $data = [
            'private_key'     => $this->privateKey,
            'session_token'   => $_POST[$this->fieldName],
            'fc_rc_challenge' => isset($_POST['fc_rc_challenge']) ? $_POST['fc_rc_challenge'] : null,
        ];
        $result = $this->post('/fc/v/', $data);

        return $result->solved;
    }

    /**
     * Send a POST request to the FunCaptcha API and return decoded JSON response object.
     *
     * @param string $path
     * @param array  $data
     *
     * @throws \Exception
     *
     * @return object
     */
    protected function post($path, array $data)
    {
        $data_string = http_build_query($data);

        $http_request = "POST $path HTTP/1.1\r\n";
        $http_request .= "Host: $this->host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $http_request .= 'Content-Length: '.strlen($data_string)."\r\n";
        $http_request .= 'User-Agent: FunCaptcha/PHP '.self::VERSION."\r\n";
        $http_request .= "Connection: Close\r\n";
        $http_request .= "\r\n";
        $http_request .= $data_string."\r\n";

        $result = '';
        $errno = $errstr = '';
        $fs = fsockopen('ssl://'.$this->host, 443, $errno, $errstr, 10);

        if (false == $fs) {
            throw new \Exception('Could not open socket');
        }

        fwrite($fs, $http_request);
        while (!feof($fs)) {
            $result .= fgets($fs, 4096);
        }
        $result = explode("\r\n\r\n", $result, 2);

        return json_decode($result[1]);
    }

    /**
     * Returns the remote user's IP address.
     *
     * @return string
     */
    protected function determineClientIp()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            if (isset($_SERVER['REMOTE_ADDR'])) {
                return $_SERVER['REMOTE_ADDR'];
            } else {
                if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                    return $_SERVER['HTTP_CLIENT_IP'];
                }
            }
        }

        return '';
    }
}
