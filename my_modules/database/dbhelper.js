var crypto = require('crypto');
var strftime = require("strftime");
var connect = global.connect;

exports.check = function (req, res, next) {
    var secret = global.secret_key;
    var sendtime = new Date(req.body.encrypttime);
    var token = req.body.token;
    if (!sendtime || !token) {
        res.json({
            msg: 1,
            info: "格式不合法"
        });
        return;
    }
    var now = new Date();
    var hash = crypto.createHash('sha1');
    var delta = Math.abs(now - sendtime);
    if (delta > 60 * 1000) {
        res.json({
            msg: 2,
            info: "超时"
        });
        return;
    }
    var std = hash.update(secret + '$' + strftime("%F %T", sendtime)).digest('hex');
    if (std != token) {
        res.json({
            msg: 3,
            info: "token不正确"
        });
        return;
    }
    delete req.body.token;
    delete req.body.encrypttime;
    next();
};

var jsonToAnd = function (data) {
    var list = [];
    for (var key in data) {
        list.push(key + ' = ' + data[key]);
    }
    return ' ' + list.join(' AND ') + ' ';
};

var select = function (table, condition, callback, columns) { // SELECT语句的封装，便于重用
    condition = jsonToAnd(condition);
    connect.query('SELECT ?? FROM ?? WHERE ' + condition, [columns || '*', table], callback);
};

var find = function (table, condition, res, columns) { // 用于绝大多数find函数，便于重用
    select(table, condition, function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    }, columns);
};

var find_range = function (table, condition, start, size, res, columns) { // 用于绝大多数带limit的find函数，便于重用
    condition = jsonToAnd(condition);
    connect.query('SELECT COUNT(1) AS count FROM ?? WHERE ' + condition, function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        var count = rows[0].count;
        connect.query('SELECT ?? FROM ?? WHERE ' + condition + ' LIMIT ??,??',
            [columns || '*', table, start, size], function (err, rows) {
                if (err) {
                    res.json({
                        msg: 1,
                        info: err.message
                    });
                    return;
                }
                res.json({
                    msg: 0,
                    content: rows,
                    total: count
                });
            });
    });
};

exports.Register = function (req, res) {
    var table = 'User';
    var condition = req.body;
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length > 0) {
            res.json({
                msg: 1,
                info: '用户已经存在了'
            });
            return;
        }
        connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                info: '注册成功'
            });
        });
    };
    select(table, {'Identity_ID': condition.Identity_ID}, callback);
};

exports.Find_Hospital = function (req, res) {
    var table = 'Hospital';
    var condition = {
        Hospital_Level: req.body.Hospital_Level,
        Area_ID: req.body.Area_ID
    };
    var start = req.body.start;
    var size = req.body.size;
    var columns = [
        'Hospital_ID',
        'Hospital_introduction',
        'Hospital_Location'
    ];
    find_range(table, condition, start, size, res, columns);
};

exports.Find_Doctor = function (req, res) {
    var table = 'Doctor';
    var condition = {
        Depart_ID: req.body.Depart_ID
    };
    var start = req.body.start;
    var size = req.body.size;
    var columns = [
        'Doctor_ID',
        'Doctor_Name',
        'Doctor_Fee',
        'Doctor_Limit',
        'Doctor_Major'
    ];
    find_range(table, condition, start, size, res, columns);
};

exports.Update_Individual_Info = function (req, res) {
    var table = 'User';
    var condition = {
        User_ID: req.body.User_ID
    };
    var dest = req.body.Dest;
    condition = jsonToAnd(condition);
    connect.query('UPDATE ?? SET ? WHERE ' + condition, [table, dest], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '修改成功'
        });
    });
};

exports.Check_Reservation_Simple = function (req, res) {
    var table = [
        'Reservation',
        'Doctor'
    ];
    var condition = {
        User_ID: req.body.User_ID,
        'Reservation.Doctor_ID': 'Doctor.Doctor_ID'
    };
    var columns = [
        'Reservation_ID',
        'Reservation_Time',
        'Operation_Time',
        'Doctor_Name',
        'Reservation_Payed'
    ];
    find(table, condition, res, columns);
};

exports.Check_Reservation_Detail = function (req, res) {
    var table = [
        'Reservation',
        'Doctor',
        'Depart',
        'Hospital'
    ];
    var condition = {
        Reservation_ID: req.body.Reservation_ID,
        'Reservation.Doctor_ID': 'Doctor.Doctor_ID',
        'Doctor.Depart_ID': 'Depart.Depart_ID',
        'Depart.Hospital_ID': 'Hospital.Hospital_ID'
    };
    find(table, condition, res);
};

