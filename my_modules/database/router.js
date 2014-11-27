/**
 * Created by 明阳 on 2014/11/24.
 */
var express = require('express');
var router = express.Router();
var db = require('./database');
var dbhelper = require('./dbhelper');

/* GET home page. */
router.get('/', function (req,res) {
    res.render('index');
});

router.post('/register',function(req,res) {
    res.json(req.body);
    //dbhelper.register(req,res);
})

router.post('/find_hostpital',function(req,res) {
    res.json(req.body);
})

module.exports = router;

