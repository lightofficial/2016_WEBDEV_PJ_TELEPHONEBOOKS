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

if ((isset($_GET['id'])) && ($_GET['id'] != "")) {
  $deleteSQL = sprintf("DELETE FROM book24 WHERE id=%s",
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($deleteSQL, $conn) or die(mysql_error());

  $deleteGoTo = "delete.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

mysql_select_db($database_conn, $conn);
$query_rs1 = "SELECT * FROM book24";
$rs1 = mysql_query($query_rs1, $conn) or die(mysql_error());
$row_rs1 = mysql_fetch_assoc($rs1);
$totalRows_rs1 = mysql_num_rows($rs1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
</style>
</head>

<body>
<p>&nbsp;</p>
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <th colspan="6" bgcolor="#6FFFB7" scope="col">Telephone Book  [ <a href="addform.php">เพิ่มข้อมูล</a> ]</th>
  </tr>
  <tr>
    <th width="116" bgcolor="#6FFFB7" scope="col">No.</th>
    <th width="597" bgcolor="#6FFFB7" scope="col">Full Name</th>
    <th width="340" bgcolor="#6FFFB7" scope="col">Nickname</th>
    <th width="597" bgcolor="#6FFFB7" scope="col">Tel.</th>
    <th width="597" bgcolor="#6FFFB7" scope="col">Edit</th>
    <th width="597" bgcolor="#6FFFB7" scope="col">Delete</th>
  </tr>
  <?php do { ?>
    <tr>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_rs1['no']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_rs1['fullname']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_rs1['nickname']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $row_rs1['tel']; ?></td>
      <td align="center" bgcolor="#FFFFFF"><a href="editform.php"><img src="edit.png" width="22" height="22" /></a></td>
      <td align="center" bgcolor="#FFFFFF"><a href="index.php?id=<?php echo $row_rs1['id']; ?>"><img src="delete.png" width="22" height="22" /></a></td>
    </tr>
    <?php } while ($row_rs1 = mysql_fetch_assoc($rs1)); ?>
</table>
<p><a href="addform.php"></a></p>
</body>
</html>
<?php
mysql_free_result($rs1);
?>
