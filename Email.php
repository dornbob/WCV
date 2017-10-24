<?php

require 'swiftmailer/lib/swift_required.php';
//Email Class
class Email
{
    //Email Properties
    private $smtpServer = 'outlook.office365.com';
    private $portNumber = 587;
    private $senderUsername = 'wildlifecenterofva@outlook.com';
    private $senderPassword = '#animals12!';
    private $messageSubject;
    private $messageBody;
    private $messageAltBody;
    private $senderEmail = 'wildlifecenterofva@outlook.com';
    private $senderName = 'Wildlife Center of VA';
    private $recieverEmail;
    private $recieverName;
    private $resetLink;

    //Email constructor
    public function __construct()
    {

    }

    //Getter and Setter for smtpServer
    public function getSmtpServer()
    {
        return $this->smtpServer;
    }
    public function setSmtpServer($smtpServer)
    {
        $this->smtpServer = $smtpServer;
    }

    //Getter and Setter for portNumber
    public function getPortNumber()
    {
        return $this->portNumber;
    }
    public function setPortNumber($portNumber)
    {
        $this->portNumber = $portNumber;
    }

    //Getter and Setter for senderUsername
    public function getSenderUsername()
    {
        return $this->senderUsername;
    }
    public function setSenderUsername($senderUsername)
    {
        $this->senderUsername = $senderUsername;
    }

    //Getter and Setter for senderPassword
    public function getSenderPassword()
    {
        return $this->senderPassword;
    }
    public function setSenderPassword($senderPassword)
    {
        $this->senderPassword = $senderPassword;
    }

   //Getter and Setter for messageSubject
    public function getMessageSubject()
    {
        return $this->messageSubject;
    }
    public function setMessageSubject($messageSubject)
    {
        $this->messageSubject = $messageSubject;
    }

    //Getter and Setter for messageBody
    public function getMessageBody()
    {
        return $this->messageBody;
    }
    public function setMessageBody($messageBody)
    {
        $this->messageBody = $messageBody;
    }

   //Getter and Setter for messageAltBody
    public function getMessageAltBody()
    {
        return $this->messageAltBody;
    }
    public function setMessageAltBody($messageAltBody)
    {
        $this->messageAltBody = $messageAltBody;
    }

    //Getter and Setter for senderEmail
    public function getSenderEmail()
    {
        return $this->senderEmail;
    }
    public function setSenderEmail($senderEmail)
    {
        $this->senderEmail = $senderEmail;
    }

    //Getter and Setter for senderName
    public function getSenderName()
    {
        return $this->senderName;
    }
    public function setSenderName($senderName)
    {
        $this->senderName = $senderName;
    }

    //Getter and Setter for recieverEmail
    public function getRecieverEmail()
    {
        return $this->recieverEmail;
    }
    public function setRecieverEmail($recieverEmail)
    {
        $this->recieverEmail = $recieverEmail;
    }

    //Getter and Setter for recieverName
    public function getRecieverName()
    {
        return $this->recieverName;
    }
    public function setRecieverName($recieverName)
    {
        $this->recieverName = $recieverName;
    }

    //Getter and Setter for reset Link
    public function getResetLink()
    {
        return $this->resetLink;
    }
    public function setResetLink($resetLink)
    {
        $this->resetLink = $resetLink;
    }

