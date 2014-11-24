var express = require('express');
var router = express.Router();
var db = require('../my_modules/database/router');

/* GET home page. */

module.exports = function(app) {
  app.use('/',db);
}

