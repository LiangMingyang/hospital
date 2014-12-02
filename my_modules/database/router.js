var express = require('express');
var router = express.Router();
var db = require('./database');
var dbhelper = require('./dbhelper');

/* GET home page. */
router.get('/', function (req, res) {
    res.render('index');
});

router.use(dbhelper.check);

router.post('/Register', dbhelper.Register);

router.post('/Find_Hospital', dbhelper.Find_Hospital);

router.post('/Find_Doctor', dbhelper.Find_Doctor);

//router.post('/Find_User', dbhelper.Find_User);

router.post('/Update_Individual_Info', dbhelper.Update_Individual_Info);

router.get('/Check_Reservation_Simple', dbhelper.Check_Reservation_Simple);

router.post('/Check_Reservation_Detail', dbhelper.Check_Reservation_Detail);

router.post('/Check_History_Reservation_Simple', dbhelper.Check_History_Reservation_Simple);

router.post('/Check_History_Reservation_Detail', dbhelper.Check_History_Reservation_Detail);

router.post('/Reservation', dbhelper.Reservation);

router.post('/del_Reservation', dbhelper.del_Reservation);

router.post('/Check_PayState', dbhelper.Check_PayState);

router.post('/Check_Cash', dbhelper.Check_Cash);

router.post('/In_Cash', dbhelper.In_Cash);

router.post('/Pay_Reservation', dbhelper.Pay_Reservation);

//router.post('/Check_Register', dbhelper.Check_Register);

router.post('/Get_Reservation_Info', dbhelper.Get_Reservation_Info);

router.post('/Search_By_Identity', dbhelper.Search_By_Identity);

router.post('/Find_User_By_Identity_ID', dbhelper.Find_User_By_Identity_ID);

router.post('/get_UserInfo_byID', dbhelper.get_UserInfo_byID);

router.post('/Set_CreditRank_user_ID', dbhelper.Set_CreditRank_user_ID);

router.post('/Create_Hospital', dbhelper.Create_Hospital);

router.post('/Get_HospitalInfo_simple', dbhelper.Get_HospitalInfo_simple);

router.post('/Get_HospitalInfo_detail', dbhelper.Get_HospitalInfo_detail);

router.post('/Set_HospitalInfo', dbhelper.Set_HospitalInfo);

router.post('/Create_Depart', dbhelper.Create_Depart);

router.post('/Get_DepartInfo', dbhelper.Get_DepartInfo);

router.post('/Get_DoctorInfo', dbhelper.Get_DoctorInfo);

router.post('/Get_DoctorInfo_detail', dbhelper.Get_DoctorInfo_detail);

router.post('/Add_Doctor', dbhelper.Add_Doctor);

router.post('/Set_DoctorInfo', dbhelper.Set_DoctorInfo);

router.post('/Add_Admin', dbhelper.Add_Admin);

router.post('/Get_AdminInfo', dbhelper.Get_AdminInfo);

router.post('/Get_Privilege', dbhelper.Get_Privilege);

router.post('/Del_Privilege', dbhelper.Del_Privilege);

router.post('/del_Admin', dbhelper.del_Admin);

module.exports = router;
