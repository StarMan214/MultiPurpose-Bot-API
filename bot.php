<?php
 
$botToken = "yourbottoken";
$website = "https://api.telegram.org/bot".$botToken;
error_reporting(0);
$update = file_get_contents('php://input');
$update = json_decode($update, TRUE);
 $e = print_r($update);
 
function Capture($str, $starting_word, $ending_word){
  $subtring_start = strpos($str, $starting_word);
  $subtring_start += strlen($starting_word);
  $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
  return trim(preg_replace('/\s\s+/', '', strip_tags(substr($str, $subtring_start, $size))));
};

$chatId = $update["message"]["chat"]["id"];

$gId = $update["message"]["from"]["id"];
$userId = $update["message"]["from"]["id"];
$firstname = $update["message"]["from"]["first_name"];
$username = $update["message"]["from"]["username"];
$message = $update["message"]["text"];
$message_id = $update["message"]["message_id"];
$info = json_encode($update,JSON_PRETTY_PRINT);


$cmds11 = "<b>Hey!, I Am Up and Working ! Below I show you all available commands:</b>%0A%0A<u>Spotify Account Generator </u> <code>.spo or !spo or /spo Name|EMAIL|PASSWORD|PROXY </code>%0A%0A<u>Weather:</u> <code>.weather or !weather or /weather  YourCityName</code>%0A%0A<u>Youtube to MP3 :</u> <code>.song or !song or /song YourSongName</code>%0A%0A<u>URL Shortener:</u> <code>.url or !url or /url YourURL</code>%0A%0A Made with ❤️ by StArBoY";
 

if(strpos($message, "/start") === 0){
            sendMessage($chatId, "Hey Fella! I am a Multi-Purpose bot Send '/cmds' for a list of all commands!");
}
elseif(strpos($message, "!start") === 0){
            sendMessage($chatId, "Hey Fella! I am a Multi-Purpose bot Send '/cmds' for a list of all commands!");
}
elseif(strpos($message, ".start") === 0){
            sendMessage($chatId, "Hey Fella! I am a Multi-Purpose bot Send '/cmds' for a list of all commands!");
}
if(strpos($message, "/cmds") === 0){
            sendMessage($chatId, $cmds11);
}
elseif(strpos($message, "!cmds") === 0){
            sendMessage($chatId, $cmds11);
}
elseif(strpos($message, ".cmds") === 0){
            sendMessage($chatId, $cmds11);
}

#====================================================#
if (strpos($message, ".spo") === 0 || strpos($message, "!spo") === 0 || strpos($message, "/spo") === 0) {
$name = multiexplode(array(":", "|", ""), $message)[0];
$email = multiexplode(array(":", "|", ""), $message)[1];
$pass = multiexplode(array(":", "|", ""), $message)[2];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://spogentify.herokuapp.com/index.php');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
'Accept-Language: en-US,en;q=0.9',
'User-Agent: Mozilla/5.0 (Windows NT '.rand(11,99).'.0; Win64; x64) AppleWebKit/'.rand(111,999).'.'.rand(11,99).' (KHTML, like Gecko) Chrome/'.rand(11,99).'.0.'.rand(1111,9999).'.'.rand(111,999).' Safari/'.rand(111,999).'.'.rand(11,99).''
));
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($curl, CURLOPT_POSTFIELDS, 'name='.$name.'&email='.$email.'&password='.$pass.'');
$result = curl_exec($ch);
$unam = Capture($result, '"username": "', '"');

if ((strpos($result, '"status": true'))){
	$response = '✅ Spotify Account Created Successfully.\n Username : '.$unam.' \n Email : '.$email.' \n Password : '.$pass.' ';
sendMessage($chatId, $response);
}
elseif ((strpos($result, '"status": false'))) {
sendMessage($chatId, 'Account Creation Error : You seem to be using a proxy service. Please turn off these services and try again. For more help, please contact customer service.');
                
}       
}
#=================================================#

