<?php require_once('Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO book24 (`no`, fullname, nickname, tel) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['no'], "text"),
                       GetSQLValueString($_POST['fullname'], "text"),
                       GetSQLValueString($_POST['nickname'], "text"),
                       GetSQLValueString($_POST['tel'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE book24 SET `no`=%s, fullname=%s, nickname=%s, tel=%s WHERE id=%s",
                       GetSQLValueString($_POST['no'], "text"),
                       GetSQLValueString($_POST['fullname'], "text"),
                       GetSQLValueString($_POST['nickname'], "text"),
                       GetSQLValueString($_POST['tel'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "index.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_rs1 = "-1";
if (isset($_GET['id'])) {
  $colname_rs1 = $_GET['id'];
}
mysql_select_db($database_conn, $conn);
$query_rs1 = sprintf("SELECT * FROM book24 WHERE id = %s", GetSQLValueString($colname_rs1, "int"));
$rs1 = mysql_query($query_rs1, $conn) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Telephone Book</title>
<style type="text/css">
body {
	background-color: #72DAFC;
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	text-align: center;
	font-size: large;
	color: #333;
}
#form1 table tr th {
	color: #F00;
}
</style>
</head>

<body><br /><br />
<form id="form1" name="form1" method="POST" action="<?php echo $editFormAction; ?>">
  <table width="100%" border="1" cellspacing="1" cellpadding="1">
    <tr>
      <th colspan="2" bgcolor="#FFFF00" scope="col">แบบฟอร์มแก้ไขข้อมูล</th>
    </tr>
    <tr>
      <td width="50%" align="right">เลขที่</td>
      <td width="50%" align="left"><label for="no"></label>
      <input name="no" type="text" id="no" value="<?php echo $row_rs1['no']; ?>" size="10" maxlength="2" /></td>
    </tr>
    <tr>
      <td align="right">ชื่อ - นามสกุล</td>
      <td align="left"><label for="fullname"></label>
      <input name="fullname" type="text" id="fullname" value="<?php echo $row_rs1['fullname']; ?>" size="50" maxlength="100" /></td>
    </tr>
    <tr>
      <td align="right">ชื่อเล่น</td>
      <td align="left"><label for="nickname"></label>
      <input name="nickname" type="text" id="nickname" value="<?php echo $row_rs1['nickname']; ?>" size="25" maxlength="50" /></td>
    </tr>
    <tr>
      <td align="right">เบอร์โทรศัพท์</td>
      <td align="left"><label for="tel"></label>
      <input name="tel" type="text" id="tel" value="<?php echo $row_rs1['tel']; ?>" size="25" maxlength="10" /></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" id="button" value="OK" />
      <input type="reset" name="button2" id="button2" value="Cancel" />
      <input name="id" type="hidden" id="id" value="<?php echo $row_rs1['id']; ?>" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1" />
  <input type="hidden" name="MM_update" value="form1" />
</form>
</body>
</html>
<?php
mysql_free_result($rs1);
?>
