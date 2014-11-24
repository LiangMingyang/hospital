var express = require('express');
var router = express.Router();
var db = require('../my_modules/database');

/* GET home page. */
router.get('/', function(req, res) {
  res.render('index');
});

module.exports = router;


module.exports = function(app) {
  app.use('/',db);
}

