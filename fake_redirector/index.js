var http    = require('http');
var express = require('express');
var request = require('request');
var cheerio = require('cheerio');

var app = express();

app.set('views', './views');
app.set('view engine', 'hbs');
app.engine('hbs', require('hbs').__express);

app.enable('trust proxy');

app.get('*', function(req, response) {
    var ip = req.headers['x-forwarded-for'] || req.headers['x-real-ip'];
    var isp = null, region = null, city = null;
    request('http://ip.taobao.com/service/getIpInfo.php?ip='+ip, function(err, res, body) {
        if (!err && res.statusCode==200) {
            var data = JSON.parse(body);
            console.log(data);
            if (data.code==0) {
                isp = data.data.isp;
                region = data.data.region;
                city = data.data.city;
            }
        }
        response.render('index', {url: req.url, ip: ip, isp: isp, region: region, city: city});
    });
});

http.createServer(app).listen(12000, '127.0.0.1');
