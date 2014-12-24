var crypto = require('crypto');
var strftime = require("strftime");
var connect = global.connect;
var trim = require('trim');

exports.check = function (req, res, next) {
    //TODO: 暂时把验证取消了
    delete req.body.token;
    delete req.body.encrypttime;
    next();
    return;

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
    var relation = data.relation;
    if (relation) {
        for (var key in relation) {
            list.push(key + ' = ' + relation[key]);
        }
    }
    for (var key in data) {
        if (key == 'relation')continue;
        list.push(key + ' = ' + '\'' + data[key] + '\'');
    }
    return ' ' + list.join(' AND ') + ' ';
};

var select = function (table, condition, callback, columns) { // SELECT语句的封装，便于重用
    condition = jsonToAnd(condition);
    if (trim(condition) != '') { // 如果condition的属性为空，则转换成的字符串应该是'  '
        condition = ' WHERE ' + condition;
    }
    if (columns) {
        connect.query('SELECT ?? FROM ?? ' + condition, [columns, table], callback);
    }
    else {
        connect.query('SELECT * FROM ?? ' + condition, [table], callback);
    }
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
    if (trim(condition) != '') { // 如果condition的属性为空，则转换成的字符串应该是'  '
        condition = ' WHERE ' + condition;
    }
    connect.query('SELECT COUNT(1) AS count FROM ?? ' + condition, [table], function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        var count = rows[0].count;
        if (columns) {
            connect.query('SELECT ?? FROM ?? ' + condition + ' LIMIT ?,?',
                [columns, table, parseInt(start), parseInt(size)], function (err, rows) {
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
        }
        else {
            connect.query('SELECT * FROM ?? ' + condition + ' LIMIT ?,?', [table, parseInt(start), parseInt(size)],
                function (err, rows) {
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
        }
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
    select(table, {Identity_ID: condition.Identity_ID}, callback);
};

exports.Find_Hospital = function (req, res) {
    var table = 'Hospital';
    var condition = {
        Area_ID: req.body.Area_ID,
        Hospital_Level: req.body.Hospital_Level
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

exports.LogIn_User = function (req, res) {
    var table = 'User';
    var condition = req.body;
    var password = condition.PASSWORD;
    delete condition.PASSWORD;
    select(table, condition, function (err, rows) {
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
                info: "用户名不存在"
            });
            return;
        }
        var user = rows[0];
        ///判断用户是否被锁定了
        //TODO:暂时被锁定了不会更新LastLoginTime
        var last = new Date(user.LastLogInTime);
        var now = new Date();
        if (user.FailTime >= 3 && (now - last) < 60 * 60 * 1000) {
            res.json({
                msg: 1,
                info: "该用户被锁定，请联系管理员"
            })
            return;
        }
        ///判断登陆是否成功
        user.LastLogInTime = strftime("%F %T", now);
        if (user.PASSWORD == password) {
            user.FailTime = 0;
            Config('User', condition, user, function (err, result) {
                if (err) {
                    res.json({
                        msg: 1,
                        info: err.message
                    })
                    return;
                }
                res.json({
                    msg: 0,
                    content: user
                })
            })
        } else {
            if (user.FailTime < 3)++user.FailTime;
            Config('User', condition, user, function (err, result) {
                if (err) {
                    res.json({
                        msg: 1,
                        info: err.message
                    })
                    return;
                }
                res.json({
                    msg: 1,
                    info: "密码不正确"
                })
            })
        }
    });
};

exports.LogIn_Admin = function (req, res) {
    var table = 'Admin';
    var condition = req.body;
    select(table, condition, function (err, rows) {
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
                info: "用户名或密码不正确"
            });
            return;
        }
        var admin = rows[0];
        admin.LastLogInTime = strftime("%F %T", new Date());
        Config('Admin', condition, admin, function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                content: admin
            })
        })
    });
};

exports.UpdatePwd_Admin = function (req, res) {
    var table = 'Admin';
    var condition = {
        Admin_ID: req.body.Admin_ID
    };
    var dest = {
        PASSWORD: req.body.PASSWORD
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
            msg: 0
        });
    });
};

