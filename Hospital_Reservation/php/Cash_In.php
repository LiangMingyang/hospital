<?php
  if(!isset($_SESSION))
  session_start();
?>
<html>
    <script src="../include/artDialog/artDialog.js?skin=default"></script>
    <script src="../include/artDialog/plugins/iframeTools.source.js"></script>
    <script src="../include/sha1.js"></script>
    <script src="../include/jquery-2.1.1.js"></script>
	<link href="../css/Cash_In.css" rel="stylesheet" type="text/css" />
	<script src="../js/Cash_In.js"> </script>	
	<body>
		<div id="title">
			<p>充值页面</p>
		</div>
		<div id="content">
			<br />
			<table id="cash_in_tb">
				<tr>
					<td class="tag">姓名</td>
					<td class="tag_1">
						<input type="text" id="name" name="<?php echo $_SESSION['User_ID'] ?>" disabled="disabled"  readonly="readonly" value="<?php echo $_SESSION['UserName']  ?>"/>
					</td>
				</tr>
				<tr>
					<td><br /></td>
					<td></td>
				</tr>
				<tr>
					<td class="tag">当前余额￥</td>
					<td class="tag_1">
						<input type="text" id="cur_Amount" value="?"  disabled="disabled"  readonly="readonly"/>
					</td>
				</tr>
				<tr>
					<td><br /></td>
					<td></td>
				</tr>
				<tr>
					<td class="tag">充值金额 ￥</td>
					<td class="tag_1">
						<input type="text" id="amount" value="0.00"/>
					</td>
				</tr>
				<tr  >
					<td colspan="2">
						<input type="button" id="confirm_cash" value="确定" onclick="confirm_cash()"/>
					</td>
				</tr>
			</table>
			<br />
		</div>
	</body>
	
	
</html>
