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

router.use(dbhelper.check);

router.post('/register',dbhelper.register)

router.post('/find_hostpital',dbhelper.findHospital)

router.post('/find_doctor',dbhelper.findDoctor)

router.post('/find_user',dbhelper.findUser)

router.post('/Update_Individual_Info',dbhelper.UpdateIndividualInfo)

router.post('/Check_Reservation_Simple',dbhelper.Check_Reservation_Simple)

router.post('/Check_Reservation_Detail',dbhelper.Check_Reservation_Detail)

module.exports = router;

