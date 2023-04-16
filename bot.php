<?php
$path = "https://api.telegram.org/bot<token>";
$update = json_decode(file_get_contents("php://input"), TRUE);

// User's info
$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];
$name = $update["message"]["chat"]["first_name"];
$messageID = $update["message"]["message_id"];
$userID = $update["message"]["chat"]["id"];

$askMeWeather = $path."/sendmessage?chat_id=".$chatId.$name."&text=You can ask me about the weather. Just type: /weather <city_name>";

$data = file_get_contents("id.txt");
if (strpos($data, $userID) === false){
    file_put_contents("id.txt", $userID.PHP_EOL, FILE_APPEND);
    $greeting = $path."/sendmessage?chat_id=".$chatId."&text=Hi ".$name;
    $analyzing = $path."/sendmessage?chat_id=".$chatId."&text=Analyzing user's profile";
    $dots = $path."/sendmessage?chat_id=".$chatId."&text=...";
    $gay = $path."/sendmessage?chat_id=".$chatId.$name."&text=You are so gay!";

    file_get_contents($greeting);
    file_get_contents($analyzing);
    file_get_contents($dots);
    sleep(2);
    file_get_contents($gay);

    // json
    $json = json_encode($update, JSON_PRETTY_PRINT);
    $file = fopen("./$name.json",'w');
    fwrite($file,$json);
    fclose($file); 
}

$w_api = "open_weather_api_key"; 
if (strpos($message, "/weather") === 0) {
$location = substr($message, 9);
$weather = json_decode(file_get_contents("https://api.openweathermap.org/data/2.5/weather?q=".$location."&appid=$w_api"), TRUE)["weather"][0]["main"];
file_get_contents($path."/sendmessage?chat_id=".$chatId."&text=Here's the weather in ".$location.": ". $weather);
} else {
    file_get_contents($askMeWeather);
}
?>