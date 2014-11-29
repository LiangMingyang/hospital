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

var findUserByName = function (name, callback) {
    var table = 'user';
    var condition = {
        'username': name
    };
    connect.query('SELECT * FROM ?? WHERE ?', [table, condition], function (err, rows) {
        if (err) {
            if (callback) {
                callback(err, rows);
            }
            return;
        }
        if (callback) {
            callback(null, rows);
        }
    })
};

exports.register = function (req, res) {
    findUserByName(req.body.username, function (err, rows) {
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
        var table = 'user';
        var condition = req.body;
        connect.query('INSERT INTO ?? SET ?', [table, condition], function (err, result) {
            if (err) {
                res.json({
                    msg: 1,
                    info: err.message
                });
                return;
            }
            findUserByName(req.body.username, function (err, rows) {
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
            })
        })
    });
    //usernameNotUsed(req,res,function(err,req,res) {
    //    if(err) {
    //        res.json({
    //            msg:1,
    //            info:err.message
    //        })
    //        return ;
    //    }
    //    ///执行插入
    //    var table = 'user';
    //    var condition = req.body;
    //    connect.query('INSERT INTO ?? SET ?',[table,condition],function(err,result) {
    //        if(err) {
    //            res.json({
    //                msg:1,
    //                info:err.message
    //            })
    //            return ;
    //        }
    //        res.json({
    //            msg:0,
    //            userid:result
    //        })
    //    })
    //})
};

exports.findUser = function (req, res) {
    var table = 'user';
    var condition = req.body;
    findUserByName(req.body.username, function (err, rows) {
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
        })
    })
};

exports.findHospital = function (req, res) {
    var table = 'hospital';
    var condition = req.body;
    var start = condition.start;
    var end = condition.end;
    delete condition.start;
    delete condition.end;
    connect.query('SELECT * FROM ?? WHERE ? LIMIT ??,??', [table, condition, start, end], function (err, rows) {
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
        })
    })
};

exports.findDoctor = function (req, res) {
    var table = 'doctor';
    var condition = req.body;
    var start = condition.start;
    var end = condition.end;
    delete condition.start;
    delete condition.end;
    connect.query('SELECT * FROM ?? WHERE ? LIMIT ??,??', [table, condition, start, end], function (err, rows) {
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
        })
    })
};

exports.UpdateIndividualInfo = function (req, res) {
    var table = 'user';
    var condition = {
        User_ID: req.body.User_ID
    };
    var dest = req.body.Dest;
    connect.query('UPDATE ?? SET ? WHERE ?', [table, dest, condition], function (err, result) {
        if (err) {
            res.json({
                msg: 1,
                info: err.message
            });
            return;
        }
        res.json({
            msg: 0,
            info: '成功修改'
        })
    })
};

exports.Check_Reservation_Simple = function (req, res) {
    var table = [
        'reservation',
        'user'
    ];
    var condition = {
        User_ID: req.body.User_ID
    };
    var columns = [
        'Reservation_ID',
        'Reservation_Time',
        'Operation_Time',
        'Doctor_Name'
    ];
    connect.query('SELECT ?? FROM ?? WHERE ?', [columns, table, condition], function (err, rows) {
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
        })
    })
};

exports.Check_Reservation_Detail = function (req, res) {
    var table = [
        'reservation',
        'doctor'
        ];
    var condition = {
        Reservation_ID: req.body.Reservation_ID
    };
    connect.query('SELECT * FROM ?? WHERE ?', [table, condition], function (err, rows) {
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
        })
    })
};