exports.Check_History_Reservation_Simple = function (req, res) {
    var table = [
        'History_Reservation',
        'Doctor'
    ];
    var condition = {
        History_Reservation_ID: req.body.Reservation_ID,
        'History_Reservation.Doctor_ID': 'Doctor.Doctor_ID'
    };
    var start = req.body.start;
    var size = req.body.size;
    var startDate = req.body.startDate;
    var endDate = req.body.endDate;
    var columns = [
        'History_Reservation_ID',
        'History_Reservation_Time',
        'History_Operation_Time',
        'Doctor_Name'
    ];
    condition = jsonToAnd(condition);
    connect.query('SELECT ?? FROM ?? WHERE ' + condition + ' AND ?? BETWEEN ?? AND ?? LIMIT ??,??',
        [columns, table, 'History_Reservation_Time', startDate, endDate, start, size], function (err, rows) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                content: rows
            });
        });
};

exports.Check_History_Reservation_Detail = function (req, res) {
    var table = [
        'History_Reservation',
        'Doctor',
        'Depart',
        'Hospital'
    ];
    var condition = {
        History_Reservation_ID: req.body.History_Reservation_ID,
        'History_Reservation.Doctor_ID': 'Doctor.Doctor_ID',
        'Doctor.Depart_ID': 'Depart.Depart_ID',
        'Depart.Hospital_ID': 'Hospital.Hospital_ID'
    };
    find(table, condition, res);
};

exports.Reservation = function (req, res) { // 写晕了，谁来帮帮我
    var table = [
        'Reservation',
        'Doctor'
    ];
    var condition = {
        'Doctor.Doctor_ID': req.body.Doctor_ID,
        'Reservation.Doctor_ID': 'Doctor.Doctor_ID'
    };
    var columns = [
        'Doctor_Limit',
        'Doctor_Fee'
    ];
    // JS中貌似不存在能直接格式化成MySQL的datetime格式的东西
    var date = new Date();
    var dateString = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate(); //TODO 因为我查API，奇葩地发现它返回的是0~11……
    //var dateString = strftime("%F", date);
    //console.log(dataString); //2014-12-03
    condition = jsonToAnd(condition);
    // 查询挂号是否已满
    connect.query('SELECT ??, COUNT(*) AS count FROM ?? WHERE ' + condition + ' AND ?? BETWEEN '
        + dateString + ' 00:00:00 AND ' + dateString + ' 23:59:59',
        [columns, table, 'Reservation_Time'], function (err, rows) { // 查询当天该Doctor_ID所有挂号的条目数
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            if (rows[0].count >= rows[0].Doctor_Limit) { // 若不小于Doctor_Limit，返回挂号数已满
                res.json({
                    msg: 2,
                    info: '预约已满'
                });
                return;
            }
            table = 'Reservation';
            condition = req.body;
            condition.Reservation_PayAmount = rows[0].Doctor_Fee; // 之前顺便查了Doctor_Fee，节省了一次查询
            connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) { // 插入挂号信息
                if (err) {
                    res.json({
                        msg: 1,
                        info: err.message
                    });
                    return;
                }
                res.json({
                    msg: 0,
                    info: '挂号成功'
                });
            });
        });
};

exports.del_Reservation = function (req, res) { //更晕了，要死了
    var table = 'Reservation';
    var condition = req.body;
    var columns = [
        'Reservation_Payed',
        'Reservation_PayAmount',
        'User_ID'
    ];
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows[0].Reservation_Payed == 0) { // 如果已支付过挂号费，需要退款
            table = 'User';
            condition = {
                User_ID: rows[0].User_ID
            };
            var dest = {
                Amount: Amount + rows[0].Reservation_PayAmount
            };
            connect.query('UPDATE ?? SET ? WHERE ' + condition, [table, dest], function (err, result) { // 退款过程
                if (err) {
                    res.json({
                        msg: 1,
                        info: err.message
                    });
                    return;
                }
                table = 'Reservation';
                condition = req.body;
                connect.query('DELETE FROM ?? WHERE ' + condition, table, function (err, result) { // 删除挂号条目
                    if (err) {
                        res.json({
                            msg: 1,
                            info: err.message
                        });
                        return;
                    }
                    res.json({
                        msg: 0,
                        info: '挂号已取消'
                    });
                });
            });
        }
    };
    select(table, condition, callback, columns);
};

