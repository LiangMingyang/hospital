var crypto = require('crypto');
var hash = crypto.createHash('sha1');
var secret = global.secret_key;
var strftime = require("strftime");
var connect = global.connect;
exports.check = function (req, res, next) {
    //var sendtime = new Date(req.body.encrypttime);
    //var token    = req.body.token;
    //if(!sendtime || !token) {
    //    res.json({
    //        msg : 1,
    //        info: "格式不合法"
    //    })
    //    return ;
    //}
    //var now = new Date();
    //var delta = Math.abs(now-sendtime);
    //if(delta > 60*1000) {
    //    res.json({
    //        msg : 2,
    //        info:"超时"
    //    })
    //    return;
    //}
    //
    //
    //if(hash.update(secret+'$'+strftime("%F %T",sendtime)).digest('hex') != token) {
    //    res.json({
    //        msg : 3,
    //        info:"token不正确"
    //    })
    //    return;
    //}
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

//console.log(jsonToAnd({
//    'u.username':'lmy',
//    password:'yml'
//}));

//var select = function (table, condition, callback, columns) { //扩展了功能，便于后面重用
//    condition = jsonToAnd(condition);
//    connect.query('SELECT ?? FROM ?? WHERE ' + condition, [columns || '*', table], function (err, rows) {
//        if (err) {
//            if (callback) {
//                callback(err, rows);
//            }
//            return;
//        }
//        if (callback) {
//            callback(null, rows);
//        }
//    });
//};

var select = function (table, condition, callback, columns) { //SELECT语句的封装，便于重用
    condition = jsonToAnd(condition);
    connect.query('SELECT ?? FROM ?? WHERE ' + condition, [columns || '*', table], callback);
};

var find = function (table, condition, res, columns) { //用于绝大多数find函数，便于重用
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

var find_range = function (table, condition, start, size, res, columns) { //用于绝大多数带limit的find函数，便于重用
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

//exports.Find_User = function (req, res) {
//    var table = 'User';
//    var condition = {
//        UserName: req.body.UserName
//    };
//    var callback = function (err, rows) {
//        if (err) {
//            res.json({
//                msg: 1,
//                info: err.message
//            });
//            return;
//        }
//        if (rows.length == 0) {
//            res.json({
//                msg: 1,
//                info: "这个用户不存在"
//            });
//            return;
//        }
//        res.json({
//            msg: 0,
//            content: rows[0]
//        });
//    };
//    select(table, condition, callback);
//};

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

exports.Reservation = function (req, res) {
    var table = 'Reservation';
    var condition = req.body;
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
            info: '预订成功'
        });
    });
    //TODO increase doctor.limit? what about user.limit?
};

exports.del_Reservation = function (req, res) {
    var table = 'Reservation';
    var condition = req.body;
    condition = jsonToAnd(condition);
    connect.query('DELETE FROM ?? WHERE ' + condition, table, function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '取消预订成功'
        });
    });
    //TODO decrease doctor.limit? what about user.limit?
    //TODO 如果已经支付过挂号费，需要退款
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
    var columns = 'Amount';
    var callback = function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        var dest = {
            Amount: rows[0].Amount + req.body.Amout
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
    select(table, condition, callback, columns);
};

exports.Pay_Reservation = function (req, res) {
    var table = 'Reservation';
    var condition = req.body;
    var dest = {
        Reservation_Payed: 0
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
