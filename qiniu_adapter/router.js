var express = require('express');
var router = express.Router();
var qn = require('./index');

router.post('/getToken', getToken);
router.post('/upload', uploadData);
