<html>
<head> 
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.0.2/jquery.simpleWeather.min.js"></script>
</head>
<title>Web Speech API Demo</title>
<style>
  * {
    font-family: Verdana, Arial, sans-serif;
  }
  a:link {
    color:#000;
    text-decoration: none;
  }
  a:visited {
    color:#000;
  }
  a:hover {
    color:#33F;
  }
  .button {
    background: -webkit-linear-gradient(top,#008dfd 0,#0370ea 100%);
    border: 1px solid #076bd2;
    border-radius: 3px;
    color: #fff;
    display: none;
    font-size: 13px;
    font-weight: bold;
    line-height: 1.3;
    padding: 8px 25px;
    text-align: center;
    text-shadow: 1px 1px 1px #076bd2;
    letter-spacing: normal;
  }
  .center {
    padding: 10px;
    text-align: center;
  }
  .final {
    color: black;
    padding-right: 3px; 
  }
  .interim {
    color: gray;
  }
  .info {
    font-size: 14px;
    text-align: center;
    color: #777;
    display: none;
  }
  .right {
    float: right;
  }
  .sidebyside {
    display: inline-block;
    width: 45%;
    min-height: 40px;
    text-align: left;
    vertical-align: top;
  }
  #headline {
    font-size: 40px;
    font-weight: 300;
  }
  #info {
    font-size: 20px;
    text-align: center;
    color: #777;
    visibility: hidden;
  }
  #results {
    font-size: 14px;
    font-weight: bold;
    border: 1px solid #ddd;
    padding: 15px;
    text-align: left;
    min-height: 150px;
  }
  #start_button {
    border: 0;
    background-color:transparent;
    padding: 0;
  }
</style>
<h1 class="center" id="headline">
  <a href="http://dvcs.w3.org/hg/speech-api/raw-file/tip/speechapi.html">
    Web Speech API</a> Demonstration</h1>
<div id="info">
  <p id="info_start">Click on the microphone icon and begin speaking.</p>
  <p id="info_speak_now">Speak now.</p>
  <p id="info_no_speech">No speech was detected. You may need to adjust your
    <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">
      microphone settings</a>.</p>
  <p id="info_no_microphone" style="display:none">
    No microphone was found. Ensure that a microphone is installed and that
    <a href="//support.google.com/chrome/bin/answer.py?hl=en&amp;answer=1407892">
    microphone settings</a> are configured correctly.</p>
  <p id="info_allow">Click the "Allow" button above to enable your microphone.</p>
  <p id="info_denied">Permission to use microphone was denied.</p>
  <p id="info_blocked">Permission to use microphone is blocked. To change,
    go to chrome://settings/contentExceptions#media-stream</p>
  <p id="info_upgrade">Web Speech API is not supported by this browser.
     Upgrade to <a href="//www.google.com/chrome">Chrome</a>
     version 25 or later.</p>
</div>
<div class="right">
  <button id="start_button" onclick="startButton(event)">
    <img id="start_img" src="assets/mic.gif" alt="Start"></button>
</div>
<div id="results">
  <span id="final_span" class="final"></span>
  <span id="interim_span" class="interim"></span>
  <p>
