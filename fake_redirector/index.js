var http    = require('http');
var express = require('express');
var request = require('request');
var cheerio = require('cheerio');

var app = express();

app.set('views', './views');
app.set('view engine', 'hbs');
app.engine('hbs', require('hbs').__express);

app.enable('trust proxy');

var ip2geo = ['北京市', '天津市', '上海市', '重庆市',
'河北省', '河南省', '云南省', '辽宁省', '黑龙江省', '湖南省', '安徽省', '山东省',
'新疆维吾尔族自治区', '江苏省', '浙江省', '江西省', '湖北省', '广西壮族自治区', '甘肃省',
'山西省', '内蒙古自治区', '陕西省', '吉林省', '福建省', '贵州省', '广东省', '青海省',
'西藏自治区', '四川省', '宁夏回族自治区', '海南省', '台湾', '香港', '澳门'];

app.get('*', function(req, response) {
    var ip = req.headers['x-forwarded-for'] || req.headers['x-real-ip'];
    var isp = null, region = null, city = null, province = 0;
    request('http://ip.taobao.com/service/getIpInfo.php?ip='+ip, function(err, res, body) {
        if (!err && res.statusCode==200) {
            var data = JSON.parse(body);
            console.log(data);
            if (data.code==0) {
                isp = data.data.isp;
                region = data.data.region;
                city = data.data.city;
                for (var i = 0; i < ip2geo.length; ++i) {
                    if (ip2geo[i].substr(0,2)==region.substr(0,2)) {
                        province = i;
                        break;
                    }
                }
            }
        }
        response.render('index', {url: req.url, ip: ip, isp: isp, region: region, city: city, province: province});
    });
});

http.createServer(app).listen(12000, '127.0.0.1');
