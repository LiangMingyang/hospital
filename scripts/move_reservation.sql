-- move obsolote reservation record into history_reservation table

-- to be safe, do all things in transaction
start transaction;
insert into History_Reservation (
    History_Reservation_ID,
    User_ID,
    Doctor_ID,
    History_Reservation_Time,
    History_Reservation_Symptom,
    Duty_Time,
    History_Reservation_Paied,
    History_Pay_Time,
    History_Operation_Time
) select
    Reservation_ID,
    User_ID,
    Doctor_ID,
    Reservation_Time,
    Reservation_Symptom,
    Duty_Time,
    Reservation_Payed,
    Reservation_PayTime,
    Operation_Time
from Reservation where Operation_Time > (now() - interval 1 day);
delete from Reservation where Operation_Time > (now() - interval 1 day);
commit;

