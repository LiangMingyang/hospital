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
        list.push(key + '=' + data[key]);
    }
    return ' ' + list.join(' and ') + ' ';

};

//console.log(jsonToAnd({
//    'u.username':'lmy',
//    password:'yml'
//}));

var findUserByName = function (name, callback) {
    var table = 'User';
    var condition = {
        'UserName': name
    };
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition, table, function (err, rows) {
        if (err) {
            if (callback) {
                callback(err, rows);
            }
            return;
        }
        if (callback) {
            callback(null, rows);
        }
    });
};

exports.register = function (req, res) {
    findUserByName(req.body.UserName, function (err, rows) {
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
        var table = 'User';
        var condition = req.body;
        connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            findUserByName(req.body.UserName, function (err, rows) {
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
                        info: '刚刚插入的数据竟然不见了真是奇怪……'
                    });
                    return;
                }
                res.json({
                    msg: 0,
                    User_ID: rows[0].User_ID
                });
            });
        });
    });
    //usernameNotUsed(req,res,function(err,req,res) {
    //    if(err) {
    //        res.json({
    //            msg: 1,
    //            info: err.message
    //        })
    //        return;
    //    }
    //    ///执行插入
    //    var table = 'User';
    //    var condition = req.body;
    //    connect.query('INSERT INTO ?? SET ?',[table,condition],function(err,result) {
    //        if(err) {
    //            res.json({
    //                msg: 1,
    //                info: err.message
    //            })
    //            return;
    //        }
    //        res.json({
    //            msg: 0,
    //            userid: result
    //        })
    //    })
    //})
};

exports.findUser = function (req, res) {
    var table = 'User';
    var condition = req.body;
    findUserByName(req.body.UserName, function (err, rows) {
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
        res.json({
            msg: 0,
            content: rows[0]
        });
    });
};

exports.findHospital = function (req, res) {
    var table = 'Hospital';
    var condition = req.body;
    var start = condition.start;
    var size = condition.size;
    delete condition.start;
    delete condition.size;
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition + ' LIMIT ??,??', [table, start, size], function (err, rows) {
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

exports.findDoctor = function (req, res) {
    var table = 'Doctor';
    var condition = req.body;
    var start = condition.start;
    var size = condition.size;
    delete condition.start;
    delete condition.size;
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition + ' LIMIT ??,??', [table, start, size], function (err, rows) {
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

exports.UpdateIndividualInfo = function (req, res) {
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
        'Reservation.User_ID': req.body.User_ID,
        'Reservation.Doctor_ID': 'Doctor.Doctor_ID'
    };
    var columns = [
        'Reservation_ID',
        'Reservation_Time',
        'Operation_Time',
        'Doctor_Name'
    ];
    condition = jsonToAnd(condition);
    var query = connect.query('SELECT ?? FROM ?? WHERE ' + condition, [columns, table], function (err, rows) {
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

exports.Check_Reservation_Detail = function (req, res) {
    var table = [
        'Reservation',
        'Doctor'
    ];
    var condition = {
        Reservation_ID: req.body.Reservation_ID,
        'Reservation.Doctor_ID': 'Doctor.Doctor_ID'
    };
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition, table, function (err, rows) {
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

exports.Check_History_Reservation_Simple = function (req, res) {
    var table = [
        'History_Reservation',
        'Doctor'
    ];
    var start = req.body.start;
    var size = req.body.size;
    var startDate = req.body.startDate;
    var endDate = req.body.endDate;
    var string = 'History_Reservation_Time';
    var condition = {
        History_Reservation_ID: req.body.Reservation_ID,
        'History_Reservation.Doctor_ID': 'Doctor.Doctor_ID'
    };
    var columns = [
        'History_Reservation_ID',
        'History_Reservation_Time',
        'History_Operation_Time',
        'Doctor_Name'
    ];
    condition = jsonToAnd(condition);
    connect.query('SELECT ?? FROM ?? WHERE ' + condition + ' AND ?? >= ? AND ?? <= ? LIMIT ??,??', [
        columns, table, string, startDate, string, endDate, start, size
    ], function (err, rows) {
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
        'Doctor'
    ];
    var condition = {
        History_Reservation_ID: req.body.History_Reservation_ID,
        'History_Reservation.Doctor_ID': 'Doctor.Doctor_ID'
    };
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition, table, function (err, rows) {
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

exports.Reservation = function (req, res) {
    var table = 'Reservation';
    var condition = req.body;
    var query = connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
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
    console.log(query.sql);
    //TODO increase doctor.limit?
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
};

exports.Check_PayState = function (req, res) { //前端表示只要msg不为0，他就不看了，这个字段代表有没有出错
    var table = 'Reservation';
    var condition = req.body;
    var columns = 'Reservation_Payed';
    condition = jsonToAnd(condition);
    connect.query('SELECT ?? FROM ?? WHERE ' + condition, [columns, table], function (err, rows) {
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
    });
};

//TODO In_Cash 这是什么鬼……
//exports.In_Cash = function (req, res) {
//
//};


exports.Pay_Reservation = function (req, res) {
    var table = 'Reservation';
    var condition = req.body;
    var dest = {
        'Reservation_Payed': 0
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

//TODO Check_Register 这又是什么鬼……
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
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition + ' LIMIT ??,??', [table, start, size], function (err, rows) {
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
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition, table, function (err, rows) {
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

//exports.Cancel_Reservation = function (req, res) {
//    var table = 'Reservation';
//    var condition = req.body;
//    condition = jsonToAnd(condition);
//    connect.query('DELETE FROM ?? WHERE ' + condition, table, function (err, result) {
//        if (err) {
//            res.json({
//                msg: 1,
//                info: err.message
//            });
//            return;
//        }
//        res.json({
//            msg: 0,
//            info: '取消预约成功'
//        });
//    });
//};

exports.get_UserInfo_byID = function (req, res) {
    var table = 'User';
    var condition = req.body;
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition, table, function (err, rows) {
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

//exports.Search_User = function (req, res) {
//    var table = 'User';
//    var condition = req.body;
//    condition = jsonToAnd(condition);
//    connect.query('SELECT * FROM ?? WHERE ' + condition, table, function (err, rows) {
//        if (err) {
//            res.json({
//                msg: 1,
//                info: err.message
//            });
//            return;
//        }
//        res.json({
//            msg: 0,
//            content: rows
//        });
//    });
//};

exports.Set_CreditRank_user_ID = function (req, res) {
    var table = 'User';
    var condition = {
        User_ID: req.body.User_ID
    };
    var dest = {
        Credit_Rank: req.body.rank
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
            info: '调整信用等级成功'
        });
    });
};

var findHospitalByName = function (name, callback) {
    var table = 'Hospital';
    var condition = {
        'Hospital_Name': name
    };
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition, table, function (err, rows) {
        if (err) {
            if (callback) {
                callback(err, rows);
            }
            return;
        }
        if (callback) {
            callback(null, rows);
        }
    });
};

exports.Create_Hospital = function (req, res) {
    findHospitalByName(req.body.Hospital_Name, function (err, rows) {
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
        var table = 'Hospital';
        var condition = req.body;
        connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            findHospitalByName(req.body.Hospital_Name, function (err, rows) {
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
                        info: '刚刚插入的数据竟然不见了真是奇怪……'
                    });
                    return;
                }
                res.json({
                    msg: 0,
                    info: rows[0].Hospital_ID
                });
            });
        });
    });
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
    condition = jsonToAnd(condition);
    connect.query('SELECT * FROM ?? WHERE ' + condition, table, function (err, rows) {
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
