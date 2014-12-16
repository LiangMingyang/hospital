var express = require('express');
var router = express.Router();
var qn = require('../qiniu_adapter/router');
var db = require('../my_modules/database/router');

/* GET home page. */

module.exports = function (app) {
    app.use('/data', qn);
    app.use('/', db);
};

