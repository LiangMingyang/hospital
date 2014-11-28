/**
 * Created by 明阳 on 2014/11/24.
 */
module.exports = {
    database : {
        host: '127.0.0.1',
        port: '3306',
        user: 'test',//默认使用test账户
        password: '',//默认没有密码
        database: 'Hospital_Reservation_DB' //数据库的名字
    },
    scret_key:"songzimingdb"
};

/**
 * 首先登录root账户，创建一个test账户，密码为空
 * insert into mysql.user(Host,User) values("localhost","test");
 * 然后将Hospital_Reservation_DB的所有权限添加给test账户
 * grant all privileges on Hospital_Reservation_DB.* to test@localhost;
 * 最后刷新权限表
 * flush privileges;
 * 以后就可以用test账户访问数据库，测试时不再需要频繁更改config.js文件
 */
