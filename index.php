<?php
/*
{
   "events":[
      {
         "replyToken":"nHuyWiB7yP5Zw52FIkcQobQuGDXCTA",
         "type":"message",
         "timestamp":1462629479859,
         "source":{
            "type":"user",
            "userId":"U206d25c2ea6bd87c17655609a1c37cb8"
         },
         "message":{
            "id":"325708",
            "type":"image"
         }
      }
   ]
}
 */

require_once('./vendor/autoload.php');

// Namespace
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;

// Token
$channel_token = 'lZ+WXE4At+V8NlwkInMHC5wJAvpeeKnCt197Y7l1CVfzSG6uhdee6tVMhG/Esk2GEmFAjl7gvElqWawH4o7AUJxGnKbhpogowCJqIA1cQ57oIF/4qF8CrOx7f0K4RCUjqUy3urKNf4xFaPhCl+faGAdB04t89/1O/w1cDnyilFU=';
$channel_secret = '85a055cff00c5ca119e5ded3225bfdf3';

// LINEBot
$httpClient = new CurlHTTPClient($channel_token);
$bot = new LINEBot($httpClient, array('channelSecret' => $channel_secret));

// Get message from Line API
$content = file_get_contents('php://input');
$events = json_decode($content, true);

if (!is_null($events['events'])) {

	// Loop through each event
	foreach ($events['events'] as $event) {
    
        // Line API send a lot of event type, we interested in message only.
		if ($event['type'] == 'message') {

            // Get replyToken
            $replyToken = $event['replyToken'];
            
            switch($event['message']['type']) {
                
                case 'sticker': 
					$messageID = $event['message']['packageId']; 
					// Reply message 
					$respMessage = 'Hello, your Sticker Package ID is '. $messageID; 
					break;
                default:
                    // Reply message
                    $respMessage = 'Please send image only';
                    break;
            }

            $textMessageBuilder = new TextMessageBuilder($respMessage);
            $response = $bot->replyMessage($replyToken, $textMessageBuilder);
		}
	}
}

echo "OK";