</div>
<div class="center">
  <div class="sidebyside" style="text-align:right">
    <button id="copy_button" class="button" onclick="copyButton()">
      Copy and Paste</button>
    <div id="copy_info" class="info">
      Press Control-C to copy text.<br>(Command-C on Mac.)
    </div>
  </div>
  <div class="sidebyside">
    <button id="email_button" class="button" onclick="emailButton()">
      Create Email</button>
    <div id="email_info" class="info">
      Text sent to default email application.<br>
      (See chrome://settings/handlers to change.)
    </div>
  </div>
  <p>
  <div id="div_language">
    <select id="select_language" onchange="updateCountry()"></select>
    &nbsp;&nbsp;
    <select id="select_dialect"></select>
  </div>
</div>
<script>



showInfo('info_start');

/* Input commands */

var final_transcript = '';
var recognizing = false;
var ignore_onend;
var start_timestamp;
var answered = 0;
var creatingTask = 0;
var newTask = "";
var allTasks = [];
var context = "greeting";
var speech_count = 0;
var i = 0;

function upgrade() {
  start_button.style.visibility = 'hidden';
  showInfo('info_upgrade');
}

var two_line = /\n\n/g;
var one_line = /\n/g;


function linebreak(s) {
  return s.replace(two_line, '<p></p>').replace(one_line, '<br>');
}

var first_char = /\S/;
function capitalize(s) {
  return s.replace(first_char, function(m) { return m.toUpperCase(); });
}

function showInfo(s) {
  if (s) {
    for (var child = info.firstChild; child; child = child.nextSibling) {
      if (child.style) {
        child.style.display = child.id == s ? 'inline' : 'none';
      }
    }
    info.style.visibility = 'visible';
  } else {
    info.style.visibility = 'hidden';
  }
}

var current_style;

/* Input commands */

function startButton(event) {

  if (recognizing) {
    recognition.stop();
    return;
  }
  final_transcript = '';
  recognition.lang = 'en-CA';

    recognition.start();
  	ignore_onend = false;
 	start_img.src = 'assets/mic-slash.gif';
  	showInfo('info_allow');
}


start_button.style.display = 'inline-block';
var recognition = new webkitSpeechRecognition();
recognition.continuous = true;
recognition.interimResults = true;

/* Event handlers - Set of events triggered for each call*/

recognition.onstart = function() {

  recognizing = true;
  showInfo('info_speak_now');
  start_img.src = 'assets/mic-animate.gif';
};

recognition.onerror = function(event) {
  if (event.error == 'no-speech') {
    start_img.src = 'assets/mic.gif';
    showInfo('info_no_speech');
    ignore_onend = true;
  }
  if (event.error == 'audio-capture') {
    start_img.src = 'assets/mic.gif';
    showInfo('info_no_microphone');
    ignore_onend = true;
  }
  if (event.error == 'not-allowed') {
    if (event.timeStamp - start_timestamp < 100) {
      showInfo('info_blocked');
    } else {
      showInfo('info_denied');
    }
    ignore_onend = true;
  }
};

recognition.onend = function() {

    recognition.start();

/*
  console.log("ended");

  recognizing = false;
  if (ignore_onend) {
    return;
  }
  start_img.src = 'assets/mic.gif';
  if (!final_transcript) {
    showInfo('info_start');
    return;
  }
  showInfo('');

  if (window.getSelection) {
    window.getSelection().removeAllRanges();
    var range = document.createRange();
    range.selectNode(document.getElementById('final_span'));
    window.getSelection().addRange(range);
  }
  */
};

recognition.onresult = function(event) {

  var interim_transcript = '';
  
  // Loop through results as engine tries to match input, assign to interim or final string
  for (var i = event.resultIndex; i < event.results.length; ++i) {
    if (event.results[i].isFinal) {
      final_transcript += event.results[i][0].transcript;
    } else {
      interim_transcript += event.results[i][0].transcript;
    }
  }

  // Output result to html
  final_transcript = capitalize(final_transcript);
  final_span.innerHTML = linebreak(final_transcript);
  interim_span.innerHTML = linebreak(interim_transcript);


  if(interim_transcript.indexOf("Jef") >= 0 && answered == 0){

    console.log("in jeffrey");

    if(interim_transcript.indexOf("wake up") >= 0){

      answered = 1;

      console.log(answered);
      console.log("in wake up");

      triggerModule("start");

      //recognition.stop();

    }else if(interim_transcript.indexOf("work") >= 0){

      answered = 1;

      console.log(answered);
      console.log("in code");

      triggerModule("code");

      //recognition.stop();

    }else if(interim_transcript.indexOf("I'm done for the day") >= 0){

      answered = 1;

      console.log(answered);
      console.log("in stop");

      triggerModule("stop");

      //recognition.stop();

    }else if(interim_transcript.indexOf("write") >= 0 || interim_transcript.indexOf("blog") >= 0){

      answered = 1;

      console.log(answered);
      console.log("in write");

      triggerModule("write");
    }else if(interim_transcript.indexOf("ukulele") >= 0 || interim_transcript.indexOf("uke") >= 0){
        answered = 1;

      console.log(answered);
      console.log("in uke");

      triggerModule("ukulele");
    }else if(interim_transcript.indexOf("analytics") >= 0 || interim_transcript.indexOf("data") >= 0){

      answered = 1;

      console.log(answered);
      console.log("in uke");

      triggerModule("analytics")
    }else if(interim_transcript.indexOf("test") >= 0){

      answered = 1;

      console.log(answered);
      console.log("in backtest");

      triggerModule("backtest")
    }else if(interim_transcript.indexOf("play some music") >= 0){

      answered = 1;

      console.log(answered);
      console.log("in music");

      triggerModule("music")
    }else if(interim_transcript.indexOf("next") >= 0){

      answered = 1;

      console.log(answered);
      console.log("in next");

      triggerModule("next");
    }else if(interim_transcript.indexOf("stop the music") >= 0){

      answered = 1;

      console.log(answered);
      console.log("stop music");

      triggerModule("stop_music");
    }else if(interim_transcript.indexOf("open you up") >= 0){

      answered = 1;

      console.log(answered);
      console.log("jeffrey");

      triggerModule("jeffrey");
    }else if(interim_transcript.indexOf("off") >= 0 || interim_transcript.indexOf("gone") >= 0 || interim_transcript.indexOf("leaving") >= 0){

      answered = 1;

      console.log(answered);
      console.log("off");

      triggerModule("off");
    }else if(interim_transcript.indexOf("I'm back") >= 0){

      answered = 1;

      console.log(answered);
      console.log("back");

      triggerModule("back");
    }else if(interim_transcript.indexOf("time") >= 0){

      answered = 1;

      console.log(answered);
      console.log("time");

      jeffreySpeak("It is currently " + timeNow());
    }

  }
};

/* Speech commands */

function jeffreySendMsg(text){

  var json_msg = '{"text" : "' + text + '", "username" : "Freddy Hidalgo-Monchez"}';

/*
  $.ajax({
      url: 'https://teamstory.slack.com/services/hooks/incoming-webhook?token=r4FkR5MEGhfZnnjtqBaBKE8i',
      type: 'post',
      data: { "payload" : json_msg},
      success: function (data) {
      
      }
    });
*/

}

function createMsgObj(text){
  
  var msg = new SpeechSynthesisUtterance();
  var voices = window.speechSynthesis.getVoices();
  msg.lang = 'en-GB';
  msg.text = text;
  msg.volume = 1;

  return msg;
}

function jeffreySpeak(result, callback){

  var say = createMsgObj(result);
    
  console.log ("jeffreyspeak");
  console.log(result);

  window.speechSynthesis.speak(say);

  say.onend = function (event) {

    if(callback != undefined){
      callback();  
    }
 };

  

  /*
    for (var i = 0; i < result.length; i++) {
      window.speechSynthesis.speak(result[i][1]);
      updateRetrievedDate(result[i][0]);
    };
*/
    if (!recognizing) {
      startButton();  
    }  
}

 function timeNow(){
    var now= new Date(), 
    ampm= 'in the morning', 
    h= now.getHours(), 
    m= now.getMinutes(), 
    s= now.getSeconds();
    if(h>= 12){
        if(h>12) h -= 12;
        ampm= 'in the afternoon';
    }

    if(m<10) m= '0'+m;
    if(s<10) s= '0'+s;
    return h + ':' + m + ' ' + ampm;
}


function triggerModule(module){

  var introMsg = ""; 

    switch(module) {
      case 'start':
          introMsg = "Good Morning master Hidalgo";
          break;
      case 'code':
          introMsg = "Alright, let's get to work! Firing up your workstation!";
          break;
      case 'stop':
          introMsg = "Goodbye master Hidalgo. Have a kickass evening!";
          break;
      case 'write':
          introMsg = "Opening up your word editor now.";
          break;
      case 'ukulele':
          introMsg = "Opening your Santeria tab. Good luck master Hidalgo.";
          break;
      case 'backtest':
          introMsg = "Firing up your trading station.";
          break;
      case 'analytics':
          introMsg = "Setting up your data dashboard for Teamstory.";
          break;
      case 'music':
          introMsg = "Alright, let me put something on.";
          break;
      case 'jeffrey':
          introMsg = "Excellent, I can't wait to learn something new";
          break;
      case 'off':
          introMsg = "Goodbye master Hidalgo, see you soon";
          break;
      case 'back':
          introMsg = "Welcome back, master Hidalgo! What shall we do now?";
          break;
      default:
  }

    if(module == "code"){
      jeffreySpeak(introMsg);
      $.ajax({
          type: "POST",
          url: "test.php",
          data: {module: module}
        }).done(function(){
            answered = 0;
        });
    }else{
      jeffreySpeak(introMsg, function(){
        $.ajax({
          type: "POST",
          url: "test.php",
          data: {module: module}
        }).done(function(){
            answered = 0;
            if(module == "write"){
              jeffreySpeak("Remember master Hidalgo, we do not write in order to be understood; we write in order to understand. Good luck.");
            }else if(module == "start"){
              $.simpleWeather({
                location: 'Vancouver, BC',
                woeid: '',
                unit: 'c',
                success: function(weather) {
                  var temp = weather.temp + "degrees celsius";
                  var currentConditions = weather.currently;
                  var weatherMsg = "It is currently " + temp + " and there is currently " + currentConditions;
                  jeffreySpeak(weatherMsg);
                }
              });
            }
        });

      });
    }
   
}

  //jeffreySpeak(prettyLong);

/*
  
  $.ajax({
    url: "test.php"
  }).done(function(data) {

     var data = $.parseJSON(data);
      var intro = "Here are your following tasks: ";

      jeffreySpeak(intro, function(){
          listTasks(data['data']);
      });
   });

*/


function listTasks(tasks){

  console.log(tasks);

  console.log(tasks[0]);
  console.log(i);

jeffreySpeak(tasks[i].name, function(){

  console.log("callback");
      i++;
      if(i < tasks.length){
        listTasks(tasks); 
      }
  });


}



function updateRetrievedDate(msgId){
  $.ajax({
      url: 'server.php',
      type: 'post',
      data: { "id": msgId},
      success: function (data) {
      }
    });


}



/* App commands */

/*
setInterval(function() {
  //your jQuery ajax code

  $.ajax({
      url: 'server.php',
      type: 'get',
      data: "polling",
      success: function (data) {
        var jsonData = $.parseJSON(data);
        var result = [];

        if(jsonData.length > 0){
           $.each(jsonData, function(idx, obj) {

            console.log(obj);
            var info = $.parseJSON(obj);
            var utterance = createMsgObj(info.message);
            var msgId = info.id;
            var msg = [];
            msg[0] = msgId;
            msg[1] = utterance;

            result.push(msg);
          });

           jeffreySpeak(result);
        }
      
      }
    });
}, 3000); // where X is your every X minutes

/*
  $.ajax({
      url: 'server.php',
      type: 'post',
      data: { "text" : "let's do it!"},
      success: function (data) {
        alert(data);
      }
    });
*/


//jeffreySpeak("Good Morning Master Hidalgo. How are you?");

startButton();

</script>