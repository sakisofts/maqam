<?php
namespace app\components\Generics;
use Yii;
use yii\base\Component;
use yii\mail\MailerInterface;

/**
 * EmailService provides functionality for sending emails
 * supporting both simple emails and HTML template-based emails.
 */
class EmailService extends Component
{
    /**
     * @var string Default sender email address
     */
    public $defaultSenderEmail;

    /**
     * @var string Default sender name
     */
    public $defaultSenderName;

    /**
     * @var string Path to email templates directory (kept for backward compatibility, not used)
     */
    public $templatePath = '@app/mail/templates';

    /**
     * @var MailerInterface The mailer instance
     */
    private $_mailer;

    /**
     * Initialize the component
     */
    public function init()
    {
        parent::init();

        if (empty($this->defaultSenderEmail)) {
            $this->defaultSenderEmail = Yii::$app->params['adminEmail'] ?? 'noreply@example.com';
        }

        if (empty($this->defaultSenderName)) {
            $this->defaultSenderName = Yii::$app->params['adminName'] ?? 'System Admin';
        }

        $this->_mailer = Yii::$app->mailer;
    }

    /**
     * Send a simple email
     *
     * @param string|array $to Recipient email address or array of addresses
     * @param string $subject Email subject
     * @param string $body Email body
     * @param array $options Additional options (cc, bcc, replyTo, from, attachments)
     * @return bool Whether the email was sent successfully
     */
    public function sendEmail($to, $subject, $body, $options = [])
    {
        $message = $this->_mailer->compose()
            ->setTo($to)
            ->setSubject($subject)
            ->setTextBody($body);
        return $this->configureSendMessage($message, $options);
    }

    /**
     * Send an HTML email
     *
     * @param string|array $to Recipient email address or array of addresses
     * @param string $subject Email subject
     * @param string $htmlBody HTML body content
     * @param string|null $textBody Plain text alternative body (optional)
     * @param array $options Additional options (cc, bcc, replyTo, from, attachments)
     * @return bool Whether the email was sent successfully
     */
    public function sendHtmlEmail($to, $subject, $htmlBody, $textBody = null, $options = [])
    {
        $message = $this->_mailer->compose()
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($htmlBody);

        if ($textBody !== null) {
            $message->setTextBody($textBody);
        }

        return $this->configureSendMessage($message, $options);
    }

    /**
     * Send an email using a view template
     *
     * @param string|array $to Recipient email address or array of addresses
     * @param string $subject Email subject
     * @param string $template Template name (without extension)
     * @param array $params Parameters to pass to the template
     * @param array $options Additional options (cc, bcc, replyTo, from, attachments)
     * @return bool Whether the email was sent successfully
     */
    public function sendTemplateEmail($to, $subject, $template, $params = [], $options = [])
    {
        // Compose the message using the template name
        // The mailer already knows the path from its viewPath configuration
        $message = $this->_mailer->compose([
            'html' => $template,
        ], $params)
            ->setTo($to)
            ->setSubject($subject);

        return $this->configureSendMessage($message, $options);
    }
    /**
     * Configure additional options and send the email message
     *
     * @param \yii\mail\MessageInterface $message
     * @param array $options
     * @return bool Whether the email was sent successfully
     */
    protected function configureSendMessage($message, $options = [])
    {
        // Set sender if not specified in options
        if (!isset($options['from'])) {
            $message->setFrom([$this->defaultSenderEmail => $this->defaultSenderName]);
        } else {
            $message->setFrom($options['from']);
        }

        // Set CC if provided
        if (isset($options['cc'])) {
            $message->setCc($options['cc']);
        }

        // Set BCC if provided
        if (isset($options['bcc'])) {
            $message->setBcc($options['bcc']);
        }

        // Set Reply-To if provided
        if (isset($options['replyTo'])) {
            $message->setReplyTo($options['replyTo']);
        }

        // Add attachments if provided
        if (isset($options['attachments']) && is_array($options['attachments'])) {
            foreach ($options['attachments'] as $attachment) {
                if (is_string($attachment)) {
                    $message->attach($attachment);
                } elseif (is_array($attachment) && isset($attachment['path'])) {
                    $attachOptions = $attachment;
                    $path = $attachOptions['path'];
                    unset($attachOptions['path']);
                    $message->attach($path, $attachOptions);
                }
            }
        }

        // Send the email
        return $message->send();
    }

    public function queueEmail($method, $params = [])
    {
        if (!isset(Yii::$app->queue)) {
            throw new \Exception('Queue component is not configured');
        }

        return Yii::$app->queue->push(new \app\jobs\SendEmailJob([
            'method' => $method,
            'params' => $params,
        ]));
    }
}
