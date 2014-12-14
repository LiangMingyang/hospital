var express = require('express');
var router = express.Router();
var db = require('./database');
var dbhelper = require('./dbhelper');
var fs = require('fs');
var markdown = require('markdown').markdown;

/* GET home page. */
router.get('/', function (req, res) {
    //res.render('index');
    fs.readFile('doc/接口反馈by wjfwzzc.md',function(err,data) {
        if(err) {
            res.render('index',{data:err.message});
            return ;
        }
        res.render('index',{data:markdown.toHTML(data.toString())});
    })
});

router.use(dbhelper.check);

router.post('/Register', dbhelper.Register);

router.post('/Find_Hospital', dbhelper.Find_Hospital);

router.post('/Find_Doctor', dbhelper.Find_Doctor);

router.post('/Update_Individual_Info', dbhelper.Update_Individual_Info);

router.post('/Check_Reservation_Simple', dbhelper.Check_Reservation_Simple);

router.post('/Check_Reservation_Detail', dbhelper.Check_Reservation_Detail);

router.post('/Check_History_Reservation_Simple', dbhelper.Check_History_Reservation_Simple);

router.post('/Check_History_Reservation_Detail', dbhelper.Check_History_Reservation_Detail);

router.post('/Reservation', dbhelper.Reservation);

router.post('/del_Reservation', dbhelper.del_Reservation);

router.post('/Check_PayState', dbhelper.Check_PayState);

router.post('/Check_Cash', dbhelper.Check_Cash);

router.post('/In_Cash', dbhelper.In_Cash);

router.post('/Pay_Reservation', dbhelper.Pay_Reservation);

router.post('/Check_Register', dbhelper.Check_Register);

router.post('/Get_Reservation_Info', dbhelper.Get_Reservation_Info);

router.post('/Search_By_Identity', dbhelper.Search_By_Identity);

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

router.post('/Find_User_By_Identity_ID', dbhelper.Find_User_By_Identity_ID);

router.post('/Find_Admin_By_Admin_Name', dbhelper.Find_Admin_By_Admin_Name);

router.post('/Get_Province_info', dbhelper.Get_Province_info);

router.post('/Get_Area_Info_By_Province_ID', dbhelper.Get_Area_Info_By_Province_ID);

router.post('/Find_Hospital_By_Condition', dbhelper.Find_Hospital_By_Condition);

router.post('/Get_History_Reservation_For_Flexigrid', dbhelper.Get_History_Reservation_For_Flexigrid);

router.post('/Get_Hospital_Number_By_Condition', dbhelper.Get_Hospital_Number_By_Condition);

router.post('/Find_Doctor_By_Condition', dbhelper.Find_Doctor_By_Condition);

router.post('/Check_Admin_Repeat', dbhelper.Check_Admin_Repeat);

//router.post('/Find_Doctor_State', dbhelper.Find_Doctor_State);

router.post('/Find_Doctor_By_Condition_Free', dbhelper.Find_Doctor_By_Condition_Free);


module.exports = router;
