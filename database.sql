create table user(
	  id int not null auto_increment primary key,
    login varchar(64) not null unique,
    password char(128) not null,
    mail varchar(100) not null unique,
    status int not null,
    registration datetime not null,
    lastlogin datetime default null,
    lastlastlogin datetime default null,
    activation datetime,
    statuschange datetime,
    avatar boolean default false,
    foreign key (status) references status(status_level)
);

create table status(
		id int not null auto_increment primary key,
    level int not null unique,
    label varchar(45) not null unique
);

create table activation(
		user_id int not null unique primary key,
    code varchar(128),
    foreign key(user_id) references user(id)
);

CREATE TABLE contact_message(
		id int not null auto_increment primary key,
    subject varchar(64) not null,
    mail varchar(64) not null,
    text text not null,
    date datetime,
    answer boolean default false,
    user_id int default null,
    parentid int default null,
    foreign key(user_id) references user(id)
);
