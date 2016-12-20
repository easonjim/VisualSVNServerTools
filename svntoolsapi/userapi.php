<?php
$passwdfile="C:/Repositories/htpasswd";//svn密码所在文件
$u = (isset($_POST["u"]) ? $_POST["u"] : "");//用户名
$a = (isset($_REQUEST["p"]) ? $_REQUEST["p"] : "");//action
$postPassword = (isset($_POST["p"]) ? $_POST["p"] : "");//密码
$command='"C:/phpStudy2013/Apache/bin/htpasswd.exe" -b '.$passwdfile." ".$u." ".$postPassword;//执行修改命令，添加和修改都是这个命令
$command1='"C:/phpStudy2013/Apache/bin/htpasswd.exe" -D '.$passwdfile." ".$u;//执行修改命令，添加和修改都是这个命令
if($a=="e")echo system($command);
else if($a=="d")echo system($command1);
?>