create database Agent;
use Agent;
create table Property
(
  id serial primary key,
  address varchar(40),
  rooms int,
  rent decimal(6,2)
);

create table users
(
  userID serial primary key,
  username varchar(30),
  password char(40),
  reg_date datetime
);
