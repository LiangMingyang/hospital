var express = require('express');
var router = express.Router();
var db = require('./database');
var dbhelper = require('./dbhelper');

/* GET home page. */
router.get('/', function (req, res) {
    res.render('index');
});

router.use(dbhelper.check);

router.post('/register', dbhelper.register);

router.post('/find_hostpital', dbhelper.findHospital);

router.post('/find_doctor', dbhelper.findDoctor);

router.post('/find_user', dbhelper.findUser);

router.post('/Update_Individual_Info', dbhelper.UpdateIndividualInfo);

router.post('/Check_Reservation_Simple', dbhelper.Check_Reservation_Simple);

router.post('/Check_Reservation_Detail', dbhelper.Check_Reservation_Detail);

router.post('/Check_History_Reservation_Simple', dbhelper.Check_History_Reservation_Simple);

router.post('/Check_History_Reservation_Detail', dbhelper.Check_History_Reservation_Detail);

router.post('/Reservation', dbhelper.Reservation);

router.post('/del_Reservation', dbhelper.del_Reservation);

router.post('/Check_PayState', dbhelper.Check_PayState);

//router.post('/In_Cash', dbhelper.In_Cash);

router.post('/Pay_Reservation', dbhelper.Pay_Reservation);

//router.post('/Check_Register', dbhelper.Check_Register);

router.post('/Get_Reservation_Info', dbhelper.Get_Reservation_Info);

router.post('/Search_By_Identity', dbhelper.Search_By_Identity);

//router.post('/Cancel_Reservation', dbhelper.Cancel_Reservation);

router.post('/get_UserInfo_byID', dbhelper.get_UserInfo_byID);

//router.post('/Search_User', dbhelper.Search_User);

router.post('/Set_CreditRank_user_ID', dbhelper.Set_CreditRank_user_ID);

router.post('/Create_Hospital', dbhelper.Create_Hospital);

router.post('/Get_HospitalInfo_simple', dbhelper.Get_HospitalInfo_simple);

module.exports = router;

