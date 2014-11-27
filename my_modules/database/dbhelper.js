/**
 * Created by 明阳 on 2014/11/27.
 */
var crypto = require('crypto');
var hash = crypto.createHash('sha1');
var secret = global.secret_key;
var strftime = require("strftime");
var connect = global.connect;
exports.auth = function(req,res,next) {
    var sendtime = new Date(req.body.encrypttime);
    var token    = req.body.token;
    if(!sendtime || !token) {
        res.json({
            msg : 1,
            info: "格式不合法"
        })
        return ;
    }
    var now = new Date();
    var delta = Math.abs(now-sendtime);
    if(delta > 60*1000) {
        res.json({
            msg : 2,
            info:"超时"
        })
        return;
    }


    if(hash.update(secret+'$'+strftime("%F %T",sendtime)).digest('hex') != token) {
        res.json({
            msg : 3,
            info:"token不正确"
        })
        return;
    }
    delete res.body.token;
    delete res
    next();
}

exports.register = function(req,res) {

}