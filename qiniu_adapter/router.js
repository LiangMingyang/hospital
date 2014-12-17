var express = require('express');
var router = express.Router();
var qn = require('./index');

router.post('/getToken', qn.getToken);
router.post('/upload', qn.uploadData);

module.exports = router;
