select up.first_name, up.last_name, up.phone, CONCAT('https://t.me/', up.telegram_id) as telegram, u.email, da.name, MAX(ml.lesson_number) AS lesson, up2.spiritual_name from user_profiles as up inner join users as u on u.id = up.user_id inner join district_areas as da on da.id = u.district_area_id inner join meditation_lessons as ml on ml.user_id = u.id inner join users_teachers as ut on ut.user_id = u.id inner join user_profiles as up2 on up2.user_id = ut.teacher_user_id where da.district_id > 7 and da.district_id < 13 group by u.id
