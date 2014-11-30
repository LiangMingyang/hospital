> 本反馈从《接口信息规范3.1》第8页开始

###查看历史 Check_History_Reservation_Simple
- 为与数据库保持一致，所有Reservation\_\*字段，全部变为History\_Reservation\_\*
- post信息中应增加User_ID，与查看预约保持一致
- content内的State含义不明，故而没有返回相应字段

###查看单条历史详情 Check_History_Reservation_Detail
- 为与数据库保持一致，所有Reservation\_\*字段，全部变为History\_Reservation\_\*
- post信息中Reservation_Date字段含义不明，故而没有使用

###预约医生 Reservation
- Doctor表中不存在“已预约人数”对应的字段，忽略

###查看是否支付 Check_PayState
- 返回状态含义修改，msg = 1表明查询失败，msg = 0表示查询成功，info记录查询结果

###*充值 In_Cash*
- User表中不存在“账户余额”对应的字段（*这是怎么个情况= =*）