    //Function for sending a forgot password email with recovery link
    public function emailForgotPassword($resetLink, $recoverNumber)
    {

        $name = $this->getRecieverName();

        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('WCV Volunteer Forgot Password')

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("Hello, $name \n\n You forgot your password! \n Follow this link to reset: $resetLink
                    and enter $recoverNumber when prompted\n\n Please do not reply to this email")

            // Sets a more basic body
            ->addPart("<q> Hello, $name <br><br> You forgot your password! <br> Follow this link to reset: $resetLink 
                and enter $recoverNumber when prompted<br><br> Please do not reply to this email</q>", 'text/html');



        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $result = $mailer->send($message);
    }

    //Function for sending a successful password change email
    public function emailPassChangeSuccess()
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        //Gets the volunteer's name
        $name = $this->getRecieverName();
        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('WCV Volunteer Password Change Success')

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("Hello, $name \n\n You have successfully changed your password! \n If you did not authorize
            this action please contact the Wildlife Center of VA Administrator.\n\n Please do not reply to this email")

            // Sets a basic body
            ->addPart("<q> Hello, $name <br><br> You have successfully changed your password! <br> If you did not authorize
            this action please contact the Wildlife Center of VA Administrator.<br><br> Please do not reply to this email</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    //Function for sending an account creation success email
    public function sendAccountSuccess()
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        //Gets the volunteer's name
        $name = $this->getRecieverName();
        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('WCV Account Creation Success')

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("Hello, $name \n\n You have successfully created an account! \n Please feel free to apply for any
            volunteer positions you may be interested in!\n\n Please do not reply to this email")

            // Sets a basic body
            ->addPart("<q> Hello, $name <br><br> You have successfully created an account! <br> Please feel free to apply for any
            volunteer positions you may be interested in!
            <br><br> Please do not reply to this email</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    //Function to send a custom outlook email
    public function sendEmailOutlook($message, $subject)
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject("$subject")

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("$message")

            // Sets a basic body
            ->addPart("<q> $message</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    //Function to send multiple emails
    public function sendMultiEmailOutlook($message, $subject, $emailArray)
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject("$subject")

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($emailArray)

            // Sets the body
            ->setBody("$message")

            // Sets a basic body
            ->addPart("<q> $message</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    //Function to send an application denial email
    public function sendApplicationDenied($position)
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        //Gets the volunteer's name
        $name = $this->getRecieverName();
        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('WCV Application')

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("Hello, $name \n\n Thank you for your interest in the Wildlife Center of Virginia. \n 
            Unfortunately, we have decided to pursue other applicants for the volunteer position: $position.
            \n\n Please do not reply to this email")

            // Sets a basic body
            ->addPart("<q> Hello, $name <br><br> Thank you for your interest in the Wildlife Center of Virginia. <br> 
            Unfortunately, we have decided to pursue other applicants for the volunteer position: $position.
            <br><br> Please do not reply to this email</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    //Function to send an application accepted email
    public function sendApplicationAccepted($position)
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        //Gets the volunteer's name
        $name = $this->getRecieverName();
        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('WCV Application')

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("Congratulations, $name \n\n You have been accepted for the $position position at the Wildlife Center of Virginia!
            \n\n Please do not reply to this email")

            // Sets a basic body
            ->addPart("<q> Congratulations, $name <br><br> 
            You have been accepted for the $position position at the Wildlife Center of Virginia!
            <br><br> Please do not reply to this email</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    //Function to send an email event reminder
    public function sendReminder($title, $start)
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        //Gets the team lead's name
        $name = $this->getRecieverName();
        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('WCV Event Reminder')

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("Hello, $name \n\n You have an upcoming Wildlife Center of VA event: $title. It will start $start.
            \n\n Please do not reply to this email")

            // Sets a basic body
            ->addPart("<q> Hello, $name <br><br> 
            You have an upcoming Wildlife Center of VA event: $title. It will start $start.
            <br><br> Please do not reply to this email</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    //Function to send an email to team lead that an application has been submitted for review
    public function sendPendingApplication($team)
    {
        //Gets the team lead email address

        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        //Gets the team lead's name
        $name = $this->getRecieverName();
        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('WCV Application for Review')

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("Hello, $name \n\n There is an $team application for your review. Please login to review the application.
            \n\n Please do not reply to this email")

            // Sets a basic body
            ->addPart("<q> Hello, $name <br><br> 
            There is an $team application for your review. Please login to review the application.
            <br><br> Please do not reply to this email</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }

    //Function to send that you have applies
    public function sendApplied($position)
    {
        // Create the Transport
        $transport = Swift_SmtpTransport::newInstance($this->getSmtpServer(), $this->getPortNumber(), 'tls')
            ->setUsername($this->getSenderUsername())
            ->setPassword($this->getSenderPassword())
        ;

        //Gets the volunteer's name
        $name = $this->getRecieverName();
        // Create the message
        $message = Swift_Message::newInstance()

            // Give the message a subject
            ->setSubject('WCV Application')

            // Set the From address with an associative array
            ->setFrom(array($this->getSenderEmail() => $this->getSenderName()))

            // Set the To addresses with an associative array
            ->setTo($this->getRecieverEmail())

            // Sets the body
            ->setBody("Hello, $name \n\n You have succesfully applied for the $position position at the Wildlife Center of Virginia!
            \n\n Please do not reply to this email")

            // Sets a basic body
            ->addPart("<q> Congratulations, $name <br><br> 
            You have succesfully applied for the $position position at the Wildlife Center of Virginia!
            <br><br> Please do not reply to this email</q>", 'text/html');

        // Send the message
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message);
    }
}
?>