exports.Check_PayState = function (req, res) {
    var table = 'Reservation';
    var condition = req.body;
    var columns = 'Reservation_Payed';
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: rows[0].Reservation_Payed // == 0 ? '已支付' : '未支付'
        });
    };
    select(table, condition, callback, columns);
};

exports.Check_Cash = function (req, res) {
    var table = 'User';
    var condition = req.body;
    var columns = 'Amount';
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: rows[0].Amount
        });
    };
    select(table, condition, callback, columns);
};

exports.In_Cash = function (req, res) {
    var table = 'User';
    var condition = {
        User_ID: req.body.User_ID
    };
    var dest = {
        Amount: Amount + req.body.Amout
    };
    connect.query('UPDATE ?? SET ? WHERE ' + condition, [table, dest], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '充值成功'
        });
    });
};

exports.Pay_Reservation = function (req, res) {
    var table = 'Reservation';
    var condition = {
        Reservation_ID: req.body.Reservation_ID,
        User_ID: req.body.User_ID
    };
    var columns = [
        'Reservation_Payed',
        'Reservation_PayAmount'
    ];
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows[0].Reservation_Payed == 0) {
            res.json({
                msg: 1,
                info: '挂号单已支付过'
            });
            return;
        }
        table = [
            'Reservation',
            'User'
        ];
        condition = {
            Reservation_ID: req.body.Reservation_ID,
            'User.User_ID': req.body.User_ID,
            'Reservation.User_ID': 'User.User_ID'
        };
        var dest = {
            Amount: Amount - rows[0].Reservation_PayAmount,
            Reservation_Payed: 0,
            Reservation_PayTime: req.body.Reservation_PayTime
        };
        condition = jsonToAnd(condition);
        connect.query('UPDATE ?? SET ? WHERE ' + condition, [table, dest], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                info: '支付成功'
            });
        });
    };
    select(table, condition, callback, columns);
};

//TODO Check_Register 这是什么鬼……
//exports.Check_Register = function (req, res) {
//
//};

exports.Get_Reservation_Info = function (req, res) {
    var table = [
        'Reservation',
        'Doctor',
        'Depart',
        'Hospital'
    ];
    var start = req.body.start;
    var size = req.body.size;
    var condition = {
        Reservation_ID: req.body.Reservation_ID,
        Hospital_ID: req.body.Hospital_ID,
        'Reservation.Doctor_ID': 'Doctor.Doctor_ID',
        'Doctor.Depart_ID': 'Depart.Depart_ID',
        'Depart.Hospital_ID': 'Hospital.Hospital_ID'
    };
    var columns = [
        'UserName',
        'Doctor_Name',
        'Reservation_ID',
        'Reservation_Time',
        'Operation_Time',
        'Doctor_Name'
    ];
    condition = jsonToAnd(condition);
    connect.query('SELECT ?? FROM ?? WHERE ' + condition + ' LIMIT ??,??',
        [columns, table, start, size], function (err, rows) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                content: rows
            });
        });
};

exports.Search_By_Identity = function (req, res) {
    var table = [
        'Reservation',
        'Doctor',
        'User'
    ];
    var condition = {
        Identity_ID: req.body.Identity_ID,
        'Reservation.Doctor_ID': 'Doctor.Doctor_ID',
        'Reservation.User_ID': 'User.User_ID'
    };
    var columns = [
        'UserName',
        'Doctor_Name',
        'Reservation_ID',
        'Reservation_Time',
        'Operation_Time',
        'Doctor_Name'
    ];
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback, columns);
};

exports.Find_User_By_Identity_ID = function (req, res) {
    var table = [
        'User',
        'Area',
        'Province'
    ];
    var condition = {
        Identity_ID: req.body.Identity_ID,
        'User.Area_ID': 'Area.Area_ID',
        'Area.Province_ID': 'Province.Province_ID'
    };
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback);
};

exports.get_UserInfo_byID = function (req, res) {
    var table = [
        'User',
        'Area',
        'Province'
    ];
    var condition = {
        User_ID: req.body.User_ID,
        'User.Area_ID': 'Area.Area_ID',
        'Area.Province_ID': 'Province.Province_ID'
    };
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback);
};

exports.Set_CreditRank_user_ID = function (req, res) {
    var table = 'User';
    var condition = {
        User_ID: req.body.User_ID
    };
    var dest = {
        Credit_Rank: req.body.Credit_Rank
    };
    condition = jsonToAnd(condition);
    connect.query('UPDATE ?? SET ? WHERE ' + condition, [table, dest], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '信用等级已调整'
        });
    });
};

