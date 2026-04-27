<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

/**
 * TwoFactorAuthForm is the model behind the two-factor authentication form.
 */
class TwoFactorAuthForm extends Model
{
    /**
     * @var string The verification code from authenticator app
     */
    public $verificationCode;

    /**
     * @var string The generated secret key
     */
    public $secretKey;

    /**
     * @var string URL for the QR code
     */
    public $qrCodeUrl;

    /**
     * @var array List of backup/recovery codes
     */
    public $backupCodes = [];

    /**
     * @var \app\models\User The user model
     */
    private $_user;

    /**
     * Creates a form model with the given user.
     *
     * @param \app\models\User $user the user model
     * @param array $config name-value pairs that will be used to initialize the object properties
     */
    public function __construct($user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['verificationCode', 'required'],
            ['verificationCode', 'string', 'min' => 6, 'max' => 6],
            ['verificationCode', 'match', 'pattern' => '/^\d{6}$/', 'message' => 'Verification code must be 6 digits.'],
            ['verificationCode', 'validateVerificationCode'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'verificationCode' => 'Verification Code',
        ];
    }

    /**
     * Validates the verification code.
     *
     * @param string $attribute the attribute currently being validated
     */
    public function validateVerificationCode($attribute)
    {
        if (!$this->hasErrors() && $this->secretKey) {
            // Validate verification code against the secret key
            $valid = $this->verifyCode($this->$attribute);

            if (!$valid) {
                $this->addError($attribute, 'Invalid verification code. Please try again.');
            }
        }
    }

    /**
     * Generates a new secret key and QR code
     */
    public function generateSecretKey()
    {
        // Generate a random secret key (usually a 16 or 32 character string)
        $this->secretKey = $this->generateRandomSecret();

        // Generate QR code URL
        $issuer = Yii::$app->name;
        $username = $this->_user->username ?? $this->_user->email;

        $otpAuthUrl = "otpauth://totp/{$issuer}:{$username}?secret={$this->secretKey}&issuer={$issuer}";
        $this->qrCodeUrl = $this->generateQrCodeUrl($otpAuthUrl);

        // Generate backup codes
        $this->backupCodes = $this->generateBackupCodes();

        return true;
    }

    /**
     * Enables two-factor authentication for the user
     *
     * @return boolean whether 2FA was successfully enabled
     */
    public function enableTwoFactor()
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_user->two_factor_secret = $this->secretKey;
        $this->_user->two_factor_enabled = true;
        $this->_user->two_factor_enabled_at = date('Y-m-d H:i:s');
        $this->_user->recovery_codes = json_encode($this->backupCodes);
        $this->_user->remaining_recovery_codes = count($this->backupCodes);

        return $this->_user->save(false);
    }

    /**
     * Generates a random secret key
     *
     * @return string
     */
    protected function generateRandomSecret()
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secret = '';

        for ($i = 0; $i < 16; $i++) {
            $secret .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $secret;
    }

    /**
     * Generates a QR code URL
     *
     * @param string $text
     * @return string
     */
    protected function generateQrCodeUrl($text)
    {
        // Here we would normally use BaconQrCode or similar library to generate a QR code
        // For simplicity, we'll just return a placeholder URL
        // In a real implementation, this would generate a data URI or temporary file

        // Example implementation using BaconQrCode:
        /*
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd()
        );
        $writer = new Writer($renderer);

        // Generate QR code and convert to data URI
        $qrCode = $writer->writeString($text);
        $dataUri = 'data:image/png;base64,' . base64_encode($qrCode);
        return $dataUri;
        */

        // For now, return a placeholder or use a service like Google Charts API
        $encodedText = urlencode($text);
        return "https://chart.googleapis.com/chart?cht=qr&chs=300x300&chl={$encodedText}";
    }

    /**
     * Generates backup/recovery codes
     *
     * @param int $count Number of codes to generate
     * @return array
     */
    protected function generateBackupCodes($count = 8)
    {
        $codes = [];

        for ($i = 0; $i < $count; $i++) {
            // Generate a code like XXXX-XXXX-XXXX where X is alphanumeric
            $codes[] = sprintf(
                '%s-%s-%s',
                $this->generateRandomString(4),
                $this->generateRandomString(4),
                $this->generateRandomString(4)
            );
        }

        return $codes;
    }

    /**
     * Generates a random string
     *
     * @param int $length
     * @return string
     */
    protected function generateRandomString($length = 4)
    {
        $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return $result;
    }

    /**
     * Verifies the provided code against the secret key
     *
     * @param string $code
     * @return boolean
     */
    protected function verifyCode($code)
    {
        // In a real implementation, you would use a TOTP library
        // This is a placeholder implementation

        // Example using OTPHP library:
        /*
        $totp = TOTP::create($this->secretKey);
        return $totp->verify($code);
        */

        // Simplified placeholder verification
        // In a real app, replace this with actual TOTP verification
        return strlen($code) === 6 && is_numeric($code);
    }
}