if (strpos($message, ".weather") === 0 || strpos($message, "!weather") === 0 || strpos($message, "/weather") === 0) {
$location = substr($message, 9);
$location = ucfirst($location);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://api.openweathermap.org/data/2.5/weather?q='.$location.'&appid=bd7c144d6f446bfed0546f70fab98751');
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Host: api.openweathermap.org',
'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:101.0) Gecko/20100101 Firefox/101.0',
'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
'Accept-Language: en-US,en;q=0.5',
));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, '');
$wth = curl_exec($ch);
$wth = json_decode($wth,true);
$weather = $wth["weather"][0]["main"];
$descp = $wth["weather"][0]["description"];
$name = $wth["name"];
$temp = $wth["main"]["temp"];
$pres = $wth["main"]["pressure"];
$humid = $wth["main"]["humidity"];
$country = $wth["sys"]["country"];
$ch = curl_close();

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => "https://congen-temperature-converter-v1.p.rapidapi.com/convert?from=Kelvin&to=Celsius&value=".$temp."&decimal=2",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => array(
		"content-type: application/json",
		"x-rapidapi-host: congen-temperature-converter-v1.p.rapidapi.com",
		"x-rapidapi-key: <api-key-youcangetitfromthesite>"
	),
));

$con = curl_exec($curl);
$con = json_decode($con,true);
$cel = $con["data"]["result"];
curl_close($curl);

if ($wth["name"] == ''.$location.'') {
	sendMessage($chatId, 'Weather at '.$location.' is: '.$weather.'%0A%0AWeather Description: '.$descp.'%0A%0Atemperature is: '.$cel.'%0A%0APressure is: '.$pres.'%0A%0AHumidity is: '.$humid.'%0A%0ACountry: '.$country.'');
}
else {
sendMessage($chatId, 'Invalid City');
}
}
#====================================================================#

elseif (strpos($message, ".song") === 0) {
$link = substr($message, 6);
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://coolguruji-youtube-to-mp3-download-v1.p.rapidapi.com/?id=ba5gwMMN1jM",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	CURLOPT_HTTPHEADER => [
		"x-rapidapi-host: coolguruji-youtube-to-mp3-download-v1.p.rapidapi.com",
		"x-rapidapi-key: <api-key-youcangetitfromthesite>"
	],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
	sendMessage($chatId, ''.$err.'');
} else {
	sendMessage($chatId, ''.$response.'');
}
}

//////////////////////////////////////////////////////////////

#================================================================#

if (strpos($message, ".url") === 0 || strpos($message, "!url") === 0 || strpos($message, "/url") === 0) {
$link = substr($message, 5);
/*str_replace(":", "%3A", $link);
str_replace("/", "%2F", $link);*/
$curl = curl_init();

curl_setopt_array($curl, [
	CURLOPT_URL => "https://url-shortener-service.p.rapidapi.com/shorten",
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_FOLLOWLOCATION => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "POST",
	CURLOPT_POSTFIELDS => "url=$link",
	CURLOPT_HTTPHEADER => [
		"X-RapidAPI-Host: url-shortener-service.p.rapidapi.com",
		"X-RapidAPI-Key: <api-key-youcangetitfromthesite>",
		"content-type: application/x-www-form-urlencoded"
	],
]);

$ur = curl_exec($curl);
$err = curl_error($curl);
$lnk = json_decode($ur,true);
$reslt = $lnk["result_url"];
curl_close($curl);

if ($err) {
	sendMessage($chatId, ''.$err.'');
} else {
	sendMessage($chatId, 'Here is your Shortlink: '.$reslt.'');
}
}
#=============================================================#

function sendMessage ($chatId, $message) {       
$url = $GLOBALS[website]."/sendMessage?chat_id=".$chatId."&text=".$message."&reply_to_message_id=".$message_id."&parse_mode=HTML";
file_get_contents($url);       
}
?>