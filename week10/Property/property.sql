create database Agent;
use Agent;
create table Property
(
  id serial primary key,
  address varchar(40),
  rooms int,
  rent decimal(6,2)
);
