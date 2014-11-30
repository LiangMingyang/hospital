> 本反馈从《接口信息规范4.0》第8页开始

###查看历史 Check_History_Reservation_Simple
- url路径改成host/Check_History_Reservation_Simple
- 为与数据库保持一致，所有Reservation\_\*字段，全部变为History\_Reservation\_\*
- content内的State含义不明，故而没有返回相应字段

###查看单条历史详情 Check_History_Reservation_Detail
- url路径改成host/Check_History_Reservation_Detail
- 为与数据库保持一致，所有Reservation\_\*字段，全部变为History\_Reservation\_\*
- post请求中Reservation_Date字段含义不明，故而没有使用

###预约医生 Reservation
- Doctor表中不存在“已预约人数”对应的字段，忽略

###查看是否支付 Check_PayState
- 返回状态含义修改，msg = 1表明查询失败，msg = 0表示查询成功，info记录查询结果

###*充值 In_Cash*
- User表中不存在“账户余额”对应的字段（这是怎么个情况= =）

###*审核注册 Check_Register*
- 没搞明白这个函数的意思……

###取消预约 Cancel_Reservation
- 与del\_Reservation的含义和行为重复

###查看用户信息 Search_User
- 可直接将post请求发往get_UserInfo_byID，根据post请求中字段不同（User\_ID或Identity\_ID）返回相应结果

###创建医院 Create_Hospital
- 创建医院前检查医院是否已经存在的工作，是交给PHP还是Node.js？
- 注册register也存在上述问题
- 为与register保持一致，创建医院成功后也会返回Hospital_ID