drop database if exists muna;
create database muna;

create table if not exists history_item(
    id integer primary key generated always as identity,
    value varchar (100) not null,
    time timestamp not null
);