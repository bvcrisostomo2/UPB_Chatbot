<?php
/***************************************
 * http://www.program-o.com
 * PROGRAM O
 * Version: 2.6.5
 * FILE: index.php
 * AUTHOR: Elizabeth Perreau and Dave Morton
 * DATE: FEB 01 2016
 * DETAILS: This is the interface for the Program O JSON API
 ***************************************/

$cookie_name = 'Program_O_JSON_GUI';
$botId = filter_input(INPUT_GET, 'bot_id');
$convo_id = (isset($_COOKIE[$cookie_name])) ? $_COOKIE[$cookie_name] : jq_get_convo_id();
$bot_id = (isset($_COOKIE['bot_id'])) ? $_COOKIE['bot_id'] : ($botId !== false && $botId !== null) ? $botId : 1;

setcookie('bot_id', $bot_id);

// Experimental code
$base_URL = 'http://' . $_SERVER['HTTP_HOST'];                                   // set domain name for the script
$this_path = str_replace(DIRECTORY_SEPARATOR, '/', realpath(dirname(__FILE__)));  // The current location of this file, normalized to use forward slashes
$this_path = str_replace($_SERVER['DOCUMENT_ROOT'], $base_URL, $this_path);       // transform it from a file path to a URL
$root_url = str_replace('gui/jquery', '', $this_path);   // and set it to the correct script location
$url = $root_url . 'chatbot/conversation_start.php';   // and set it to the correct script location
/*
  Example URL's for use with the chatbot API
  $url = 'http://api.program-o.com/v2.3.1/chatbot/';
  $url = 'http://localhost/Program-O/Program-O/chatbot/conversation_start.php';
  $url = 'chat.php';
*/

$display = "The URL for the API is currently set as:<br />\n$url.<br />\n";
$display .= 'Please make sure that you edit this file to change the value of the variable $url in this file to reflect the correct URL address of your chatbot, and to remove this message.' . PHP_EOL;
#$display = '';

/**
 * Function jq_get_convo_id
 *
 *
 * @return string
 */
function jq_get_convo_id()
{
    global $cookie_name;

    session_name($cookie_name);
    session_start();
    $convo_id = session_id();
    session_destroy();
    setcookie($cookie_name, $convo_id);

    return $convo_id;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UBP Chatbot</title>
    <link rel="stylesheet" type="text/css" href="main.css" media="all"/>
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>

    <meta name="Description" content="A Free Open Source AIML PHP MySQL Chatbot called Program-O. Version2"/>
    <meta name="keywords" content="Open Source, AIML, PHP, MySQL, Chatbot, Program-O, Version2"/>
    <style type="text/css">

.dropbtn {
-moz-appearance: none;
-webkit-appearance:none;
border:hidden;
border-radius: 15px 15px 15px 15px;
font-family: "Calibri", "Roboto", sans-serif;
font-weight: bold;
text-decoration: underline;
font-size: 30px;
color: #fff;
//background: #fff;
background: transparent;
//padding: 15px 25px 15px 25px;
}

.drop_option {
background: #8468ff;
color: #fff;
font-family: "Calibri", "Roboto", sans-serif;
}

.css-input { 
//border-width:2px; 
padding:15px; 
width:600px;

//border-color:#000000; 
font-size:17px; 
border-radius:15px 0px 0px 15px; 
border-style:hidden; 
background-color:#ffffff; 
font-family: ;
//color:#a19ca1; 
//box-shadow: 0px 0px 8px 0px rgba(42,42,42,.75); 
//text-shadow:0px 0px 0px rgba(42,42,42,.75); 
display: inline-block; 
} 
.css-input:focus { 
outline:none;
} 

.btn {
border:hidden;
border-radius: 0px 15px 15px 0px;
font-family: "Calibri", "Roboto", sans-serif;
color: #9c8ce6;
background: #fff;
font-size: 17px;
width:auto;
padding: 15px 25px 15px 25px;
display: inline-block;
}

.btn:hover {
background: transparent;
display: inline-block;
}
* {
box-sizing: border-box;
}

body {
//background-color: #f5a235;
background-color: #ebe9e7;
font-family: "Calibri", "Roboto", sans-serif;
}
.chat_window {
position: absolute;
width: calc(100% - 20px);
max-width: 800px;
height: 500px;
border-radius: 20px;
background-color: #fff;
left: 50%;
top: 50%;
transform: translateX(-50%) translateY(-50%);
box-shadow: 0px 75px 75px -55px;
/*background-color: #f8f8f8;*/
//background-color: #F2F4F4;
overflow: visible;
}

.top_menu .buttons .button {
width: 16px;
height: 16px;
border-radius: 50%;
display: inline-block;
margin-right: 10px;
position: relative;
}
.top_menu .buttons .button.close {
background-color: #f5886e;
}
.top_menu .buttons .button.minimize {
background-color: #fdbf68;
}
.top_menu .buttons .button.maximize {
background-color: #a3d063;
}
.top_menu {
background-color: #8468ff;
width: 100%;
padding: 5px 0 5px;
box-shadow: 0 px 30px rgba(0, 0, 0, 0.1);
border-radius: 20px 20px 0 0;
}
.choose_bot {
position: relative;
display: inline-block;
left: 0px;
top: 0px;
}
.top_menu .title {
 text-align: center;
color: #154360;
font-weight : bold;
font-family : verdana, calibri, arial;
font-size: 30px;
text-decoration: underline;
}

.bottom_part {
background-color:#f2f2f2;

padding: 0px 0 10px;
border-radius:0px 0px 20px 20px;
overflow:hidden;
}

h3 {
color: #fff;
font-family: "Calibri", "Roboto", sans-serif;
 font-size: 30px;
position:relative;
text-align: center; 
padding: 0px 0px 0px 30px;	    	
}


hr {
width: 80%;
color: green;
margin-left: 0;
}

.user_name {
color: rgb(16, 45, 178);
}

.bot_name {
color: rgb(204, 0, 0);
}

#shameless_plug, #urlwarning {
position: absolute;
right: 10px;
bottom: 10px;
border: 1px solid red;
box-sizing: border-box;
box-shadow: 2px 2px 2px 0 #808080;
padding: 5px;
border-radius: 5px;
}