exports.UpdatePwd_User = function (req, res) {
    var table = 'User';
    var condition = {
        User_ID: req.body.User_ID
    };
    var dest = {
        PASSWORD: req.body.PASSWORD
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
            msg: 0
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
        relation: {
            'Reservation.Doctor_ID': 'Doctor.Doctor_ID'
        }
    };
    var columns = [
        'Reservation_ID',
        'Reservation_Time',
        'Operation_Time',
        'Doctor_Name',
        'Reservation_Payed'
    ];
    find(table, condition, res);
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
        relation: {
            'Reservation.Doctor_ID': 'Doctor.Doctor_ID',
            'Doctor.Depart_ID': 'Depart.Depart_ID',
            'Depart.Hospital_ID': 'Hospital.Hospital_ID'
        }
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
        relation: {
            'History_Reservation.Doctor_ID': 'Doctor.Doctor_ID'
        }
    };
    var start = req.body.start;
    var size = req.body.size;
    var startDate = req.body.startDate;
    var endDate = req.body.endDate;
    var columns = [
        'History_Reservation_ID',
        'History_Reservation_Time',
        'History_Operation_Time',
        'Doctor_Name',
        'Duty_Time'
    ];
    condition = jsonToAnd(condition);
    connect.query('SELECT ?? FROM ?? WHERE ' + condition + ' AND ?? BETWEEN ?? AND ?? LIMIT ?,?',
        [columns, table, 'History_Reservation_Time', startDate, endDate, parseInt(start), parseInt(size)],
        function (err, rows) {
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
        relation: {
            'History_Reservation.Doctor_ID': 'Doctor.Doctor_ID',
            'Doctor.Depart_ID': 'Depart.Depart_ID',
            'Depart.Hospital_ID': 'Hospital.Hospital_ID'
        }
    };
    find(table, condition, res);
};

function twoDigits(d) {
    if (0 <= d && d < 10) return "0" + d.toString();
    if (-10 < d && d < 0) return "-0" + (-1 * d).toString();
    return d.toString();
}

function currentDatetime() {
    var date = new Date();
    return date.getUTCFullYear() + "-" + twoDigits(1 + date.getUTCMonth()) + "-" + twoDigits(date.getUTCDate()) + " " + twoDigits(date.getUTCHours()) + ":" + twoDigits(date.getUTCMinutes()) + ":" + twoDigits(date.getUTCSeconds());
}

exports.Reservation = function (req, res) {
    var table = 'Reservation';
    var condition = {
        'Doctor_ID': req.body.Doctor_ID,
        'Duty_Time': req.body.Duty_Time,
        'Reservation_Time': req.body.Reservation_Time
    };
    condition = jsonToAnd(condition);
    connect.query('SELECT COUNT(1) AS count FROM ?? WHERE ' + condition, [table], function (err, count) { // 查询当天该Doctor_ID所有挂号的条目数
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        var cnt = count[0].count;
        select('Doctor', {Doctor_ID: condition.Doctor_ID}, function (err, rows) {
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
                    info: "没有对应的医生"
                });
                return;
            }
            var doctor = rows[0];
            console.log(doctor);
            if (doctor.Doctor_Limit >= cnt) {
                res.json({
                    msg: 1,
                    info: "这个医生这个时间已经满了"
                });
                return;
            }
            condition.Reservation_PayAmount = docotor.Doctor_Fee;
            condition.Operation_Time = currentDatetime();
            condition.User_ID = req.body.User_ID;
            condition.Reservation_Symptom = req.body.Reservation_Symptom;
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
                    info: '挂号成功'
                });
            });
        })
    });
};

