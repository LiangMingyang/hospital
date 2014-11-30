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
        ///执行插入
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
    var condition = req.body;
    var start = condition.start;
    var size = condition.size;
    var startDate = condition.startDate;
    var endDate = condition.endDate;
    var dateString = 'History_Reservation_Time';
    var columns = [
        'History_Reservation_ID',
        'History_Reservation_Time',
        'History_Operation_Time',
        'Doctor_Name'
    ];
    condition = {
        History_Reservation_ID: req.body.Reservation_ID,
        'History_Reservation.Doctor_ID': 'Doctor.Doctor_ID'
    };
    condition = jsonToAnd(condition);
    connect.query('SELECT ?? FROM ?? WHERE ' + condition + ' AND ?? >= ? AND ?? <= ? LIMIT ??,??', [
        columns, table, dateString, startDate, dateString, endDate, start, size
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
    var query = connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, rows) {
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
    //TODO:increase doctor.limit?
};

exports.del_Reservation = function (req, res) {
    var table = 'Reservation';
    var condition = req.body;
    condition = jsonToAnd(condition);
    connect.query('DELETE FROM ?? WHERE ' + condition, table, function (err, rows) {
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
            info: rows.Reservation_Payed // == 0 ? '已支付' : '未支付'
        });
    });
};