#urlwarning {
right: auto;
left: 10px;
width: 50%;
font-size: large;
font-weight: bold;
background-color: white;
}

.leftside {
text-align: right;
float: left;
width: 48%;
}

.rightside {
text-align: left;
float: right;
width: 48%;
}

.centerthis {
width: 100%;
}

#chatdiv {
margin-top: 20px;
text-align: center;
width: 100%;

}

#chat_end {
margin-top: 1px;
text-align: center;
width: 100%;
}

#chatlog {
overflow: auto;
box-sizing: border-box;
min-height: 300px;
max-height: 300px;
position: relative;
min-width: 700px;
max-width: 90%;
margin: 10px auto;
background-color: transparent;
//border: 3px solid black;
//box-shadow: 5px 5px 0px 0px #808080;
border-radius: 9px;
padding: 12px;
}
::-webkit-scrollbar {
width: 0px;  /* remove scrollbar space */
background: transparent;  /* optional: just make scrollbar invisible */
}

.userTitle {
color: #fff;
font-weight: bold;
}

ul {
list-style-type: none;
}

.botTitle {
color: #8f8f8f;
font-weight: bold;

}

#sbBot_id {
margin-right: 35px;
}


.chatcallouts_container {
width: 100%;
position: relative;
height:auto;
overflow:hidden;
}


.chatcallouts_text {
float:right;
height:auto;
width: 50%;
background-color:#d1cfce;
padding: 10px 10px 10px 10px;
border-radius: 25px 25px 0px 25px;
position: relative;
color: #8f8f8f;
font-family: arial;
font-size: 15px;
overflow x: hidden;
}

.chatcallouts_user_container {
width: 100%;
position: relative;
height:auto;
overflow:hidden;
}
.chatcallouts_user_text {
float:left;
width:50%;
background-color:#9c8ce6;
padding: 10px 10px 10px 10px;
border-radius: 25px 25px 25px 0px;
position: relative;
color: #fff;
font-family: arial;
font-size: 15px;
overflow x: hidden;
}
.portrait {
width: 50px;
height: 50px;
border-radius: 50%;
display: inline-block;

position: relative;
border:hidden;
background-color: #a3d063
}
.portrait_placement {
position: relative;
display: inline-block;
left: 15px;
top: 17px;
}
.name_placement {
position: relative;
display: inline-block;
}

    </style>