exports.Cancel_Reservation = function (req, res) {
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
        if (rows.length == 0) {
            res.json({
                msg: 4,
                info: "没有符合条件的信息"
            })
            return;
        }
        if (rows[0].Reservation_Payed == 1) { // 如果已支付过挂号费，需要退款
            table = 'User';
            condition = {
                User_ID: rows[0].User_ID
            };
            condition = jsonToAnd(condition);
            connect.query('UPDATE ?? SET Amount = Amount + ' + rows[0].Reservation_PayAmount + ' WHERE ' + condition, [table], function (err, result) { // 退款过程
                if (err) {
                    res.json({
                        msg: 1,
                        info: err.message
                    });
                    return;
                }
                table = 'Reservation';
                condition = req.body;
                condition = jsonToAnd(condition);
                connect.query('DELETE FROM ?? WHERE ' + condition, [table], function (err, result) { // 退款成功，则删除挂号条目
                    if (err) {
                        res.json({
                            msg: 1,
                            info: err.message
                        });
                        return;
                    }
                    res.json({
                        msg: 0,
                        info: '挂号已取消，已退款'
                    });
                });
            });
        } else {    // 若没有支付，则直接删除记录
            table = 'Reservation';
            condition = req.body;
            condition = jsonToAnd(condition);
            connect.query('DELETE FROM ?? WHERE ' + condition, [table], function (err, result) { // 退款成功，则删除挂号条目
                if (err) {
                    res.json({
                        msg: 1,
                        info: err.message
                    });
                    return;
                }
                res.json({
                    msg: 0,
                    info: '挂号已取消，未退款'
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
        if (rows.length == 0) {
            res.json({
                msg: 4,
                info: "没有符合条件的信息"
            })
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
        if (rows.length == 0) {
            res.json({
                msg: 4,
                info: "没有符合条件的信息"
            })
            return;
        }
        if (rows.length == 0) {
            res.json({
                msg: 4,
                info: "没有符合条件的信息"
            })
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
    condition = jsonToAnd(condition);
    connect.query('UPDATE ?? SET Amount = Amount + ' + req.body.Amount + ' WHERE ' + condition,
        [table], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            if (result.affectedRows == 0) {
                res.json({
                    msg: 1,
                    info: "充值失败"
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
        Reservation_ID: req.body.Reservation_ID
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
        if (rows.length < 1) {
            res.json({
                msg: 1,
                info: 'No record'
            });
            return;
        }
        if (rows[0].Reservation_Payed == 1) {
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
            //'User.User_ID': req.body.User_ID,
            relation: {
                'Reservation.User_ID': 'User.User_ID'
            }
        };
        /*var dest = {
         Amount: Amount - rows[0].Reservation_PayAmount,
         Reservation_Payed: 1,
         Reservation_PayTime: req.body.Reservation_PayTime
         };*/
        condition = jsonToAnd(condition);
        //connect.query('UPDATE ?? SET ? WHERE ' + condition, [table, dest], function (err, result) {
        var qq = connect.query('UPDATE Reservation, User SET User.Amount=User.Amount-' + rows[0].Reservation_PayAmount + ', Reservation_Payed=1, Reservation_PayTime=\'' + currentDatetime() + '\' WHERE ' + condition, function (err, result) {
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
        console.log('Pay with: ' + qq.sql);
    };
    select(table, condition, callback, columns);
};

exports.Check_Register = function (req, res) {
    var table = 'User';
    var condition = req.body;
    var columns = [
        'isChecked',
        'Mail',
        'Phone'
    ];
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
                info: "Not found"
            });
            return;
        }
        if (rows[0].isChecked == 1) {
            res.json({
                msg: 0,
                Mall: rows[0].Mail,
                Phone: rows[0].Phone
            });
        } else {
            res.json({
                msg: 0
            });
        }
    };
    connect.query('update User set isChecked = ' + condition.isChecked +
    ' where User_ID=' + condition.User_ID, function (err, rows) {
        if (!!err) {
            console.log(err.message);
            return;
        } else {
            if (rows.affectedRows == 0) {
                res.json({
                    msg: 1,
                    info: "No line affected!"
                });
                return;
            }
        }
        select(table, condition, callback, columns);
    });
};

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
        relation: {
            'Reservation.Doctor_ID': 'Doctor.Doctor_ID',
            'Doctor.Depart_ID': 'Depart.Depart_ID',
            'Depart.Hospital_ID': 'Hospital.Hospital_ID'
        }
    };
    find_range(table, condition, start, size, res);
};

exports.Search_By_Identity = function (req, res) {
    var table = [
        'Reservation',
        'Doctor',
        'User'
    ];
    var condition = {
        Identity_ID: req.body.Identity_ID,
        relation: {
            'Reservation.Doctor_ID': 'Doctor.Doctor_ID',
            'Reservation.User_ID': 'User.User_ID'
        }
    };
    find(table, condition, res);
};

//exports.Set_CreditRank_user_ID = function (req, res) {
//    var table = 'User';
//    var condition = {
//        User_ID: req.body.User_ID
//    };
//    var dest = {
//        Credit_Rank: req.body.Credit_Rank
//    };
//    condition = jsonToAnd(condition);
//    connect.query('UPDATE ?? SET ? WHERE ' + condition, [table, dest], function (err, result) {
//        if (err) {
//            res.json({
//                msg: 1,
//                info: err.message
//            });
//            return;
//        }
//        res.json({
//            msg: 0,
//            info: '信用等级已调整'
//        });
//    });
//};

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
    select(table, {Hospital_Name: condition.Hospital_Name}, callback);
};

exports.Get_HospitalInfo_simple = function (req, res) {
    var table = [
        'Hospital',
        'Manage'
    ];
    var condition = {
        Admin_ID: req.body.Admin_ID,
        relation: {
            'Manage.Hospital_ID': 'Hospital.Hospital_ID'
        }
    };
    var columns = [
        'Manage.Hospital_ID',
        'Hospital_Name'
    ];
    find(table, condition, res, columns);
};

exports.Get_HospitalInfo_detail = function (req, res) {
    var table = 'Hospital';
    var condition = req.body;
    find(table, condition, res);
};

exports.Set_HospitalInfo = function (req, res) {
    var table = 'Hospital';
    var condition = {
        Hospital_ID: req.body.Hospital_ID
    };
    var dest = req.body;
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
    var condition = {
        Hospital_ID: req.body.Hospital_ID
    };
    var columns = [
        'Depart_ID',
        'Depart_Name'
    ];
    if (req.body.start && req.body.size) {
        var start = req.body.start;
        var size = req.body.size;
        find_range(table, condition, start, size, res, columns);
    }
    else {
        find(table, condition, res, columns);
    }
};

exports.Get_DoctorInfo = function (req, res) {
    var table = 'Doctor';
    var condition = {
        Depart_ID: req.body.Depart_ID
    };
    var columns = [
        'Doctor_ID',
        'Doctor_Name'
    ];
    if (req.body.start && req.body.size) {
        var start = req.body.start;
        var size = req.body.size;
        find_range(table, condition, start, size, res, columns);
    }
    else {
        find(table, condition, res, columns);
    }
};

exports.Get_DoctorInfo_detail = function (req, res) {
    var table = 'Doctor';
    var condition = req.body;
    find(table, condition, res);
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
    select(table, {Doctor_Name: condition.Doctor_Name}, callback);
};

exports.Set_DoctorInfo = function (req, res) {
    var table = 'Doctor';
    var condition = {
        Doctor_ID: req.body.Doctor_ID
    };
    var dest = req.body;
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
    select(table, {Admin_Name: condition.Admin_Name}, callback);
};

exports.Get_AdminInfo = function (req, res) {
    var table = 'Admin';
    var condition = {};
    var columns = [
        'Admin_ID',
        'Admin_Name'
    ];
    find(table, condition, res, columns);
};

exports.Get_Privilege = function (req, res) {
    var table = [
        'Hospital',
        'Manage'
    ];
    var condition = {
        'Manage.Admin_ID': req.body.Admin_ID,
        relation: {
            'Manage.Hospital_ID': 'Hospital.Hospital_ID'
        }
    };
    var columns = [
        'Hospital_ID',
        'Hospital_Name'
    ];
    find(table, condition, res);
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
    var dest = tupleToString(req.body.Hospital_ID.split(','), req.body.Admin_ID);
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
            info: '成功'
        });
    });
};

exports.Del_Privilege = function (req, res) {
    var table = 'Manage';
    var condition_admin = {
        Admin_ID: req.body.Admin_ID
    };
    condition_admin = jsonToAnd(condition_admin);
    var condition_hospital = ' (' + req.body.Hospital_ID + ') ';
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
    var condition = ' (' + req.body.Admin_ID + ') ';
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

exports.Find_User_By_Identity_ID = function (req, res) {
    var table = 'User';
    var condition = {
        Identity_ID: req.body.Identity_ID
    };
    find(table, condition, res);
};

exports.Find_Admin_By_Admin_Name = function (req, res) {
    var table = 'Admin';
    var condition = req.body;
    var columns = [
        'Admin_ID',
        'Mail',
        'isSuper'
    ];
    find(table, condition, res, columns);
};

exports.Get_Province_Info = function (req, res) {
    var table = 'Province';
    var condition = {};
    find(table, condition, res);
};

exports.Get_Area_Info_By_Province_ID = function (req, res) {
    var table = 'Area';
    var condition = req.body;
    find(table, condition, res);
};

exports.Find_Hospital_By_Condition = function (req, res) {
    var table = 'Hospital';
    var condition = {};
    if (req.body.Province_ID) {
        //condition.Province_ID = req.body.Province_ID;
        condition.relation = {
            'Area_ID div 100': req.body.Province_ID  //因为地区整除100即省份号
        }
    }
    if (req.body.Area_ID) {
        condition.Area_ID = req.body.Area_ID;
    }
    if (req.body.Hospital_Level) {
        condition.Hospital_Level = req.body.Hospital_Level;
    }
    var start = req.body.start;
    var size = req.body.size;
    find_range(table, condition, start, size, res);
};

// Frontend should never bother backend, this function is very unelegant
exports.Get_History_Reservation_For_Flexigrid = function (req, res) {
    // a mess
    var page = req.body.page;
    //var qtype = req.body.qtype;     // buddha of study said we can ignore this one
    var query = req.body.query;

    // What, we need to parse string for the front end?!!!!
    var time = query.split('!');
    var rp = req.body.rp;           // regard this one as size
    //var sortname = req.body.sortname;   // sort rows by this field
    //var sortorder = req.body.sortorder; // ascending or descending

    // construct condition
    var table = 'History_Reservation';
    connect.query('SELECT * FROM ?? WHERE ?? BETWEEN ?? AND ??',
        [table, 'History_Reservation_Time', time[0], time[1]], function (err, rows) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                Total: rows.length,
                from: page,
                to: page + rp - 1,
                rows: rows.map(function (element) {
                    return {id: element.Reservation_ID, cell: element};
                })
            });
        });
};

