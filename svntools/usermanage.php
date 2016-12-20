<?php
$username = $_SERVER["PHP_AUTH_USER"]; //经过 AuthType Basic 认证的用户名
$authed_pass = $_SERVER["PHP_AUTH_PW"]; //经过 AuthType Basic 认证的密码
$passwdfile="C:/Repositories/htpasswd";//svn密码所在文件
$usersfile = "./data/users.data";//用户备注所在文件
$action = $_REQUEST["action"]; //action
$u = $_REQUEST["u"];//用户名
$postRemark = (isset($_REQUEST["remark"]) ? $_REQUEST["remark"] : "");//备注
$postPassword = (isset($_REQUEST["password"]) ? $_REQUEST["password"] : "");//密码
$command='"C:/phpStudy2013/Apache/bin/htpasswd.exe" -b '.$passwdfile." ".$u." ".$postPassword;//执行修改命令

$isManage = FALSE;

if(trim($username)=="jim"){//超级管理员
	$isManage = TRUE;
}
else{
	$isManage = FALSE;
}
?>
<!DOCTYPE html>
<body>
	<head>
		<meta charset="utf-8"/>
		<title>hello</title>
		<style type="text/css">
			td{border:solid #CCCCCC; border-width:0px 1px 1px 0px; padding:10px 0px;}
		 	table{border:solid #CCCCCC; border-width:1px 0px 0px 1px; background-color: #f9f9f9;}
		</style>
	</head>
	<?php
		if(!$isManage){
	?>
	<script type="text/javascript">
		alert("请勿非法进入管理员页面！");
		history.go(-1);
	</script>
	<?php
		}
		else{
	?>
	<?php
	    $passwordfilelines = file($passwdfile);
		$usersfilelines = file($usersfile);
		$users = array();
	    foreach($passwordfilelines as $line => $content){
	    	$temps = array();
	    	$obj = split(':', $content);
			array_push($temps,$obj[0]);
	        foreach($usersfilelines as $line1 => $content1){
	        	$obj1 = split(':', $content1);
		    	if($obj[0] == $obj1[0]){
		    		array_push($temps,$obj1[1]);
		    	}			        
		    }
			if(count($temps)==1){
				array_push($temps,"");
			}
			array_push($users,$temps);
	    }
		
		//修改文件
		if(strlen($postRemark)>0){//修改备注
			//写入文件
			$myfile = fopen($usersfile, "w") or die("Unable to open file!");
			$txt = "";
			foreach ($users as $key => $value) {
				if($value[0]==$u){
					$value[1] = $postRemark;
				}
				$txt =$txt . ($value[0] .":". $value[1] ."\n");
			}
			fwrite($myfile, $txt);
			fclose($myfile);
			if(strlen($postRemark)>0){//修改密码
				system($command, $result);
			}
	?>
	<script type="text/javascript">
		alert("修改成功！");
		window.location.href = "usermanage.php";
	</script>	
	<?php
		}
	?>
	<table width="100%" border="0" cellspacing="1" cellpadding="0">
		<tr>
			<td>
				用户名
			</td>
			<td>
				备注
			</td>
			<td align="center">
				操作
			</td>
		</tr>
		<?php
			foreach ($users as $key => $value) {
		?>
		<tr>
			<td>
				<?=$value[0] ?>
			</td>
			<td>
				<?=$value[1] ?>
			</td>
			<td align="center">
				<a href="?action=edit&u=<?=$value[0] ?>">修改</a>
			</td>
		</tr>
		<?php
			}	
		?>
	</table>
	<?php
		if(isset($action) && $action == "edit" && isset($u)){
			$remark = null;
			foreach($usersfilelines as $line1 => $content1){
	        	$obj1 = split(':', $content1);
		    	if($obj1[0] == $u){
		    		$remark = $obj1[1];
		    	}			        
		    }
	?>
	<form method="post">
		<br/><br/><br/>修改用户：
		<table width="100%" border="0" cellspacing="1" cellpadding="0">
			<tr>
				<td>
					用户名
				</td>
				<td>
					<?=$u?>
				</td>
			</tr>
			<tr>
				<td>
					备注
				</td>
				<td>
					<textarea name="remark" style="width: 50%; height: 100px;"><?=$remark?></textarea>
				</td>
			</tr>
			<tr>
				<td>
					密码(为空则不修改)
				</td>
				<td>
					<input name="password"/>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<input type="submit" value="修 改">
					<input name="reset" type="reset" value="取 消">
					<p><input name="reset" type="button" value="返回" style="width:115px;" onclick="javascript:history.go(-1);"></p>
				</td>
			</tr>
		</table>
	</form>
	<?php	
		}	
	?>
	<?php
		}			
	?>
</body>


