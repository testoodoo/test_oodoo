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

public function getMessage() {
	$client = $this->getClient();
	$service = new Google_Service_Gmail($client);
	$userId='me';
$list = $service->users_messages->listUsersMessages('me',['maxResults' => 20]);

    $messageList = $list->getMessages();
    $inboxMessage = [];

    foreach($messageList as $mlist){

        $optParamsGet2['format'] = 'full';
        $single_message = $service->users_messages->get('me',$mlist->id, $optParamsGet2);

        $message_id = $mlist->id;
        $headers = $single_message->getPayload()->getHeaders();
        $snippet = $single_message->getSnippet();

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
    #return $inboxMessage;
    return View::make("api.list",$inboxMessage);
}
public function sendMessage() {
  try {
  	$client = $this->getClient();
  	$service = new Google_Service_Gmail($client);
 	$userId = 'me';
    $message = new Google_Service_Gmail_Message();
    $text = 'From: John Doe <test.oodoo@gmail.com>
To: Mary Smith <prakashsankark@gmail.com>
Subject: Saying Hello

This is a message just to say hello.
So, "Hello"';


	$encoded_message = rtrim(strtr(base64_encode($text), '+/', '-_'), '=');
	$message->setRaw($encoded_message);
    $message = $service->users_messages->send($userId, $message);
    print 'Message with ID: ' . $message->getId() . ' sent.';
    return $message;
  } catch (Exception $e) {
    print 'An error occurred: ' . $e->getMessage();
  }
}

public function showMessage($messageId) {
  $client = $this->getClient();
  $service = new Google_Service_Gmail($client);
  $userId = 'me';
  $optParamsGet2['format'] = 'full';

    $data['message'] = $message = $service->users_messages->get('me',$messageId, $optParamsGet2);
    $array_flatten = array_flatten($message); 
    #var_dump($array_flatten); die;
    $subject = $array_flatten[array_search("Subject", $array_flatten)+1];
    $messageSender = $array_flatten[array_search("Received-SPF", $array_flatten)+1];
    $messageSender = email_address($messageSender);
    $messageTo = $array_flatten[array_search("Delivered-To", $array_flatten)+1];
    $from = $array_flatten[array_search("From", $array_flatten)+1];
    $to = $array_flatten[array_search("To", $array_flatten)+1 ];
    var_dump($messageSender); die;

    $data['subject'] = $array_flatten[$subject+1];
    foreach($return as $ret){
      var_dump($ret->From); die;
    }

    $data = base64_decode(str_pad(strtr($message->raw, '-_', '+/'), strlen($message->raw) % 4, '=', STR_PAD_RIGHT));
    # var_dump($message['payload']['headers']['12']['value']); die;
   











    $body = $message['payload']['parts']['0']['body']['data'];
    $sender = $message['payload']['headers']['5']['value'];
    $data['body'] = base64_decode(str_pad(strtr($body, '-_', '+/'), strlen($body) % 4, '=', STR_PAD_RIGHT));

  
  return View::make('api.show', $data);
}
public function array_flatten($array) { 
  if (!is_array($array)) { 
    return FALSE; 
  } 
  $result = array(); 
  foreach ($array as $key => $value) { 
    if (is_array($value)) { 
      $arrayList=array_flatten($value);
      foreach ($arrayList as $listItem) {
        $result[] = $listItem; 
      }
    } 
   else { 
    $result[$key] = $value; 
   } 
  } 
  return $result; 
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
