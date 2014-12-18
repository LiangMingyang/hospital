<?php
/**
 * roleInfo.tpl.php-.
 * @author Xu Guozhi<xuguozhi09@gmail.com>
 *
 * @copyright Copyright (c) 2012, by thss, P.R.China
 *
 * @modification history 
 * ---------------------
 * 2012-3-2,created by Xu Guozhi
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
<?php
/*$menuIdsStr="[";
foreach ($menus as $menu)
{
    $id = $menu['MenuID'];
    $pid = $menu['PID'];
    $text = $menu['MenuText'];
    $check = ($menu['Has']==0?"false":"true");
    echo "menuTree.add('$id','$pid','$text',true,$check);";
    $menuIdsStr.="'$id',";
} 
$menuIdsStr = substr($menuIdsStr, 0,-1);
$menuIdsStr .= "]";*/
?>
//menuList = <?php echo $menuIdsStr;?>;
function roleSave(){
	roleName = $('#roleName').val();
	if(roleName == null || roleName == ''){
		$('#roleName').removeClass();
		$('#roleName').addClass('inputError');
		$('#roleNameTip').html('角色名不能为空');
		return false;
	}
	$('#roleName').removeClass();
	$('#roleName').addClass('inputRight');
	$('#roleNameTip').html('');			
	
	if(checkRoleName(false) != 'OK'){
		alert('角色名已存在，请重新输入');
		return false;
		}
	roleChecked="";
	<?php if($menus){
	    foreach($menus as $menu){
	        echo "roleChecked+=','+".$menu['MenuID'].";";
	    }
	}?>
	for(var menuId in menuList){
		if(menuTree.isChecked(menuList[menuId]))
		{
			roleChecked+=","+menuList[menuId];
		}
	}
	roleChecked = roleChecked.substr(1);
	$('#role_menu').val(roleChecked);
	return true;
}
function checkRoleName(async){
	var name= $('#roleName').val();
	if(name != null && name != ''){
		if($.trim(name).length>20){
			$('#roleName').removeClass();
			$('#roleName').addClass('inputError');
			$('#roleNameTip').html('角色名长度不能超过20个字符！');
		}else{
			$('#roleName').removeClass();
			$('#roleName').addClass('inputRight');
			$('#roleNameTip').html('');		

			var status = '';
			$('#roleNameTip').html('<img src="'+WEB_ROOT+'template/images/load.gif"/>');
			$.ajax({ 
		          type : "get", 
		          url : WEB_ROOT+'system/role.php', 
		          data : {
			  			roleName:name,
						roleId:$('#roleId').val(),
						rm:Math.random()
						}, 
		          async : async, 
		          success : function(data){ 
		        	  if(data == 'OK'){
							$('#roleName').removeClass();
							$('#roleName').addClass('inputRight');
							$('#roleNameTip').html('');					
							}else{
								$('#roleName').removeClass();
								$('#roleName').addClass('inputError');
								$('#roleNameTip').html('角色名已存在，请重新输入');
							}
						status = data; 
		          } 
		          });
	        return status;		
		}
		
	}
}

</script>
 <body>
 <div class="celue p20" style="margin-top:0px;">
  	 			<h5 class="title102" style="position:relative; zoom:1;"><em>角色管理</em></h5>
  	 			<form name="roleForm" action="?cmd=save" method="post" onsubmit="return roleSave()">
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
                		<input type="submit" class="neibu" value="保存" name="sbtRole">
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