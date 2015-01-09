<?php

$module = $_POST["module"];

echo $module;

exec('osascript close_all_chrome_tabs.scpt');

if($module == "start"){
	exec('osascript -e \'tell app "iTunes" to play the playlist "Morning"\'');	
}else if($module == "code"){
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Music"\'');
	exec('osascript -e \'open app "Xcode"\'');
	exec('osascript -e \'open app "Slack"\'');
	exec('osascript -e \'open location "http://www.asana.com"\'');
	exec('osascript -e \'open location "http://www.konotor.com"\'');
} else if($module == "stop"){
	exec('osascript close_all_apps.scpt');
	//exec('osascript -e \'open location "https://www.youtube.com/watch?v=1dWjKkF0Zi4"\'');
}else if($module == "write"){
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Classical Music"\'');	
	exec('osascript -e \'open app "Sublime Text"\'');
}else if($module == "ukulele"){
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'open location "http://analogmusicstudios.com/sublime-santeria-ukulele-chords/"\'');
}else if($module == "backtest"){
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell application "Finder" to open POSIX file "/Users/fhm/VirtualBox VMs/Windows/Windows.vbox"\'');
	exec('osascript -e \'tell application "Finder" to open POSIX file "/Users/fhm/Dropbox/Personal/Trading/Live Account copy.xlsx"\'');
	exec('osascript -e \'open location "http://www.forexfactory.com"\'');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Music"\'');
}else if($module == "analytics"){
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Music"\'');
	exec('osascript -e \'open location "https://mixpanel.com/report/477109/events/#events"\'');
	exec('osascript -e \'open location "https://www.google.com/analytics/web/?hl=en#report/app-overview/a49381420w81115025p83961631/"\'');
	exec('osascript -e \'open location "https://crashlytics.com/teamstory/ios/apps/com.growple.teamstory/answers/daily_active_users"\'');
	exec('osascript -e \'open location "https://docs.google.com/spreadsheets/d/0AgYLId9W6abVdHdFbnVSZXBWT3BHZnlnUzhhSU1kM1E/edit?usp=drive_web"\'');
}


/*
// exec('osascript -e \'open app "VirtualBox"\'');
exec('osascript -e \'open location "http://www.parse.com"\'');
exec('osascript -e \'open location "http://www.mixpanel.com"\'');
exec('osascript -e \'open location "http://www.konotor.com"\'');

*/




/*

require_once('asana/asana.php');


$asana = new Asana(array('apiKey' => '5UzF19L.SoZjl5V2gQs2zLAeVFi99TgM')); // Your API Key, you can get it in Asana
$projectId = '12900577908762'; // Your Project ID Key, you can get it in Asana

$result = $asana->getProjectTasks($projectId);

// As Asana API documentation says, when response is successful, we receive a 200 in response so...
if ($asana->responseCode != '200' || is_null($result)) {
    echo 'Error while trying to connect to Asana, response code: ' . $asana->responseCode;
    return;
}


echo $result;
*/