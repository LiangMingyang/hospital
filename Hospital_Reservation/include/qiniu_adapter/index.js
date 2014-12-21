var url   = require('url');
var qiniu = require('qiniu');
var config = require('../config.js');

// Setup qiniu environment
qiniu.conf.ACCESS_KEY = config.qiniu.access_key;
qiniu.conf.SECRET_KEY = config.qiniu.secret_key;

// util functions
function getUploadToken(bucketname) {
    var putPolicy = new qiniu.rs.PutPolicy(bucketname);
    return putPolicy.token();
}

function uploadFromBuffer(body, key, uptoken, cb) {
    var extra = new qiniu.io.PutExtra();
    qiniu.io.put(uptoken, key, body, extra, function(err, ret) {
        if (!!err) {
            console.log('Cannot upload buffer data ' + err);
            cb(err);
        } else {
            console.log('Upload succeeded');
            cb(null);
        }
    });
}

exports.getToken = function(req, res) {
    var parts = url.parse(req.url, true);
    var func = parts.query.callbackparam;
    res.end(func + "({uptoken: '" + getUploadToken('hospital') + "'});");
};

exports.uploadData = function(req, res) {
    var key = req.body['key'] || null;
    var val = req.files['val'].buffer || null;
    if (!!key || !!val) {
        uptoken = getUploadToken(config.qiniu.bucket);
        uploadFromBuffer(data, identifier, uptoken, function(err) {
            if (!!err) {
                res.end('upload error');
            } else {
                res.end('upload ok');
            }
        });
    } else {
        res.end('param error');
    }
};
