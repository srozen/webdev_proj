CREATE TABLE user(
	  id int not null auto_increment primary key,
    login varchar(64) not null unique,
    password char(128) not null,
    mail varchar(100) not null unique,
    class varchar(64) not null,
		subclass varchar(64) not null,
    registration datetime not null,
    lastlogin datetime default null,
    currentlogin datetime default null,
    activation datetime,
    statuschange datetime,
    avatar boolean default false,
		question varchar(128) default null,
		answer char(128) default null,
		questionset boolean default false
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
-- SQL QUERIES --
-----------------

-- select * from user;
-- select * from activation;
-- select * from contact_message;