exports.Get_History_Reservation = function (req, res) {
    var table = "History_Reservation";
    var debug = connect.query('SELECT * FROM ?? WHERE ?? BETWEEN ? AND ? LIMIT ?,?',
        [table, 'History_Reservation_Time', req.body.Reservation_Start_Time, req.body.Reservation_End_Time, parseInt(req.body.start), parseInt(req.body.size)],
        function (err, rows) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            connect.query('SELECT COUNT(1) AS count FROM ?? WHERE ?? BETWEEN ? AND ?',
                [table, 'History_Reservation_Time', req.body.Reservation_Start_Time, req.body.Reservation_End_Time],
                function (err, count) {
                    if (err) {
                        res.json({
                            msg: 2,
                            info: err.message
                        });
                        return;
                    }
                    var total = count[0].count;
                    res.json({
                        msg: 0,
                        total: total,
                        content: rows
                    });
                });
        });
    console.log(debug.sql);
};


exports.Get_Hospital_Number_By_Condition = function (req, res) {
    //var table = [
    //    'Province',
    //    'Area',
    //    'Hospital'
    //];
    //var condition = {
    //    'Hospital.Area_ID': 'Area.Area_ID',
    //    'Area.Province_ID': 'Province.Province_ID'
    //};
    //if (req.body.Province_ID) {
    //    condition.Province_ID = req.body.Province_ID;
    //}
    //if (req.body.Area_ID) {
    //    condition.Area_ID = req.body.Area_ID;
    //}
    //if (req.body.Hospital_Level) {
    //    condition.Hospital_Level = req.body.Hospital_Level;
    //}
    //condition = jsonToAnd(condition);
    //connect.query('SELECT COUNT(1) AS count FROM ?? WHERE ' + condition, [table], function (err, rows) {
    //    if (err) {
    //        res.json({
    //            msg: 1,
    //            info: err.message
    //        });
    //        return;
    //    }
    //    res.json({
    //        msg: 0,
    //        num: rows[0].count
    //    });
    //});
    //TODO 现在写的姿势很不优雅，待优化
    var table = 'Hospital';
    var condition = req.body;
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
            num: rows.length
        });
    });
};

