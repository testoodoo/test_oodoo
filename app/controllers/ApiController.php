<?php

require 'vendor/autoload.php';

define('APPLICATION_NAME', 'Gmail API PHP Quickstart');
define('CREDENTIALS_PATH', '~/.credentials/gmail-php-quickstart.json');
define('CLIENT_SECRET_PATH', 'client_secret.json');
define('SCOPES', implode(' ', array(
  Google_Service_Gmail::MAIL_GOOGLE_COM)
));


class ApiController extends BaseController {


/**
 * Expands the home directory alias '~' to the full path.
 * @param string $path the path to expand.
 * @return string the expanded path.
 */

public function createMessage(){
	$message = 'id';
	$this->sendMessage($message);
}

// Get the API client and construct the service object.
/*$client = getClient();
$service = new Google_Service_Gmail($client);

// Print the labels in the user's account.
$user = 'me';
$results = $service->users_labels->listUsersLabels($user);

if (count($results->getLabels()) == 0) {
  print "No labels found.\n";
} else {
  print "Labels:\n";
  foreach ($results->getLabels() as $label) {
    printf("- %s\n", $label->getName());
  }
}
*/
/* public function list(){
 	$client = $this->getClient();
 	$service = new Google_Service_Gmail($client);
 	$userId = 'me';
 }
*/

public function listMessage() {
  $client = $this->getClient();
  $service = new Google_Service_Gmail($client);
  $userId= 'me';
  $pageToken = NULL;
  $messages = array();
  $opt_param = array();
  do {
    try {
      if ($pageToken) {
        $opt_param['pageToken'] = $pageToken;
      }
      $messagesResponse = $service->users_messages->listUsersMessages($userId, $opt_param);
      if ($messagesResponse->getMessages()) {
        $messages = array_merge($messages, $messagesResponse->getMessages());
        #var_dump($messages); die;
        $pageToken = $messagesResponse->getNextPageToken();
      }
    } catch (Exception $e) {
      print 'An error occurred: ' . $e->getMessage();
    }
  } while ($pageToken);

  foreach ($messages as $message) {
#    print 'Message with ID: ' . $message->getId() . '<br/>';
    $messge_id = $message->getId();
    $optParamsGet2['format'] = 'full';
    $single_message = $service->users_messages->get('me',$messge_id, $optParamsGet2);
    print 'Snippet is ' .$single_message->getSnippet().'<br/>';
    $data['snippet'] = $single_message->getSnippet();
  }
  return View::make('api.list',$data);
  #return $messages;
}

