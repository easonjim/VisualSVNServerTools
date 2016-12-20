<?
$username = $_SERVER["PHP_AUTH_USER"]; //经过 AuthType Basic 认证的用户名
$authed_pass = $_SERVER["PHP_AUTH_PW"]; //经过 AuthType Basic 认证的密码
$input_oldpass = (isset($_REQUEST["oldpass"]) ? $_REQUEST["oldpass"] : ""); //从界面上输入的原密码
$newpass = (isset($_REQUEST["newpass"]) ? $_REQUEST["newpass"] : ""); //界面上输入的新密码
$repeatpass = (isset($_REQUEST["repeatpass"]) ? $_REQUEST["repeatpass"] : ""); //界面上输入的重复密码
$action = (isset($_REQUEST["action"]) ? $_REQUEST["action"] : ""); //以hide方式提交到服务器的action
$passwdfile="C:/Repositories/htpasswd";//SVN密码所在的文件
$command='"C:/phpStudy2013/Apache/bin/htpasswd.exe" -b '.$passwdfile." ".$username." ".$newpass;//执行修改密码命令
if($action!="modify"){
$action = "view";
}
else if($authed_pass!=$input_oldpass){
$action = "oldpasswrong";
}
else if(empty($newpass)){
$action = "passempty";
}
else if($newpass!=$repeatpass){
$action = "passnotsame";
}
else{
$action = "modify";
}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
<title>SVN 在线自助密码修改</title>
</head>
<body>

<?
//action=view 显示普通的输入信息
if ($action == "view"){
?>
<script language = "javaScript">
<!--
function loginIn(myform)
{
var newpass=myform.newpass.value;
var repeatpass=myform.repeatpass.value;

if(newpass==""){
alert("请输入密码！");
return false;
}

if(repeatpass==""){
alert("请重复输入密码！");
return false;
}

if(newpass!=repeatpass){
alert("两次输入密码不一致，请重新输入！");
return false;
}
return true;
}
//-->
</script>
<style type="text/css">
<!--
table {
border: 1px solid #CCCCCC;
background-color: #f9f9f9;
text-align: center;
vertical-align: middle;
font-size: 9pt;
line-height: 15px;
}
th {
font-weight: bold;
line-height: 20px;
border-top-width: 1px;
border-right-width: 1px;
border-bottom-width: 1px;
border-left-width: 1px;
border-bottom-style: solid;
color: #333333;
background-color: f6f6f6;
}
input{
height: 18px;
}
.button {
height: 20px;
}

-->
</style>
<br><br><br>
<form method="post">
<input type="hidden" name="action" value="modify"/>
<table width="220" cellpadding="3" cellspacing="8" align="center">
<tr>
<th colspan=2>SVN 密码修改</th>
</tr>
<tr>
<td>用 户 名：</td>
<td align="left"> <?=$username?></td>
</tr>
<tr>
<td>原 密 码：</td>
<td><input type=password size=12 name=oldpass></td>
</tr>
<tr>
<td>用户密码：</td>
<td><input type=password size=12 name=newpass></td>
</tr>
<tr>
<td>确认密码：</td>
<td><input type=password size=12 name=repeatpass></td>
</tr>
<tr>
<td colspan=2>
<input onclick="return loginIn(this.form)" class="button" type=submit value="修 改">
<input name="reset" type=reset class="button" value="取 消">
<p><input name="reset" type="button" class="button" value="返回" style="width:115px;" onclick="javascript:history.go(-1);"></p>
</td>
</tr>
</table>
</form>
<?
}
else if($action == "oldpasswrong"){
$msg="原密码错误！";
}
else if($action == "passempty"){
$msg="请输入新密码！";
}
else if($action == "passnotsame"){
$msg="两次输入密码不一致，请重新输入！";
}
else{
system($command, $result);
if($result==0){
$msg="用户[".$username."]密码修改成功，请用新密码登陆.";
}
else{
$msg="用户[".$username."]密码修改失败，返回值为".$result."，请和管理员联系！";
}
}

if (isset($msg)){
?>
<script language="javaScript">
<!--
alert("<?=$msg?>");
window.location.href="<?=$_SERVER["PHP_SELF"]?>"
//-->
</script>
<?
}
?>
</body>
</html>