exports.Find_Doctor_By_Condition = function (req, res) {
    var table = [
        'Depart',
        'Hospital',
        'Doctor',
        'Doctor_Time'
    ];
    var condition = {
        relation: {
            'Doctor_Time.Doctor_ID': 'Doctor.Doctor_ID',
            'Doctor.Hospital_ID': 'Hospital.Hospital_ID',
            'Hospital.Depart_ID': 'Depart.Depart_ID'
        }
    };
    if (req.body.Depart_ID) {
        condition.Depart_ID = req.body.Depart_ID;
    }
    if (req.body.Hospital_ID) {
        condition.Hospital_ID = req.body.Hospital_ID;
    }
    if (req.body.Doctor_Level) {
        condition.Doctor_Level = req.body.Doctor_Level;
    }
    if (req.body.Duty_Time) {
        condition.Duty_Time = req.body.Duty_Time;
    }
    var columns = [
        'Doctor_ID',
        'Doctor_Name'
    ];
    find(table, condition, res, columns);
};

exports.Check_Admin_Repeat = function (req, res) {
    var table = 'Admin';
    var condition = req.body;
    condition = jsonToAnd(condition);
    connect.query('SELECT COUNT(1) AS count FROM ?? WHERE ' + condition, [table], function (err, rows) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            isRepeat: rows[0].count // == 0 ? 0 : 1
        });
    });
};