    public function updateMessage() {
            $client = $this->getClient();
            $service = new Google_Service_Gmail($client);
            $userId='me';
            $list = $service->users_messages->listUsersMessages($userId,['maxResults' => 1000]);
            $messageList = $list->getMessages();

            foreach($messageList as $mlist){
                $idCheck = InboxMail::where('message_id', $mlist->id)->get();
                if(count($idCheck) == 0){

                $optParamsGet2['format'] = 'full';
                $single_message = $service->users_messages->get('me',$mlist->id, $optParamsGet2);
                #var_dump($single_message->getPayload()->getFilename());die;
                #$raw = $single_message->getRaw();  // while using $optParamsGet2 "format" is "raw" instead of "full"
                $messageId = $single_message->getId();
                $threadId = $single_message->getThreadId();
                $historyId = $single_message->getHistoryId();
                $labelIds = $single_message->getLabelIds();
                #var_dump(json_decode(json_encode($labelIds))); die;

                $headers = $single_message->getPayload()->getHeaders();
                    foreach ($headers as $header) {
                        if ($header->getName() == 'Subject') {
                            $subject = $header->getValue();         
                        }
                        if($header->getName() == 'From'){
                            $from = $header->getValue();
                        }
                        if($header->getName() == 'To'){
                            $to = $header->getValue();
                            #var_dump($to); die;
                        } 
                        if ($header->getName() == 'Date') {
                            $message_date = $header->getValue();
                            $time = date('Y-m-d H:i:s', strtotime($message_date));
                        }

                }
                /*  body message   */
                $body = $single_message->getPayload()->getBody();
                $body_new = decode_body($body['data']);
                if(!$body_new){
                    $parts = $single_message->getPayload()->getParts();
                    foreach($parts as $part){
                        if($part['body']) {
                            $body_new = decode_body($part['body']->data);
                            if($body_new === true){
                                break;
                            }
                        }
                        if($part['parts'] && !$body_new) {
                            foreach ($part['parts'] as $p) {
                                if($p['mimeType'] === 'text/plain' && $p['body']) {
                                    $body_new = decode_body($p['body']->data);
                                    break;
                                }
                            }
                        }
                        if($body_new) {
                            break;
                        }
                    }
                }
                $body = $body_new;

                //attachment success
                unset($attachment);
                $parts = $single_message->getPayload()->getParts();
                foreach ($parts as $part ) {
                    if ($part->getFilename() != null && strlen($part->getFilename())   > 0) {
                        $filename = $part->getFilename();
                        $attId = $part->getBody()->getAttachmentId();
                        $attachPart = $service->users_messages_attachments->get($userId, $messageId, $attId);
                        $attachPart = strtr($attachPart->getData() , "-_" , "+/" );
                        $code_base64 = $attachPart;
                        $code_binary = base64_decode($code_base64);
                        $file_ext = new SplFileInfo($filename);
                        $file_ext = $file_ext->getExtension();
                        $file_hash = hash('sha256', $attId);
                        $file_location = '/tmp/'.$file_hash.'.'.$file_ext;
                        #var_dump($file_ext); die;
                        file_put_contents($file_location, $code_binary);
                        #echo "Your attachment ". $filename." with id ".$attId." saved succesfully at ".$file_location;
                        $attachment[] = [
                        'filename' => $filename,
                        'attachmentId' => $attId,
                        'filelocation' => $file_location
                        ];
                        // $image= imagecreatefromstring($code_binary);
                        // header('Content-Type: image/jpeg');
                        // imagejpeg($image);
                        // imagedestroy($image);
                    }
                }



                    $inboxmail=new InboxMail();
                    $inboxmail->message_id = $mlist->id;
                    $inboxmail->thread_id = $threadId;
                    $inboxmail->history_id = $historyId;
                    $inboxmail->label = $labelIds['0'];
                    $inboxmail->subject = $subject;
                    $inboxmail->from_mail = $from;
                    $inboxmail->to_mail = $to;
                    $inboxmail->body = $body;
                    if(isset($attachment)){
                        $inboxmail->attachment = json_encode($attachment);
                    }
                    $inboxmail->time = $time;
                    $inboxmail->save();

            }   

        }



    }

        public function mailMessage(){
            return View::make('api.mail');
        }

