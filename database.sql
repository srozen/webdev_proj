CREATE TABLE user(
	  id int not null auto_increment primary key,
    login varchar(64) not null unique,
    password char(128) not null,
    mail varchar(100) not null unique,
    register datetime not null,
    lastlogin datetime default null,
    currentlogin datetime default null,
    activation datetime,
    avatar boolean default false,
		question varchar(128) default null,
		answer char(128) default null,
		secret boolean default false
);

CREATE TABLE user_status(
		user_id int not null,
		status_id int not null,
		date datetime not null,
		foreign key(user_id) references user(id),
		foreign key(status_id) references status(id)
);

CREATE TABLE status(
		id int not null primary key,
		level int not null unique,
		label varchar(45) not null unique,
);


CREATE TABLE activation(
		user_id int not null unique primary key,
    code varchar(128),
		recovery boolean default false,
    foreign key(user_id) references user(id)
);

CREATE TABLE contact_message(
		id int not null auto_increment primary key,
    subject varchar(64) not null,
    mail varchar(64) not null,
    message text not null,
    date datetime not null,
    answer boolean default false,
    user_id int default null,
    parentid int default null,
    foreign key(user_id) references user(id)
);

-----------------
-- WIKI TABLES --
-----------------

CREATE TABLE subject(
		id int not null auto_increment primary key,
		author_id int not null,
		title varchar(100) not null,
		description mediumtext not null,
		creation datetime not null,
		last_modification datetime default null,
		moderator int default null,
		visibility_author tinyint not null default 0,
		visibility_modo tinyint default null,
		visibility_admin tinyint default null,
		foreign key(author_id) references user(id)
);

CREATE TABLE page(
		id int not null auto_increment primary key,
		subject_id int not null,
		keyword varchar(50) default null,
		content mediumtext,
		creation datetime not null,
		last_modification datetime default null,
		foreign key(subject_id) references subject(id)
);

-----------------
-- SQL QUERIES --
-----------------

-- select * from user;
-- select * from activation;
-- select * from contact_message;
-- select * from user_status;
-- select * from status;

-- select * from user_status where user_id =
-- select * from user where id = (select user_id from user_status where status_id = x);
-- select label from status where status_id = (select status_id from user_status where user_id = x);

---------------------
-- STATUS CREATION --
---------------------


-- insert into status(id, level, label) values (1, 0, admin);
-- insert into status(id, level, label) values (2, 10, moderator);
-- insert into status(id, level, label) values (3, 20, normal);
-- insert into status(id, level, label) values (4, 30, activating);
-- insert into status(id, level, label) values (5, 40, reactivating);
-- insert into status(id, level, label) values (6, 50, lostpassword);
-- insert into status(id, level, label) values (7, 60, frozen);
-- insert into status(id, level, label) values (8, 70, unregistered);
-- insert into status(id, level, label) values (9, 80, banned);
