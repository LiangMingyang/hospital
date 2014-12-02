> 本反馈从《接口信息规范4.0》Page9 to Page25

###sql文件改动
- 添加外键约束
- 实体集主键全部添加ON UPDATE CASCADE ON DELETE RESTRICT属性，即级联更新、删除受外键约束
- 实体集中的ID全部添加AUTO_INCREMENT属性，即自动增长
- 所有FLOUT和REAL类型全部变成DECIMAL，因为金额必须储存精确值，至于精确的位数还需要定一下
- 参照文档，User添加Sex和Amount字段

###Find_User
- 此接口是否还存在？

###查看历史 Check_History_Reservation_Simple
- content内的State含义不明，故而没有返回相应字段

###预约医生 Reservation
- 没有提供Reservation_PayAmount字段，当然也可以在支付挂号费时提供，但支付挂号费时也没有提供
- Doctor表中不存在“已预约人数”对应的字段，暂时忽略
- 解释一下Doctor_Limit字段的含义，如果是上限，是应该不动，还是应该逐渐减少？如果不动，哪个字段记录了已预约次数？
- 如果Doctor表有对应的increase操作，User表是否也应该进行对应的increase？

###取消预约 del_Reservation
- 如果预约时需要increase，那么取消时是否应该decrease
- 已支付时要退钱这个注意到了，但还是同样的问题，Reservation_PayAmount字段从没赋过值，不知道该退多少钱

###支付挂号费 Pay_Reservation
- 没有提供Reservation_PayTime字段，理由同预约医生接口
- 不仅修改状态，而且应从余额里扣除对应的钱数，但对应预约医生接口中的问题，没有提供Reservation_PayAmount字段
- 在已经存在Reservation_Time字段和Reservation_PayTime字段的情况下，求解释Operation_Time字段的含义

###*审核注册 Check_Register*
- 没搞明白这个函数的意思……

###管理预约信息Get_Reservation_Info
- content中的字段User_Name应改为UserName
- 其余的一些接口也有同样的问题，例如Search_By_Identity

###取消预约 Cancel_Reservation
- 与del_Reservation的含义和行为完全一致，可删去

###get_UserInfo_byID
- 文档3.1版本补丁中添加此接口，4.0版本中消失，估计是文档遗漏，在此作为提醒，后台已实现此接口

###创建医院 Create_Hospital
- 创建医院前检查医院是否已经存在的工作，是交给PHP还是Node.js？
- 目前后台的做法是检查了是否已经存在，如果存在，msg = 1，info记录已存在的提示信息
- 注册用户、添加科室也存在上述问题

###添加科室 Get_DepartInfo
- 与获取科室信息接口重名，后台将其修改为Create_Depart，与创建医院统一格式
- 注册用户、创建医院、添加医生等接口都没有返回ID，这个确定需要返回ID么？（因为要多写很多东西）

###获取科室信息 Get_DepartInfo
- 字段“Deprt_Name”拼写错误，因与查询操作直接相关，需要修改

###添加医生 Add_Doctor
- 注册用户、创建医院、创建科室等接口的后台实现中都不允许重名的出现（检查了已经存在），这里是否允许重名？（目前的后台实现是不允许）

###创建普通管理员账号 Add_Admin
- 没有提供isSuper字段？是否应该默认为0？

###赋予权限 Give_Privilege
- 没有提供Admin_ID字段？解除权限接口也有此问题

###Find_User_By_Identity_ID
- 与Search_User的含义和行为完全一致，可删去
