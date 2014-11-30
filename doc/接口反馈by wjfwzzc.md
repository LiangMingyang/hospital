> 本反馈从《接口信息规范4.0》第9页开始

###sql文件改动
- 添加外键约束
- 实体集主键全部添加ON UPDATE CASCADE ON DELETE RESTRICT属性，即级联更新、删除受外键约束
- 所有FLOUT和REAL类型全部变成DECIMAL，因为金额必须储存精确值，至于精确的位数还需要定一下
- 参照文档，User添加Sex和Amount字段

###查看历史 Check_History_Reservation_Simple
- url路径改成host/Check_History_Reservation_Simple
- 为与数据库保持一致，所有Reservation\_\*字段，应全部变为History_Reservation\_\*
- content内的State含义不明，故而没有返回相应字段

###查看单条历史详情 Check_History_Reservation_Detail
- url路径改成host/Check_History_Reservation_Detail
- 为与数据库保持一致，所有Reservation\_\*字段，应全部变为History_Reservation\_\*
- post请求中Reservation_Date字段含义不明，故而没有使用（有ID的情况下也不需要其它信息）

###预约医生 Reservation
- 字段“Reseration_Symptom”拼写错误，因与查询操作直接相关，需要修改
- 没有提供Reservation_Time字段，不在后台本地获取的原因是前后端系统时间可能有误差，应以用户看到的前端时间为准
- 没有提供Reservation_PayAmount字段，当然也可以在支付挂号费时提供，但支付挂号费时也没有提供
- Doctor表中不存在“已预约人数”对应的字段，暂时忽略
- 解释一下Doctor_Limit字段的含义，如果是上限，是应该不动，还是应该逐渐减少？如果不动，哪个字段记录了已预约次数？
- 如果Doctor表有对应的increase操作，User表是否也应该进行对应的increase

###取消预约 del_Reservation
- 如果预约时需要increase，那么取消时是否应该decrease
- 已支付时要退钱这个注意到了，但还是同样的问题，Reservation_PayAmount字段从没赋过值，不知道该退多少钱

###查看是否支付 Check_PayState
- 返回状态含义修改，msg = 1表明查询失败，msg = 0表示查询成功，info记录查询结果（0代表已支付，否则为未支付）

###支付挂号费 Pay_Reservation
- 没有提供Reservation_PayTime字段，理由同预约医生接口
- 不仅修改状态，而且应从余额里扣除对应的钱数，但对应预约医生接口中的问题，没有提供Reservation_PayAmount字段
- 在已经存在Reservation_Time字段和Reservation_PayTime字段的情况下，求解释Operation_Time字段的含义

###*审核注册 Check_Register*
- 没搞明白这个函数的意思……

###取消预约 Cancel_Reservation
- 与del_Reservation的含义和行为完全一致，可删去

###get_UserInfo_byID
- 文档3.1版本补丁中添加此接口，4.0版本中消失，估计是文档遗漏，在此作为提醒，后台已实现此接口

###创建医院 Create_Hospital
- 创建医院前检查医院是否已经存在的工作，是交给PHP还是Node.js？
- 注册register也存在上述问题