// TODO: very dirty SQL query!!!!!!!!!!!!!!!!!!!!!!
exports.Find_Doctor_By_Condition_Free = function (req, res) {
    var c1 = "";    // condition depart_ID
    var c2 = "";    // condition hospital_ID
    if (req.body.Depart_ID) {
        c1 = " and Doctor.Depart_ID = " + req.body.Depart_ID;
    }
    if (req.body.Hospital_ID) {
        c2 = " and Depart.Hospital_ID = " + req.body.Hospital_ID;
    }
    var sql =
        "select Doctor.Doctor_ID, Doctor.Doctor_Name from Doctor, Depart " +
        "where Doctor.Depart_ID = Depart.Depart_ID " +
        c1 +
        c2 +
        " and Doctor.Doctor_ID not in ( " +
        "select t1.did from ( " +
        "select Doctor.Doctor_ID as did, Doctor.Doctor_Limit from Doctor, Reservation, Doctor_Time" +
        " where Reservation.Doctor_ID = Doctor_Time.Doctor_ID and Doctor_Time.Doctor_ID = Doctor.Doctor_ID " +
        " and Reservation.Duty_Time = Doctor_Time.Duty_Time and Doctor_Time.Duty_Time = " + req.body.Duty_Time +
        " and Reservation.Reservation_Time = '" + req.body.Reservation_Time + "'" +
        " group by Doctor.Doctor_ID having count(Reservation.Reservation_ID) >= Doctor.Doctor_Limit" +
        ") as t1" +
        ")";
    console.log("SQL> " + sql);
    connect.query(sql, function (err, rows) {
        if (err) {
            console.log("ERR:" + sql);
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

    /*    var table = [
     'Depart',
     'Hospital',
     'Doctor',
     'Doctor_Time'
     ];
     var condition = {
     Reservation_Time: req.body.Reservation_Time,
     'Doctor_Time.Duty_Time': req.body.Duty_Time,
     relation: {
     'Doctor_Time.Doctor_ID': 'Doctor.Doctor_ID',
     'Doctor.Depart_ID': 'Depart.Depart_ID',
     'Depart.Hospital_ID': 'Hospital.Hospital_ID'
     //'Reservation.Duty_Time': 'Doctor_Time.Duty_Time'
     }
     };
     if (req.body.Depart_ID) {
     condition['Depart.Depart_ID'] = req.body.Depart_ID;
     }
     if (req.body.Hospital_ID) {
     condition['Hospital.Hospital_ID'] = req.body.Hospital_ID;
     }
     // TODO: Doctor_ID appears in multiple tables, current solution is very dirty.
     var columns = [
     'Doctor.Doctor_ID',
     'Doctor.Doctor_Name'
     ];
     condition = jsonToAnd(condition);
     // use Doctor.Doctor_ID to avoid ambiguous, and then rename it to Doctor_ID to satisfy API requirement.
     var q = connect.query('SELECT ?? FROM ?? WHERE ' + condition, [columns, table], function (err, rows) {
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
     console.log("SQL: " + q.sql);*/
};

function Config(table, condition, dest, callback) {
    condition = jsonToAnd(condition);
    connect.query('UPDATE ?? SET ? WHERE ' + condition, [table, dest], callback);
}

exports.Config_User = function (req, res, callback) {
    var table = 'User';
    var condition = {
        User_ID: req.body.User_ID
    };
    var dest = req.body;
    Config(table, condition, dest, function (err, result) {
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

exports.Del_Doctor = function (req, res) {
    /*var table = [
     'Doctor_Time',
     'Doctor'
     ];
     var condition = {
     'Doctor.Doctor_ID': req.body.Doctor_ID,
     relation: {
     'Doctor_Time.Doctor_ID': 'Doctor.Doctor_ID'
     }
     };
     condition = jsonToAnd(condition);
     connect.query('DELETE FROM ?? WHERE ' + condition, [table], function (err, result) {
     if (err) {
     res.json({
     msg: 1,
     info: err.message
     });
     return;
     }
     res.json({
     msg: 0,
     info: '该医生信息已删除'
     });
     });*/
    // I know someone (lmy) would say this code should use jsonToAnd and other utils provided.
    // But delete from multiple table is different!
    var did = req.body.Doctor_ID;
    connect.query('delete from Doctor_Time where Doctor_ID=' + did, function (err, result) {
        if (!!err) {
            res.json({
                msg: 1,
                info: 'Cannot delete from Doctor_Time, let alone Doctor.'
            });
            return;
        }
        connect.query('delete from Doctor where Doctor_ID=' + did, function (err, result) {
            if (!!err) {
                res.json({
                    msg: 1,
                    info: 'Can delete from Doctor_Time, but cannot from Doctor, wierd.'
                });
                return;
            }
            res.json({
                msg: 0,
                info: 'OK'
            });
        });
    });
};

exports.Get_Old_Pwd_User = function (req, res) {
    var table = 'User';
    var condition = req.body;
    var columns = 'PASSWORD';
    find(table, condition, res, columns);
};

exports.Get_Old_Pwd_Admin = function (req, res) {
    var table = 'Admin';
    var condition = req.body;
    var columns = 'PASSWORD';
    find(table, condition, res, columns);
};


exports.Find_User_By_Condition = function (req, res) {
    var table = 'User';
    var condition = {};
    if (req.body.Area_ID) {
        condition.Area_ID = req.body.Area_ID;
    }
    if (req.body.isChecked) {
        condition.isChecked = req.body.isChecked;
    }
    var columns = [
        'User_ID',
        'UserName',
        'Identity_ID',
        'isChecked'
    ];
    if (req.body.start && req.body.size) {
        var start = req.body.start;
        var size = req.body.size;
        find_range(table, condition, start, size, res, columns);
    }
    else {
        find(table, condition, res, columns);
    }
};

exports.Add_Depart = function (req, res) {
    var table = 'Depart';
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
            info: '添加成功'
        });
    });
};

exports.Del_Depart = function (req, res) {
    var table = 'Depart';
    var condition = req.body;
    condition = jsonToAnd(condition);
    connect.query('DELETE FROM ?? WHERE ' + condition, [table], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (result.affectedRows == 0) {
            res.json({
                msg: 1,
                info: "删除失败"
            });
            return;
        }
        res.json({
            msg: 0,
            info: '删除成功'
        });
    });
};

exports.Del_Hospital = function (req, res) {
    var table = 'Hospital';
    var condition = req.body;
    condition = jsonToAnd(condition);
    connect.query('DELETE FROM ?? WHERE ' + condition, [table], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (result.affectedRows == 0) {
            res.json({
                msg: 1,
                info: "删除失败"
            });
            return;
        }
        res.json({
            msg: 0,
            info: '删除成功'
        });
    });
};