        public function inboxMail(){
            $inboxMail = InboxMail::where('label','INBOX')->get();
            #var_dump($inboxMail);
            return $inboxMail;
        }



public function getMessageo() {
    $client = $this->getClient();
    $service = new Google_Service_Gmail($client);
    $userId='me';
$list = $service->users_messages->listUsersMessages($userId,['maxResults' => 20]);

    $messageList = $list->getMessages();
    $inboxMessage = [];

    foreach($messageList as $mlist){

        $optParamsGet2['format'] = 'full';
        #$optParamsGet2['labelIds'] = 'INBOX';
        $single_message = $service->users_messages->get('me',$mlist->id, $optParamsGet2);
        if(($single_message->getLabelIds()['0'] == 'INBOX')){    //to receive only inbox
        $message_id = $mlist->id;
        $headers = $single_message->getPayload()->getHeaders();
        $snippet = $single_message->getSnippet();
        # var_dump($snippet); die;

        foreach($headers as $single) {

            if ($single->getName() == 'Subject') {

                $message_subject = $single->getValue();

            }

            else if ($single->getName() == 'Date') {

                $message_date = $single->getValue();
                $message_date = date('M jS Y h:i A', strtotime($message_date));
            }

            else if ($single->getName() == 'From') {

                $message_sender = $single->getValue();
                $message_sender = str_replace('"', '', $message_sender);
            }
        }


         $inboxMessage['data'][] = [
            'messageId' => $message_id,
            'messageSnippet' => $snippet,
            'messageSubject' => $message_subject,
            'messageDate' => $message_date,
            'messageSender' => $message_sender
        ];

       # $inboxMessage = json_decode($inboxMessage);
        #var_dump($inboxMessage); die;

    }
  }
    #return $inboxMessage;
    return View::make("api.list",$inboxMessage);
}
public function replyMessage() {
  try {
  	$client = $this->getClient();
  	$service = new Google_Service_Gmail($client);
 	  $userId = 'me';
    $from = Input::get('from');
    $to = Input::get('to');
    $subject = Input::get('subject');
    $from_name = Input::get('from_name');
    $to_name = Input::get('to_name');
    $body = Input::get('body');
    $message = new Google_Service_Gmail_Message();
    $text = 'From: '.$from_name.' <'.$from.'>
To: '.$to_name.' <'.$to.'>
Subject:'.$subject.'

'.$body.'';
#var_dump($text); die;


  $encoded_message = rtrim(strtr(base64_encode($text), '+/', '-_'), '=');
  $message->setRaw($encoded_message);
  #var_dump($message); die;
    $message = $service->users_messages->send($userId, $message);
      $inboxmail=new InboxMail();
      $inboxmail->messageid = $message->getId();
      $inboxmail->subject = $subject;
      $inboxmail->from_mail = $from;
      $inboxmail->to_mail = $to;
      $time = date('Y-m-d H:i:s');
      $inboxmail->time = $time;
      $inboxmail->body = $body;
      $inboxmail->save();
    print 'Message with ID: ' . $message->getId() . ' sent.';
    return $message;
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }
}

public function showMessage($messageId){
  $client = $this->getClient();
  $service = new Google_Service_Gmail($client);
  $userId = 'me';
  $optParamsGet2['format'] = 'full';

  $message = $service->users_messages->get($userId,$messageId, $optParamsGet2);
  #print 'Message with ID: ' . $message->getId() . ' retrieved.';
  #print_r($message); die;

  $parts = $message->getPayload()->getParts();
  #var_dump($parts); die;
  foreach ($parts as $part ) {

    #echo 'hi';
    //attachment success
    if ($part->getFilename() != null && strlen($part->getFilename())   > 0) {
    
        $filename = $part->getFilename();
        $attId = $part->getBody()->getAttachmentId();
        $attachPart = $service->users_messages_attachments->get($userId, $messageId, $attId);
        $attachPart = strtr($attachPart->getData() , "-_" , "+/" );
        $code_base64 = $attachPart;
        var_dump($code_base64); die;
        $code_binary = base64_decode($code_base64);
        $file_ext = new SplFileInfo($filename);
        $file_ext = $file_ext->getExtension();
        $file_hash = hash('sha256', $attId);
        $file_location = '/tmp/'.$file_hash.'.'.$file_ext;
        file_put_contents($file_location, $code_binary);
        #echo "Your attachment ". $filename." with id ".$attId." saved succesfully at ".$file_location;
        // $image= imagecreatefromstring($code_binary);
        // header('Content-Type: image/jpeg');
        // imagejpeg($image);
        // imagedestroy($image);

     }
   } 

  // #echo '<img src="data:image/png;base64, '.$hello.'" alt="summa" />'; die;
  
  // $hello = "ANGjdJ-kDPFTGQyAhWUQKYNoVBkoY3e_DzcBfLKo_nU8AwqhrkFGXqqcVPPXs0lrd1tgn8jr-JOSEGbtAxZP2l1wAbScMkq8ZU9ylGanY3dF038gOuHBtU86hD0vp8bpiLE_CA4TNep-IPQHfBWDIOdUK5gNNJYcJD3qa34OEri90c5rFBtTSDUiN8QKa-cZtiBcZ27k-aVdcE8Na3J-4cC43gAbtGA5jtvsYa1Yh1rUEA3q3uhRqXbIXIo5sQ9J6cpDKP-SpI4LzyI6OkxPXij0Lzo81nN6_7L7AbWuSXBGI947Nh5ykmYdU4iga_c".'==';
  // $decoded = strtr($hello, "-_", "+/");
  // echo $hello;die;
  // header("Content-type: image/jpeg");


  //  body message
  $body = $message->getPayload()->getBody();
  $body_new = decode_body($body['data']);
  if(!$body_new){
   $parts = $message->getPayload()->getParts();
   foreach($parts as $part){
    if($part['body']) {
                        $body_new = decode_body($part['body']->data);
                        if($body_new === true){
                          break;
                        }
                    }

                    if($part['parts'] && !$body_new) {
                        foreach ($part['parts'] as $p) {
                            if($p['mimeType'] === 'text/plain' && $p['body']) {
                              #var_dump($p['body']->data); die;
                                $body_new = decode_body($p['body']->data);
                                #print_r($body_new); die;
                                break;
                            }
                        }
                    }
                    if($body_new) {
                        break;
                    }
                }
            }
  $data['body'] = $body = $body_new;
  #var_dump($body_new); die;


  // attachment
  $attachment = $message->getPayload()->getParts();

  #var_dump($attachment); die;
  $hi = array_flatten($attachment);



  // headers like from, to, date, names, subject         
  $headers = $message->getPayload()->getHeaders();
  foreach ($headers as $header) {
        if ($header->getName() == 'Subject') {
          $data['subject'] = $subject = $header->getValue();         
        }
        if($header->getName() == 'From'){
          $data['from'] = $from = $header->getValue();
        }
        if($header->getName() == 'To'){
          $data['to'] = $to = $header->getValue();
        } 
        if($header->getName() == 'Received-SPF'){
          $data['messageSender'] = $messgeSender = $messageSender = email_address($header->getValue());
        }
        if($header->getName() == 'Delivered-To'){
          $data['messageTo'] = $messageTo = $messageTo = $to_mail = email_address($header->getValue());
        }
        if ($header->getName() == 'Date') {
          $message_date = $header->getValue();
          $data['time'] = $time = date('Y-m-d H:i:s', strtotime($message_date));
        }

  }

  // inbox message working fine
  /*if (preg_match('#^Re: #', $subject) === 1) {
    $body = $message->getPayload()->body['data'];
  }else{
    $body = $message->getPayload()->getParts()['0']->body['data'];
    $body = $message->getPayload()->getParts()['1']->body['data'];
  #}*/
  //$data['body'] = $body = base64_decode(str_pad(strtr($body, '-_', '+/'), strlen($body) % 4, '=', STR_PAD_RIGHT));

  $idCheck = InboxMail::where('messageid', $message->id)->get();
    if(count($idCheck) == 0){
      $inboxmail=new InboxMail();
      $inboxmail->messageid = $message->id;
      $inboxmail->subject = $subject;
      $inboxmail->from_mail = $messageSender;
      $inboxmail->to_mail = $messageTo;
      $inboxmail->time = $time;
      $inboxmail->body = $body;
      $inboxmail->save();
  }

  return View::make('api.show', $data);
}






public function getClient() {
  $client = new Google_Client();
  $client->setApplicationName(APPLICATION_NAME);
  $client->setScopes(SCOPES);
  $client->setAuthConfigFile(CLIENT_SECRET_PATH);
  $client->setAccessType('offline');

  // Load previously authorized credentials from a file.
  $credentialsPath = $this->	expandHomeDirectory(CREDENTIALS_PATH);
  if (file_exists($credentialsPath)) {
    $accessToken = file_get_contents($credentialsPath);
  } else {
    // Request authorization from the user.
    $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->authenticate($authCode);

    // Store the credentials to disk.
    if(!file_exists(dirname($credentialsPath))) {
      mkdir(dirname($credentialsPath), 0700, true);
    }
    file_put_contents($credentialsPath, $accessToken);
    printf("Credentials saved to %s\n", $credentialsPath);
  }
  $client->setAccessToken($accessToken);

  // Refresh the token if it's expired.
  if ($client->isAccessTokenExpired()) {
    $client->refreshToken($client->getRefreshToken());
    file_put_contents($credentialsPath, $client->getAccessToken());
  }
  return $client;
}
public function expandHomeDirectory($path) {
  $homeDirectory = getenv('HOME');
  if (empty($homeDirectory)) {
    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
  }
  return str_replace('~', realpath($homeDirectory), $path);
}
}

function email_address($string) {
    foreach(preg_split('/\s/', $string) as $token) {
        $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        if ($email !== false) {
                    return $email;
                }
            }

}

function decode_body($body) {
    $rawData = $body;
    $sanitizedData = strtr($rawData,'-_', '+/');
    $decodedMessage = base64_decode($sanitizedData);
    if(!$decodedMessage){
        $decodedMessage = FALSE;
    }
    return $decodedMessage;

}
