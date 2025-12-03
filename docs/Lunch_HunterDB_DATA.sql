INSERT INTO t_user
 (user_id,user_l_name,user_f_name,user_l_kana,user_f_kana,user_account,password,usertype_id)
VALUES
 ('test','テスト','ユーザ','テスト','ユーザ','テスト','1234','1')
,('admin','管理者','　','カンリシャ','　','管理者','5678','9')
;

INSERT INTO t_usertype
 (usertype_id,usertype)
VALUES
 ('1','社員')
,('9','管理者')
;

INSERT INTO t_genre
 (genre_id,genre)
VALUES
 ('1','うどん')
,('2','ラーメン')
,('3','その他麺類')
,('4','定食')
,('5','カレー')
,('6','ファストフード')
,('7','カフェ')
,('8','和食')
,('9','洋食')
,('10','焼肉')
,('11','中華')
,('12','その他')
;
