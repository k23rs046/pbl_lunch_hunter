-- Project Name : グルメ情報Webシステム
-- Date/Time    : 2025/12/01
-- RDBMS Type   : MySQL

-- 口コミ
create table t_review(
    review_id SERIAL not null comment '口コミID'
    , eval_pint INT not null comment '評価点'
    , review_comment VARCHAR(250) comment 'コメント'
    , rst_id BIGINT not null comment '書き込まれた店舗'
    , user_id CHAR(16) not null comment '登録ユーザID'
    , photo1 BLOB comment '写真１'
    , photo2 BLOB comment '写真２'
    , photo3 BLOB comment '写真３'
    , rev_state BOOLEAN not null comment'表示状態'
    , constraint t_review_pkc primary key (review_id)
) comment '口コミ';
-- 店舗情報
create table t_rstinfo(
    rst_id SERIAL not null comment '店舗ID'
    , rst_name VARCHAR(64) not null comment''
    , rst_address VARCHAR(256) not null comment ''
    , start_time TIME not null comment ''
    , end_time TIME not null comment ''
    , tel_num VARCHAR(32) not null comment ''
    , rst_holiday int 
    ,
    ,
    ,
) comment '店舗情報';
-- ユーザ