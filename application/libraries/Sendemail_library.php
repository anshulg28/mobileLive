<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Sendemail_library
 * @property Offers_model $offers_model
 * @property Users_Model $users_model
 */
class Sendemail_library
{
    private $CI;

    function __construct()
    {
        $this->CI = &get_instance();
        $this->CI->load->model('offers_model');
        $this->CI->load->model('users_model');
        $this->CI->load->model('locations_model');
        $this->CI->load->model('dashboard_model');
    }

    //Not in use function
    public function signUpWelcomeSendMail($userData)
    {
        $data['mailData'] = $userData;
        $data['breakfastCode'] = $this->generateBreakfastCode($userData['mugId']);

        $content = $this->CI->load->view('emailtemplates/signUpWelcomeMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        if(isset($this->CI->userEmail))
        {
            $replyTo = $this->CI->userEmail;
            /*$userInfo = $this->CI->login_model->checkEmailSender($this->CI->userEmail);
            if(isset($userInfo) && myIsArray($userInfo))
            {
                $fromPass = $userInfo['gmailPass'];
                $fromEmail = $this->CI->userEmail;
            }*/

        }
        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';
        if(isset($this->CI->userFirstName))
        {
            $fromName = ucfirst($this->CI->userFirstName);
        }
        $subject = 'Breakfast for Mug #'.$userData['mugId'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function memberWelcomeMail($userData, $eventPlace)
    {
        $locData = $this->CI->locations_model->getLocationDetailsById($eventPlace);
        $mailRecord = $this->CI->users_model->searchUserByLoc($eventPlace);

        $data['locInfo'] = $locData['locData'][0];
        $data['commName'] = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $data['commName'] = $mailRecord['userData']['firstName'];
        }
        if($userData['eventCost'] == EVENT_PAID || $userData['eventCost'] == EVENT_DOOLALLY_FEE)
        {
            for($i=0;$i<(int)$userData['buyQuantity'];$i++)
            {
                if((int)$userData['doolallyFee'] > (int)NEW_DOOLALLY_FEE)
                {
                    $userData['eveOfferCode'][] = $this->generateCustomCode($userData['eventId'],$userData['bookerId'],$userData['doolallyFee']);
                }
                elseif((int)$userData['doolallyFee'] < (int)NEW_DOOLALLY_FEE && (int)$userData['doolallyFee'] != 0)
                {
                    $userData['eveOfferCode'][] = $this->generateCustomCode($userData['eventId'],$userData['bookerId'],$userData['doolallyFee']);
                }
                else
                {
                    $userData['eveOfferCode'][] = $this->generateEventCode($userData['eventId'],$userData['bookerId']);
                }
            }
        }
        $data['mailData'] = $userData;
        $startDate = str_replace(' ','T',date('Ymd His',strtotime($userData['eventDate'].' '.$userData['startTime'])));
        $endDate = str_replace(' ','T',date('Ymd His',strtotime($userData['eventDate'].' '.$userData['endTime'])));
        $data['calendar_url'] =
            'https://www.google.com/calendar/event?action=TEMPLATE'.
            '&text='.urlencode($userData["eventName"]).
            '&dates='.$startDate.'/'.$endDate.
            '&location='.urlencode('Doolally Taproom, '.$locData['locData'][0]['locName']).
            '&details='. urlencode($userData["eventDescrip"]).
            '&sprop=&sprop=name:';

        $content = $this->CI->load->view('emailtemplates/memberWelcomeMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $mailRecord['userData']['emailId'];

        $cc        = implode(',',$this->CI->config->item('ccList')).','.$replyTo;
        $fromName  = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $fromName = $mailRecord['userData']['firstName'];
        }

        $subject = 'You are attending '.$userData['eventName'];
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function eventRegSuccessMail($userData, $eventPlace)
    {
        $locData = $this->CI->locations_model->getLocationDetailsById($eventPlace);
        $mailRecord = $this->CI->users_model->searchUserByLoc($eventPlace);

        $data['locInfo'] = $locData['locData'][0];

        $data['commName'] = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $data['commName'] = $mailRecord['userData']['firstName'];
        }
        if($userData['eventCost'] == EVENT_PAID || $userData['eventCost'] == EVENT_DOOLALLY_FEE)
        {
            for($i=0;$i<(int)$userData['buyQuantity'];$i++)
            {
                if((int)$userData['doolallyFee'] > (int)NEW_DOOLALLY_FEE)
                {
                    $userData['eveOfferCode'][] = $this->generateCustomCode($userData['eventId'],$userData['bookerId'],$userData['doolallyFee']);
                }
                elseif((int)$userData['doolallyFee'] < (int)NEW_DOOLALLY_FEE && (int)$userData['doolallyFee'] != 0)
                {
                    $userData['eveOfferCode'][] = $this->generateCustomCode($userData['eventId'],$userData['bookerId'],$userData['doolallyFee']);
                }
                else
                {
                    $userData['eveOfferCode'][] = $this->generateEventCode($userData['eventId'],$userData['bookerId']);
                }
            }
        }
        $data['mailData'] = $userData;
        $startDate = str_replace(' ','T',date('Ymd His',strtotime($userData['eventDate'].' '.$userData['startTime'])));
        $endDate = str_replace(' ','T',date('Ymd His',strtotime($userData['eventDate'].' '.$userData['endTime'])));
        $data['calendar_url'] =
            'https://www.google.com/calendar/event?action=TEMPLATE'.
            '&text='.urlencode($userData["eventName"]).
            '&dates='.$startDate.'/'.$endDate.
            '&location='.urlencode('Doolally Taproom, '.$locData['locData'][0]['locName']).
            '&details='. urlencode($userData["eventDescrip"]).
            '&sprop=&sprop=name:';

        $content = $this->CI->load->view('emailtemplates/eventRegSuccessMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $mailRecord['userData']['emailId'];

        $cc        = implode(',',$this->CI->config->item('ccList')).','.$replyTo;
        $fromName  = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $fromName = $mailRecord['userData']['firstName'];
        }

        $subject = 'You are attending '.$userData['eventName'];
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }
    public function eventHostSuccessMail($userData, $eventPlace)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($eventPlace);

        $data['commName'] = 'Doolally';
        $data['commNum'] = $phons['Tresha'];
        if(isset($mailRecord['userData']['firstName']))
        {
            $data['commName'] = $mailRecord['userData']['firstName'];
            $data['commNum'] = $phons[$mailRecord['userData']['firstName']];
        }
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventHostInfoMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $mailRecord['userData']['emailId'];

        $cc        = implode(',',$this->CI->config->item('ccList')).','.$replyTo;
        $fromName  = 'Doolally';
        if(isset($mailRecord['userData']['firstName']))
        {
            $fromName = $mailRecord['userData']['firstName'];
        }

        $subject = 'You have a sign up for '.$userData['eventName'];
        $toEmail = $userData['hostEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }
    public function eventVerifyMail($userData)
    {
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData[0]['eventPlace']);
        $senderUser = 'U-0';

        if($mailRecord['status'] === true)
        {
            $senderUser = 'U-'.$mailRecord['userData']['userId'];
        }
        $userData['senderUser'] = $senderUser;

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventVerifyMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $mailRecord['userData']['emailId'];

        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';

        $subject = $userData[0]['eventName'].' On '.$userData[0]['eventDate'].' Review Details';
        $toEmail = 'events@brewcraftsindia.com';

        if($mailRecord['status'] === true)
        {
            $toEmail = $mailRecord['userData']['emailId'];
        }

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function eventEditMail($userData,$commPlace)
    {
        $mailRecord = $this->CI->users_model->searchUserByLoc($commPlace);
        $senderUser = 'U-0';

        if($mailRecord['status'] === true)
        {
            $senderUser = 'U-'.$mailRecord['userData']['userId'];
        }
        $userData['senderUser'] = $senderUser;

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventEditMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $mailRecord['userData']['emailId'];

        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';

        if(isset($userData['eventName']))
        {
            $subject = $userData['eventName'].' Event Data Modified';
        }
        else
        {
            $subject = 'Event Data Modified';
        }
        $toEmail = 'events@brewcraftsindia.com';

        if($mailRecord['status'] === true)
        {
            $toEmail = $mailRecord['userData']['emailId'];
        }

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function eventCancelMail($userData)
    {
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData[0]['eventPlace']);

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventCancelMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $mailRecord['userData']['emailId'];
        /*if(isset($userData[0]['creatorEmail']))
        {
            $fromEmail = $userData[0]['creatorEmail'];
        }*/
        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';

        $subject = $userData[0]['eventName'].' Event Cancel';
        $toEmail = 'events@doolally.in';

        if($mailRecord['status'] === true)
        {
            $toEmail = $mailRecord['userData']['emailId'];
        }

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function eventCancelUserMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData[0]['eventPlace']);
        if($mailRecord['status'] === true)
        {
            $senderName = $mailRecord['userData']['firstName'];
        }
        else
        {
            $senderName = 'Doolally';
        }
        $userData['senderName'] = $senderName;
        $userData['senderPhone'] = $phons[ucfirst($senderName)];

        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventCancelUserMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        if(isset($mailRecord['userData']['emailId']) && isStringSet($mailRecord['userData']['emailId']))
        {
            $replyTo = $mailRecord['userData']['emailId'];
        }
        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';
        if(isset($senderName) && isStringSet($senderName))
        {
            $fromName = ucfirst($senderName);
        }

        $subject = 'Event Cancel';
        $toEmail = $userData[0]['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    //Not in Use
    public function eventApproveMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $userData['senderPhone'] = $phons[ucfirst($userData['senderName'])];
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventApproveMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        if(isset($userData['senderEmail']) && isStringSet($userData['senderEmail']))
        {
            $replyTo = $userData['senderEmail'];
        }
        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';
        if(isset($userData['senderName']) && isStringSet($userData['senderName']))
        {
            $fromName = ucfirst($userData['senderName']);
        }

        $subject = 'Event Approved';
        $toEmail = $userData[0]['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }
    //Not in Use
    public function eventDeclineMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $userData['senderPhone'] = $phons[$userData['senderName']];
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/eventDeclineMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        if(isset($userData['senderEmail']) && isStringSet($userData['senderEmail']))
        {
            $replyTo = $userData['senderEmail'];
        }

        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';
        if(isset($userData['senderName']) && isStringSet($userData['senderName']))
        {
            $fromName = $userData['senderName'];
        }

        $subject = 'Sorry, your event has not been approved';
        $toEmail = $userData[0]['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function newEventMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData['eventPlace']);
        $senderName = 'Doolally';
        $senderEmail = 'events@brewcraftsindia.com';
        $senderPhone = $phons['Tresha'];

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        if($mailRecord['status'] === true)
        {
            $senderName = $mailRecord['userData']['firstName'];
            $senderEmail = $mailRecord['userData']['emailId'];
            $replyTo = $mailRecord['userData']['emailId'];
            $senderPhone = $phons[$senderName];
        }
        $userData['senderName'] = $senderName;
        $userData['senderEmail'] = $senderEmail;
        $userData['senderPhone'] = $senderPhone;
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/newEventMailView', $data, true);

        //$fromEmail = $senderEmail;

        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = $senderName;

        $subject = 'Event Details';
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    //Not in Use
    public function membershipRenewSendMail($userData)
    {
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/membershipRenewMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        if(isset($this->CI->userEmail))
        {
            $replyTo = $this->CI->userEmail;
            //$fromEmail = $this->CI->userEmail;
        }
        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';
        if(isset($this->CI->userFirstName))
        {
            $fromName = ucfirst($this->CI->userFirstName);
        }
        $subject = 'Renewal of Mug #'.$userData['mugId'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function generateBreakfastCode($mugId)
    {
        $allCodes = $this->CI->offers_model->getAllCodes();
        $usedCodes = array();
        $toBeInserted = array();
        if($allCodes['status'] === true)
        {
            foreach($allCodes['codes'] as $key => $row)
            {
                $usedCodes[] = $row['offerCode'];
            }
            $newCode = mt_rand(1000,99999);
            while(myInArray($newCode,$usedCodes))
            {
                $newCode = mt_rand(1000,99999);
            }
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Breakfast',
                'offerLoc' => null,
                'offerMug' => $mugId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }
        else
        {
            $newCode = mt_rand(1000,99999);
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Breakfast',
                'offerLoc' => null,
                'offerMug' => $mugId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }

        $this->CI->offers_model->setSingleCode($toBeInserted);
        return 'DO-'.$newCode;
    }

    public function sendEmail($to, $cc = '', $from, $fromPass, $fromName,$replyTo, $subject, $content, $attachment = array())
    {
        //Create the Transport
        /*$CI =& get_instance();
        $CI->load->library('swift_mailer/swift_required.php');*/

        require_once APPPATH.'libraries/swift_mailer/swift_required.php';

        $transport = Swift_SmtpTransport::newInstance ('smtp.gmail.com', 465, 'ssl')
            ->setUsername($from)
            ->setPassword($fromPass);
        //$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');

        $mailer = Swift_Mailer::newInstance($transport);

        //Create a message
        $message = Swift_Message::newInstance($subject)
            ->setSubject($subject)
            ->setReplyTo($replyTo)
            ->setReadReceiptTo($from)
            //->setCc($cc)
            ->setFrom(array($from => $fromName))
            ->setSender($replyTo)
            ->setTo($to) ->setBody($content, 'text/html');

        if($cc != '')
        {
            $message->setBcc(explode(',',$cc));
        }
        if(isset($attachment) && myIsMultiArray($attachment))
        {
            foreach($attachment as $key)
            {
                if($key != '')
                {
                    $message->attach(Swift_Attachment::fromPath($key));
                }
            }
        }
        //$message->attach($attachment);
        //Send the message
        $failedId = array();
        $status = 'Success';
        $errorMsg = implode(',',$failedId);

        try
        {
            $result = $mailer->send($message,$failedId);
            if(!$result)
            {
                $status = 'Failed';
                $errorMsg = implode(',',$failedId);
            }
        }
        catch(Swift_TransportException $st)
        {
            $status = 'Failed';
            $errorMsg = $st->getMessage();
        }
        catch(Exception $ex)
        {
            $status = 'Failed';
            $errorMsg = $ex->getMessage();
        }


        $logDetails = array(
            'messageId' => $message->getId(),
            'sendTo' => $to,
            'sendFrom' => $from,
            'sendFromName' => $fromName,
            'ccList' => $cc,
            'replyTo' => $replyTo,
            'mailSubject' => $subject,
            'mailBody' => $content,
            'attachments' => implode(',',$attachment),
            'sendStatus' => $status,
            'failIds' => $errorMsg,
            'sendDateTime' => date('Y-m-d H:i:s')
        );

        $this->CI->dashboard_model->saveSwiftMailLog($logDetails);
        return $status;
        /*$CI =& get_instance();
        $CI->load->library('email');
        $config['mailtype'] = 'html';
        $CI->email->clear(true);
        $CI->email->initialize($config);
        $CI->email->from($from, $fromName);
        $CI->email->to($to);
        if ($cc != '') {
            $CI->email->bcc($cc);
        }
        if(isset($attachment) && myIsArray($attachment))
        {
            foreach($attachment as $key)
            {
                $CI->email->attach($key);
            }
        }

        $CI->email->subject($subject);
        $CI->email->message($content);
        return $CI->email->send();*/
    }


    // Mail send to organiser about cancellation of attendee
    public function eventCancelSendMail($userData)
    {
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData['eventPlace']);
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/regisCancelMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        $cc = implode(',',$this->CI->config->item('ccList'));
        $fromName  = 'Doolally';
        if($mailRecord['status'] === true)
        {
            $fromName = $mailRecord['userData']['firstName'];
            $replyTo = $mailRecord['userData']['emailId'];
        }

        $subject = $userData['firstName'].' has withdrawn from '.$userData['eventName'];
        $toEmail = $userData['creatorEmail'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function attendeeCancelMail($userData)
    {
        $phons = $this->CI->config->item('phons');
        $mailRecord = $this->CI->users_model->searchUserByLoc($userData['eventPlace']);
        $senderName = 'Doolally';
        $senderEmail = 'events@doolally.in';
        $senderPhone = $phons['Tresha'];

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        if($mailRecord['status'] === true)
        {
            $senderName = $mailRecord['userData']['firstName'];
            $senderEmail = $mailRecord['userData']['emailId'];
            $replyTo = $mailRecord['userData']['emailId'];
            $senderPhone = $phons[$senderName];
        }
        $userData['senderName'] = $senderName;
        $userData['senderEmail'] = $senderEmail;
        $userData['senderPhone'] = $senderPhone;
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/attendeeCancelMailView', $data, true);

        //$fromEmail = $senderEmail;

        $cc        = implode(',',$this->CI->config->item('ccList'));
        $fromName  = $senderName;

        $subject = 'You have withdrawn from '.$userData['eventName'];
        $toEmail = $userData['emailId'];

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function refundFailSendMail($userData)
    {
        $data['mailData'] = $userData;

        $content = $this->CI->load->view('emailtemplates/refundFailMailView', $data, true);

        $fromEmail = DEFAULT_SENDER_EMAIL;
        $fromPass = DEFAULT_SENDER_PASS;
        $replyTo = $fromEmail;

        $cc        = '';
        $fromName  = 'Doolally';

        $subject = 'EventsHigh Refund Failed Booking Id '.$userData['bookingId'];
        $toEmail = array('saha@brewcraftsindia.com','anshul@brewcraftsindia.com','tresha@brewcraftsindia.com','taronish@brewcraftsindia.com');

        $this->sendEmail($toEmail, $cc, $fromEmail, $fromPass, $fromName,$replyTo, $subject, $content);
    }

    public function generateEventCode($eveId,$bookerId)
    {
        $allCodes = $this->CI->offers_model->getAllCodes();
        $usedCodes = array();
        $toBeInserted = array();
        if($allCodes['status'] === true)
        {
            foreach($allCodes['codes'] as $key => $row)
            {
                $usedCodes[] = $row['offerCode'];
            }
            $newCode = mt_rand(1000,99999);
            while(myInArray($newCode,$usedCodes))
            {
                $newCode = mt_rand(1000,99999);
            }
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Workshop',
                'offerLoc' => null,
                'offerMug' => '0',
                'offerEvent' => $eveId,
                'bookerPaymentId' => $bookerId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }
        else
        {
            $newCode = mt_rand(1000,99999);
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Workshop',
                'offerLoc' => null,
                'offerMug' => '0',
                'offerEvent' => $eveId,
                'bookerPaymentId' => $bookerId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }

        $this->CI->offers_model->setSingleCode($toBeInserted);
        return 'EV-'.$newCode;
    }

    public function generateCustomCode($eveId,$bookerId,$cusAmt)
    {
        $allCodes = $this->CI->offers_model->getAllCodes();
        $usedCodes = array();
        $toBeInserted = array();
        if($allCodes['status'] === true)
        {
            foreach($allCodes['codes'] as $key => $row)
            {
                $usedCodes[] = $row['offerCode'];
            }
            $newCode = mt_rand(1000,99999);
            while(myInArray($newCode,$usedCodes))
            {
                $newCode = mt_rand(1000,99999);
            }
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Rs '.$cusAmt,
                'offerLoc' => null,
                'offerMug' => '0',
                'offerEvent' => $eveId,
                'bookerPaymentId' => $bookerId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }
        else
        {
            $newCode = mt_rand(1000,99999);
            $toBeInserted = array(
                'offerCode' => $newCode,
                'offerType' => 'Rs '.$cusAmt,
                'offerLoc' => null,
                'offerMug' => '0',
                'offerEvent' => $eveId,
                'bookerPaymentId' => $bookerId,
                'isRedeemed' => 0,
                'ifActive' => 1,
                'createDateTime' => date('Y-m-d H:i:s'),
                'useDateTime' => null
            );
        }

        $this->CI->offers_model->setSingleCode($toBeInserted);
        return 'EV-'.$newCode;
    }

}
/* End of file */