// Update user
exports.Update_User = function (req, res) {
    var table = 'User';
    var condition = {
        User_ID: req.body.User_ID
    };
    /*var dest = {
     PASSWORD: req.body.PASSWORD
     };*/
    var dest = req.body;
    delete dest.User_ID;
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
            msg: 0
        });
    });
};

// Delete a user
// param: token, encrpttime, User_ID (separated by comma)
exports.Del_User = function (req, res) {
    var ids = req.body.User_ID;
    connect.query('delete from User where User_ID in (' + ids + ')', function (err, result) {
        var ret = {}
        if (!!err) {
            ret.msg = 1;
            ret.info = 'Cannot query database. ' + err.message;
        } else {
            if (result.affectedRows == 0) {
                ret.msg = 1;
                ret.info = 'No user are deleted';
            } else {
                ret.msg = 0;
                ret.info = "OK";
            }
        }
        res.json(ret);
    });
};

exports.Add_Doctor_Time = function (req, res) {
    var table = 'Doctor_Time';
    var dest = tupleToString(req.body.Duty_Time.split(','), req.body.Doctor_ID);
    connect.query('INSERT INTO ?? (??, ??) VALUES ' + dest, [table, 'Duty_Time', 'Doctor_ID'], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '成功'
        });
    });
};

