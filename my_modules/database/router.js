/**
 * Created by 明阳 on 2014/11/24.
 */
var express = require('express');
var router = express.Router();

/* GET home page. */
router.get('/', function (req,res) {
    res.render('index');
});

module.exports = router;