</head>
<body>
<form method="post" name="talkform" id="talkform" action="index.php">
	<div class="chat_window">
		<div class="top_menu">
			<div class="portrait_placement">
				<div class="portrait"></div>							
			</div>	
			<div class="name_placement">
				<h3>Choose Your Bot:</h3>
			</div>
			<div class="choose_bot">
			<select class="dropbtn" id="sbBot_id" name="bot_id">
					<option class="drop_option" value="1">Unknown</option>
				    </select>
		    </div>					
		</div>
		<div class="clearthis"></div>

		<div class="centerthis">
		    <div id="chatlog">
			<!--<div class="chatcallouts_container"><div class="chatcallouts_text"><span class="botTitle">UBP_Chatbot: </span>Hello there!</div></div>-->
		    </div>
		</div>
		<div class="bottom_part">
			<div class="centerthis">
			    
				<div id="chatdiv">		    
				    <input class="css-input" type="text" name="say" id="say" size="50" placeholder="Type your message here" autocomplete="off" />
				    <input type="submit" name="submit" id="submit" class="btn" value="Send" onclick="scroll()" />
				    <input type="hidden" name="convo_id" id="convo_id" value="<?php echo $convo_id; ?>"/>
				    <input type="hidden" name="format" id="format" value="json"/>
				</div>
			    
			</div>
		</div>

	</div>
</form>

<script type="text/javascript" src="//ajax.google_apis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
    window.jQuery || document.write('<script type="text/javascript" src="jquery-1.9.1.min.js">\x3C/script>');
</script>

<!--Scroll -->

<script type="text/javascript">
function scroll(){
	var log = $('#chatlog');
    log.animate({ scrollTop: log.prop('scrollHeight')}, 500);
}

</script>

<script type="text/javascript">
$("#say").keyup(function(event){
    if(event.keyCode == 13){
        scroll();
    }
	});

</script>

<script type="text/javascript">
    var gbURL = '<?php echo $root_url ?>getbots.php';
    var botTitle = '<span class="botTitle">';
    var userTitle = '<span class="userTitle">';
    var endSpan = '</span>';
    $(document).ready(function () {
        // Load multiple chatbots into the selectbox
        $.getJSON(gbURL, function (data) {
            $('#sbBot_id').html("\n");
            $.each(data.bots, function (bot_id, bot_name) {
                $('#sbBot_id').append('            <option class="drop_option" value="' + bot_id + '">' + bot_name + "</option>\n");
            });
        });
        $('#sbBot_id').on('change', function () {
            var bn = $('#sbBot_id option:selected').text();
            //$('.botTitle').html(bn + ": ");
            $('#chatlog').html('Now chatting with <span class="botTitle">' + bn + endSpan);
        });

        // Form submission - This is where the magic happens!
        $('#talkform').submit(function (e) {
            e.preventDefault();
            var bot_name = $('#sbBot_id option:selected').text();
            var user = $('#say').val();
            var userSaid = userTitle + 'User: ' + endSpan + user + "<br>\n";
            $('#chatlog').html($('#chatlog').html() +"<div class='chatcallouts_user_container'><div class='chatcallouts_user_text'>"+ userSaid+"</div></div>");
            var botSaid = botTitle + bot_name + ': ' + endSpan;
            var formdata = $("#talkform").serialize();
            $('#say').val('');
            $('#say').focus();
            $.post('<?php echo $url ?>', formdata, function (data) {
                var b = data.botsay;
                if (b.indexOf('[img]') >= 0) {
                    b = showImg(b);
                }
                if (b.indexOf('[link') >= 0) {
                    b = makeLink(b);
                }
                var usersay = data.usersay;

                $('#chatlog').html($('#chatlog').html()+ "<div class='chatcallouts_container' id='botSaid'><div class='chatcallouts_text' id='botSaid'>" + botSaid + b+ "</div></div>");
            }, 'json').fail(function (xhr, textStatus, errorThrown) {
                $('#urlwarning').html("Something went wrong! Error = " + errorThrown);
            });
            return false;
        });
        
    }); 
    function showImg(input) {
        var regEx = /\[img\](.*?)\[\/img\]/;
        var repl = '<br><a href="$1" target="_blank"><img src="$1" alt="$1" width="150" /></a>';
        var out = input.replace(regEx, repl);
        console.log('out = ' + out);
        return out
    }
    function makeLink(input) {
        var regEx = /\[link=(.*?)\](.*?)\[\/link\]/;
        var repl = '<a href="$1" target="_blank">$2</a>';
        var out = input.replace(regEx, repl);
        console.log('out = ' + out);
        return out;
    }    
</script>
</body>
</html>