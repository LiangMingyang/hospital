/**
 * Created by 明阳 on 2014/11/27.
 */
var crypto = require('crypto');
var hash = crypto.createHash('sha1');
var secret = global.secret_key;
var strftime = require("strftime");
var connect = global.connect;
exports.check = function(req,res,next) {
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
    delete req.body.encrypttime
    next();
}

var findUserByName = function (name,callback) {
    var table = 'user';
    var condition = {
        'username':name
    }
    connect.query('SELECT * FROM ?? WHERE ?',[table,condition],function(err,rows) {
        if(err) {
            if(callback)callback(err,rows);
            return ;
        }
        if(callback)callback(null,rows);
    })
}

exports.register = function(req,res) {
    findUserByName(req.body.username,function(err,rows) {
        if(err) {
            res.json({
                msg:1,
                info:err.message
            })
            return ;
        }
        if(rows.length>0) {
            res.json({
                msg:1,
                info:'用户已经存在了'
            })
            return;
        }
        ///执行插入
        var table = 'user';
        var condition = req.body;
        connect.query('INSERT INTO ?? SET ?',[table,condition],function(err,result) {
            if(err) {
                res.json({
                    msg:1,
                    info:err.message
                })
                return ;
            }
            findUserByName(req.body.username, function (err,rows) {
                if(err) {
                    res.json({
                        msg:1,
                        info:err.message
                    })
                    return;
                }
                if(rows.length==0) {
                    res.json({
                        msg:1,
                        info:'刚刚插入的数据竟然不见了真是奇怪……'
                    })
                    return;
                }
                var json = rows[0];
                json.msg = 0;
                res.json(json);
            })
        })
    })
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
}

exports.findHospital = function (req,res) {
    
}