exports.Find_Doctor_Time = function (req, res) {
    find('Doctor_Time', req.body, res);
};

exports.Del_Doctor_Time = function (req, res) {
    var table = 'Doctor_Time';
    var condition_doctor = {
        Doctor_ID: req.body.Doctor_ID
    };
    condition_doctor = jsonToAnd(condition_doctor);
    var condition_duty = ' (' + req.body.Duty_Time + ') ';
    connect.query('DELETE FROM ?? WHERE ' + condition_doctor + ' AND ?? IN ' + condition_duty,
        [table, 'Duty_Time'], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            res.json({
                msg: 0,
                info: '删除成功'
            });
        });
}

exports.Update_Doctor_Time = function (req, res) {
    var did = req.body.Doctor_ID;
    var times = req.body.Duty_Time.split(',');
    connect.query('delete from Doctor_Time where Doctor_ID=' + did, function (err, result) {
        if (!!err) {
            res.json({
                msg: 1,
                info: 'Cannot delete, let alone update.'
            });
            return;
        }
        connect.query('insert into Doctor_Time (Doctor_ID, Duty_Time) values ' + times.map(function (e) {
            return '(' + did + ',' + e + ')';
        }).join(','), function (err, result) {
            if (!!err) {
                res.json({
                    msg: 1,
                    info: 'Cannot insert new values.'
                });
                return;
            }
            res.json({
                msg: 0,
                info: 'OK'
            });
        });
    });
};

// IN: User_ID, OUT: msg, Amount
exports.Get_Cash = function (req, res) {
    connect.query('Select Amount from User where User_ID=' + req.body.User_ID, function (err, rows) {
        if (!!err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length < 1) {
            res.json({
                msg: 1,
                info: 'No such user'
            });
            return;
        }
        res.json({
            msg: 0,
            amount: rows[0].Amount
        });
    });
};

// IN: Admin_ID, OUT: msg, PASSWORD
exports.Get_PASSWORD_Admin = function (req, res) {
    connect.query('Select PASSWORD from Admin where Admin_ID=' + req.body.Admin_ID, function (err, rows) {
        if (!!err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length < 1) {
            res.json({
                msg: 1,
                info: 'No such admin'
            });
            return;
        }
        res.json({
            msg: 0,
            PASSWORD: rows[0].PASSWORD
        });
    });
};

// IN: User_ID, OUT: msg, PASSWORD
exports.Get_PASSWORD_User = function (req, res) {
    connect.query('Select PASSWORD from User where User_ID=' + req.body.User_ID, function (err, rows) {
        if (!!err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        if (rows.length < 1) {
            res.json({
                msg: 1,
                info: 'No such user'
            });
            return;
        }
        res.json({
            msg: 0,
            PASSWORD: rows[0].PASSWORD
        });
    });
};
