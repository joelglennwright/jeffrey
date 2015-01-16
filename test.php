<?php

$module = $_POST["module"];

echo $module;

if($module == "start"){
	exec('osascript bright_screen.scpt');	
	exec('osascript -e \'tell application "System Events" to tell process "iTunes" to click menu item 1 of menu 1 of menu item "Shuffle" of menu 1 of menu bar item "Controls" of menu bar 1\'');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Morning"\'');
}else if($module == "code"){
	exec('osascript close_all_chrome_tabs.scpt');
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Music"\'');
	exec('osascript -e \'tell application "System Events" to tell process "iTunes" to click menu item 1 of menu 1 of menu item "Shuffle" of menu 1 of menu bar item "Controls" of menu bar 1\'');
	exec('osascript -e \'tell application "Xcode" to activate\'');
	exec('osascript -e \'tell application "Slack" to activate\'');
	exec('osascript -e \'open location "https://app.asana.com/"\'');
	exec('osascript -e \'open location "http://app.konotor.com/app/home#/"\'');
	exec('osascript -e \'tell application "System Events" to set frontmost of process "Slack" to true\'');
} else if($module == "stop"){
	exec('osascript close_all_chrome_tabs.scpt');
	exec('osascript -e \'tell app "iTunes" to quit\'');
	exec('osascript close_all_apps.scpt');
	exec('osascript dim_screen.scpt');
}else if($module == "write"){
	exec('osascript close_all_chrome_tabs.scpt');
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Classical Music"\'');	
	exec('osascript -e \'tell application "System Events" to tell process "iTunes" to click menu item 1 of menu 1 of menu item "Shuffle" of menu 1 of menu bar item "Controls" of menu bar 1\'');
	exec('osascript -e \'tell application "Sublime Text" to activate\'');
	exec('osascript -e \'open location "https://app.asana.com/0/23952007863201/23952007863201/"\'');
	exec('osascript -e \'tell application "System Events" to set frontmost of process "Sublime Text" to true\'');
}else if($module == "ukulele"){
	exec('osascript close_all_chrome_tabs.scpt');
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'open location "http://analogmusicstudios.com/sublime-santeria-ukulele-chords/"\'');
	exec('osascript -e \'tell application "iTunes" to stop\'');
	exec('osascript -e \'open location "https://app.asana.com/0/2875518286351/2875518286351/"\'');
	exec('osascript -e \'tell application "System Events" to set frontmost of process "Google Chrome" to true\'');
}else if($module == "backtest"){
	exec('osascript close_all_chrome_tabs.scpt');
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell application "Finder" to open POSIX file "/Users/fhm/VirtualBox VMs/Windows/Windows.vbox"\'');
	exec('osascript -e \'tell application "Finder" to open POSIX file "/Users/fhm/Dropbox/Personal/Trading/Live Account copy.xlsx"\'');
	exec('osascript -e \'open location "http://www.forexfactory.com"\'');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Music"\'');
	exec('osascript -e \'tell application "System Events" to tell process "iTunes" to click menu item 1 of menu 1 of menu item "Shuffle" of menu 1 of menu bar item "Controls" of menu bar 1\'');
	exec('osascript -e \'open location "https://app.asana.com/0/23952007863199/23952007863199"\'');
	exec('osascript -e \'tell application "System Events" to set frontmost of process "Virtual Box" to true\'');
}else if($module == "analytics"){
	exec('osascript close_all_chrome_tabs.scpt');
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Music"\'');
	exec('osascript -e \'tell application "System Events" to tell process "iTunes" to click menu item 1 of menu 1 of menu item "Shuffle" of menu 1 of menu bar item "Controls" of menu bar 1\'');
	exec('osascript -e \'tell application "Slack" to activate\'');
	exec('osascript -e \'open location "https://mixpanel.com/report/477109/events/#events"\'');
	exec('osascript -e \'open location "https://www.google.com/analytics/web/?hl=en#report/app-overview/a49381420w81115025p83961631/"\'');
	exec('osascript -e \'open location "https://crashlytics.com/teamstory/ios/apps/com.growple.teamstory/answers/daily_active_users"\'');
	exec('osascript -e \'open location "https://docs.google.com/spreadsheets/d/0AgYLId9W6abVdHdFbnVSZXBWT3BHZnlnUzhhSU1kM1E/edit?usp=drive_web"\'');
	exec('osascript -e \'tell application "System Events" to set frontmost of process "Google Chrome" to true\'');
}else if($module == "music"){
	exec('osascript -e \'tell app "iTunes" to play the playlist "Music"\'');
	exec('osascript -e \'tell application "System Events" to tell process "iTunes" to click menu item 1 of menu 1 of menu item "Shuffle" of menu 1 of menu bar item "Controls" of menu bar 1\'');
}else if($module == "next"){
	exec('osascript -e \'tell app "iTunes" to play next track\'');
}else if($module == "stop_music"){
	exec('osascript -e \'tell application "iTunes" to stop\'');
}else if($module == "jeffrey"){
	exec('osascript close_all_chrome_tabs.scpt');
	exec('osascript close_all_apps.scpt');
	exec('osascript -e \'tell app "iTunes" to play the playlist "Music"\'');
	exec('osascript -e \'tell application "System Events" to tell process "iTunes" to click menu item 1 of menu 1 of menu item "Shuffle" of menu 1 of menu bar item "Controls" of menu bar 1\'');
	exec('osascript -e \'tell application "Sublime Text" to activate\'');
	exec('osascript -e \'open location "https://app.asana.com/0/23952007863213/23952007863213"\'');
	exec('osascript -e \'tell application "System Events" to set frontmost of process "Sublime Text" to true\'');
}else if($module == "off"){
	exec('osascript dim_screen.scpt');
}else if($module == "back"){
	exec('osascript bright_screen.scpt');
}


//exec('osascript -e \'tell application "iTunes" to set sound volume to (sound volume + 40)\'');


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