<?php
/**
 * roleReviewInfo.tpl.php-.
 * 
 * @modification history 
 * ---------------------
 * 2014-7-15,created by zhangxin
 */
include header_inc();
 ?>
<script src='<?php echo JS_PATH?>dtree/dtree.js' language='javascript'></script>
 <script type="text/javascript">

var menuList = [];
function showMenu(obj){
	$.getJSON(WEB_ROOT+'system/menu.php?roleId=<?php echo $roleID?>',{
		baserole:obj.value,
		rm:Math.random()
		},function(data){
			if(menuList.length>0){
				menuList = [];
			}
			dataObj = data.menuList;
			menuTree = new dTree('menuTree');
			menuTree.add('0', '-1', '权限配置', '');
			i=0;
			$.each(dataObj,function(infoIndex,info){
				menuTree.add(info['MenuID'],info['PID'],info['MenuText'],true,data.all[i++]=="yes"?true:false);
				menuList.push(info['MenuID']);
				});
			$('#menutree').html(menuTree.toString());
	});
}

</script>
 <body>
 <div class="celue p20" style="margin-top:0px;">
  	 			<h5 class="title102" style="position:relative; zoom:1;"><em>角色审核</em></h5>
  	 			<form name="roleForm" action="roleReview.php" method="post" onsubmit="return roleSave()">
  	 			<table id='policyInfoCustom' border="0" cellspacing="0" cellpadding="0" width="100%" class="tab6">
            	<tbody>
              	<tr>
                	<th>角色名</th>
                  <td><input type='text' id='roleName' name='role[RoleName]' value='<?php echo $role['RoleName'];?>' onblur='checkRoleName(true)'/><span class="errorTip" id='roleNameTip'></span></td>
                  </tr><tr>
                  <th>角色类型</th>
                  <td><select name='role[BaseRole]' id='baseRole' onchange='showMenu(this)'>
                  <?php foreach ($baseRoles as $base){?>
                  <option value='<?php echo $base['BaseId'];?>' <?php if($base['BaseId']==$role['BaseRole'])echo 'selected'?>><?php echo $base['BaseRoleName']?></option>
                  <?php }?>
                  </select>
                    	<input type='hidden' id='roleId' name='role[RoleId]' value='<?php echo $role['RoleID'];?>'/>
                    	<input type='hidden' id='role_menu' name='role_menu'/>
                </tr>
                <tr>
                	<td colspan='2'class="btn">
                		<input type="submit" class="neibu" value="返回" name="sbtRole">
                		</td>
                </tr>
        			</tbody>
            </table></form>
		<div class="loudong">
                		<div class="celue p20" id='policy_vul_list_tree'>
                    <table width='100%'>
                        <tr>
                            <td>
                                <div class='dtree' id='menutree'>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                </div>
</div>
     <script>
     showMenu(document.getElementById('baseRole'));
</script>
 </body>
 </html>