exports.Create_Hospital = function (req, res) {
    var table = 'Hospital';
    var condition = req.body;
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length > 0) {
            res.json({
                msg: 1,
                info: '医院已经存在了'
            });
            return;
        }
        //执行插入
        connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                info: '医院创建成功'
            });
        });
    };
    select(table, {'Hospital_Name': condition.Hospital_Name}, callback);
};

exports.Get_HospitalInfo_simple = function (req, res) {
    var table = [
        'Hospital',
        'Manage'
    ];
    var condition = {
        Admin_ID: req.body.Admin_ID,
        'Manage.Hospital_ID': 'Hospital.Hospital_ID'
    };
    var columns = [
        'Hospital_ID',
        'Hospital_Name'
    ];
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback, columns);
};

exports.Get_HospitalInfo_detail = function (req, res) {
    var table = 'Hospital';
    var condition = req.body;
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback);
};

exports.Set_HospitalInfo = function (req, res) {
    var table = 'Hospital';
    var condition = {
        Hospital_ID: req.body.Hospital_ID
    };
    var dest = req.body;
    condition = jsonToAnd(condition);
    connect.query('UPDATE ?? SET ? WHERE' + condition, [table, dest], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '医院信息配置成功'
        });
    })
};

exports.Create_Depart = function (req, res) {
    var table = 'Depart';
    var condition = req.body;
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length > 0) {
            res.json({
                msg: 1,
                info: '科室已经存在了'
            });
            return;
        }
        //执行插入
        connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                info: '科室创建成功'
            });
        });
    };
    select(table, {'Depart_Name': condition.Depart_Name}, callback);
};

exports.Get_DepartInfo = function (req, res) {
    var table = 'Depart';
    var condition = req.body;
    var columns = [
        'Depart_ID',
        'Deprt_Name'
    ];
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback, columns);
};

exports.Get_DoctorInfo = function (req, res) {
    var table = 'Doctor';
    var condition = req.body;
    var columns = [
        'Doctor_ID',
        'Doctor_Name'
    ];
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback, columns);
};

exports.Get_DoctorInfo_detail = function (req, res) {
    var table = 'Doctor';
    var condition = req.body;
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback);
};

exports.Add_Doctor = function (req, res) {
    var table = 'Doctor';
    var condition = req.body;
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length > 0) {
            res.json({
                msg: 1,
                info: '医生已经存在了'
            });
            return;
        }
        //执行插入
        connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                info: '医生添加成功'
            });
        });
    };
    select(table, {'Doctor_Name': condition.Doctor_Name}, callback);
};

exports.Set_DoctorInfo = function (req, res) {
    var table = 'Doctor';
    var condition = {
        Doctor_ID: req.body.Doctor_ID
    };
    var dest = req.body;
    condition = jsonToAnd(condition);
    connect.query('UPDATE ?? SET ? WHERE' + condition, [table, dest], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '医生信息配置成功'
        });
    })
};

exports.Add_Admin = function (req, res) {
    var table = 'Admin';
    var condition = req.body;
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length > 0) {
            res.json({
                msg: 1,
                info: '管理员已经存在了'
            });
            return;
        }
        //执行插入
        connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                info: '管理员添加成功'
            });
        });
    };
    select(table, {'Admin_Name': condition.Admin_Name}, callback);
};

exports.Get_AdminInfo = function (req, res) {
    var table = 'Admin';
    var columns = [
        'Admin_ID',
        'Admin_Name'
    ];
    connect.query('SELECT ?? FROM ??', [columns, table], function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    });
};

exports.Get_Privilege = function (req, res) {
    var table = [
        'Admin',
        'Hospital'
    ];
    var condition = {
        Hospital_ID: req.body.Hospital_ID,
        'Admin.Hospital_ID': 'Hospital.Hospital_ID'
    };
    var columns = [
        'Hospital_ID',
        'Hospital_Name'
    ];
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            content: rows
        });
    };
    select(table, condition, callback, columns);
};

var tupleToString = function (data, str) {
    var list = [];
    data.forEach(function (element) {
        list.push('(' + element + ', ' + str + ')');
    });
    return ' ' + list.join(', ') + ' ';
};

