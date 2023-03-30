/* db 생성 전 my.ini utf-8 설정 */
create database store DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

use store;

create table user (
    idx int(4) not null auto_increment,
    id varchar(8) not null,
    pw varchar(150) not null,
    primary key (idx)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

create table store (
    idx int(4) not null auto_increment,
    name varchar(20) not null,
    type varchar(20) not null,
    menu varchar(150) not null,
    location varchar(30) not null,
    map_x varchar(50) not null,
    map_y varchar(50) not null,
    primary key (idx)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

create table menu (
    store_idx int(4) not null,
    idx int(4) not null auto_increment,
    name varchar(20) not null,
    price varchar(20) not null,
    image varchar(150) not null,
    primary key (idx),
    foreign key (store_idx) references store (idx) on delete cascade on update cascade
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

create table review (
    store_idx int(4) not null,
    user_idx int(4) not null,
    idx int(4) not null auto_increment,
    rating decimal(4,1) not null,
    review varchar(150) not null,
    date timestamp not null default current_timestamp,
    primary key (idx),
    foreign key (store_idx) references store (idx) on delete cascade on update cascade,
    foreign key (user_idx) references user (idx) on delete cascade on update cascade
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;

create table univ_menu (
    date date not null,
    menu1 varchar(50),
    menu2 varchar(50),
    primary key (date)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;