exports.Give_Privilege = function (req, res) {
    var table = 'Manage';
    var dest = tupleToString(res.body.Hospital_ID, res.body.Admin_ID);
    connect.query('INSERT INTO ?? (??, ??) VALUES ' + dest, [table, 'Hospital_ID', 'Admin_ID'], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '权限赋予成功'
        });
    });
};

exports.Del_Privilege = function (req, res) {
    var table = 'Manage';
    var condition_admin = {
        Admin_ID: req.body.Admin_ID
    };
    condition_admin = jsonToAnd(condition_admin);
    var condition_hospital = ' (' + res.body.Hospital_ID.join(', ') + ') ';
    connect.query('DELETE FROM ?? WHERE ' + condition_admin + ' AND ?? IN ' + condition_hospital,
        [table, 'Hospital_ID'], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                info: '权限解除成功'
            });
        });
};

exports.del_Admin = function (req, res) {
    var table = 'Admin';
    var condition = ' (' + res.body.Admin_ID.join(', ') + ') ';
    connect.query('DELETE FROM ?? WHERE ?? IN ' + condition, [table, 'Admin_ID'], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '管理员账号删除成功'
        });
    });
};

// Added since API version 4.4 update 1

// why name it like this, doesn't `ID`==`Identity`?
exports.find_User_By_Identity_ID = function (req, res) {
    var table = 'User';
    var condition = {
        UserName: req.body.UserName
    };
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length == 0) {
            res.json({
                msg: 1,
                info: "这个用户不存在"
            });
            return;
        }
        // Since the return object of this API doesn't have `content` field,
        // we have to take a different way.
        ret_obj = {};
        for (key in rows[0]) {
            ret_obj[key] = rows[0][key];
        }
        ret_obj["msg"] = 0;
        res.json(ret_obj);
    };

    // do the real query here
    find(table, condition, callback);
};

// get admin entity given its name
exports.Find_Admin_By_Admin_Name = function (req, res) {
    var table = 'Admin';
    connect.query('DELETE FROM ?? WHERE Admin_Name = ??', [table, res.body.Admin_Name], function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        ret_obj = {};
        ret_obj.msg = 0;
        ret_obj.Admin_ID = rows[0].Admin_ID;
        ret_obj.Mail = rows[0].Mail;
        ret_obj.isSuper = rows[0].isSuper;
        res.json(ret_obj);
    });
};

exports.Get_Province_info = function (req, res) {
    connect.query('select * from province', function (err, rows) {
        if (!!err) {
            res.json({
                msg: 1,
                info: 'Cannot query province table.'
            });
        }
        res.json({
            msg: 0,
            content: rows
        });
    });
};

exports.Get_Area_Info_By_Province_ID = function (req, res) {
    var pid = req.body.Province_ID;
    connect.query('select * from area where province_id = ??', [pid], function (err, rows) {
        if (!!err) {
            res.json({
                msg: 1,
                info: 'Cannot query area table.'
            });
        }
        res.json({
            msg: 0,
            content: rows
        });
    });
};

exports.Find_Hospital_By_Condition = function (req, res) {
    connect.query('select * from hospital where ??', jsonToAnd(req.body), function (err, rows) {
        if (!!err) {
            res.json({
                msg: 1,
                info: 'Cannot query hospital table.'
            });
        }
        res.json({
            msg: 0,
            total: rows.length,
            content: rows
        });
    });
};

// Frontend should never bother backend, this function is very unelegant
exports.Get_History_Reservation_For_Flexigrid = function (req, res) {
    // a mess
    var page = req.body.page;
    var qtype = req.body.qtype;     // buddha of study said we can ignore this one
    var query = req.body.query;

    // What, we need to parse string for the front end?!!!!
    var time = query.split('!');
    var startTime = new Date(time[0]);
    var endTime = new Date(time[1]);
    var rp = req.body.rp;           // regard this one as size
    var sortname = req.body.sortname;   // sort rows by this field
    var sortorder = req.body.sortorder; // ascending or descending

    // construct condition
    var condition = 'datetime between ' + startTime.toString() + ' and ' + endTime.toString();
    var table = 'reservation';
    connect.query('select * from ?? where ' + condition, table, function (err, rows) {
        if (!!err) {
            res.json({
                msg: 1,
                info: 'Cannot query database.'
            });
            return;
        }
        var ret_obj = {};
        ret_obj.Total = rows.length;
        ret_obj.from = page;
        ret_obj.to = page + rp - 1;
        ret_obj.rows = rows.map(function (e) {
            return {id: e.Reservation_ID, cell: e};
        });
    });
};
