create table News
(
    ID      int primary key auto_increment,
    time    datetime not null,
    type_ID smallint not null
);
create table News_types
(
    ID   smallint primary key auto_increment,
    type varchar(50) not null unique
);
alter table News
    add foreign key (type_ID) references News_types (ID);
create table Reports
(
    ID               int auto_increment primary key,
    visits_amount    int not null,
    patient_pleasure smallint check (patient_pleasure between 1 and 5)
);
create table Reports_categories
(
    report_ID   int,
    category_ID smallint,
    primary key (report_ID, category_ID)
);
create table Categories
(
    ID       smallint primary key auto_increment,
    category varchar(50) not null unique
);
create table Procedures
(
    ID          int primary key auto_increment,
    name        varchar(255)   not null unique,
    description text    not null,
    price       decimal(10, 2) not null,
    category_ID smallint       not null
);
alter table Reports_categories
    add foreign key (report_ID) references Reports (ID);
alter table Reports_categories
    add foreign key (category_ID) references Categories (ID);
alter table Procedures
    add foreign key (category_ID) references Categories (ID);
create table Roles
(
    ID   smallint primary key auto_increment,
    role varchar(50) not null unique
);
create table Users
(
    ID         int auto_increment primary key,
    first_name varchar(255) not null,
    last_name  varchar(255) not null,
    email      varchar(255) not null unique,
    password   varchar(255) not null,
    push       bool         not null,
    role_ID    smallint     not null
);
create table Cardiologist_visits
(
    ID                  int primary key auto_increment,
    time                datetime not null,
    meeting_description text     not null,
    recommendation      text,
    doctor_ID           int      not null,
    patient_ID          int      not null
);
create table Users_history
(
    ID          int auto_increment primary key,
    information json     not null,
    change_time timestamp not null,
    user_ID     int      not null
);
create table Chats
(
    patient_ID  int,
    employee_ID int,
    primary key (patient_ID, employee_ID)
);
create table Messages
(
    ID           int primary key auto_increment,
    property     text not null,
    sender_ID    int  not null,
    recipient_ID int  not null
);
create table Documents
(
    ID         int primary key auto_increment,
    name       varchar(255) not null,
    time       datetime     not null,
    type_ID    smallint     not null,
    patient_ID int          not null
);
create table Document_types
(
    ID   smallint primary key auto_increment,
    type varchar(50) not null unique
);
create table Employees
(
    ID                        int primary key,
    biography                 text,
    qualification             varchar(255) not null,
    photo                     longblob     not null,
    medical_specialisation_ID smallint
);
create table Medical_specialisations
(
    ID                     smallint primary key auto_increment,
    medical_specialisation varchar(50) not null unique
);
create table Visits
(
    ID         int primary key auto_increment,
    time       datetime not null,
    patient_ID int      not null,
    doctor_ID  int      not null
);
create table Feedbacks
(
    ID       int primary key auto_increment,
    property varchar(1000),
    mark     smallint   not null check (mark between 1 and 5),
    time     datetime   not null,
    visit_ID int unique not null
);
create table Surveys
(
    ID                     int primary key auto_increment,
    treatment_satisfaction smallint not null check (treatment_satisfaction between 1 and 5),
    suggestions            varchar(255),
    patient_ID             int      not null
);
alter table Users
    add foreign key (role_ID) references Roles (ID);
alter table Cardiologist_visits
    add foreign key (doctor_ID) references Employees (ID);
alter table Cardiologist_visits
    add foreign key (patient_ID) references Users (ID);
alter table Users_history
    add foreign key (user_ID) references Users (ID);
alter table Chats
    add foreign key (patient_ID) references Users (ID);
alter table Chats
    add foreign key (employee_ID) references Employees (ID);
alter table Messages
    add foreign key (sender_ID) references Users (ID);
alter table Messages
    add foreign key (recipient_ID) references Users (ID);
alter table Documents
    add foreign key (type_ID) references Document_types (ID);
alter table Documents
    add foreign key (patient_ID) references Users (ID);
alter table Employees
    add foreign key (ID) references Users (ID);
alter table Employees
    add foreign key (medical_specialisation_ID) references Medical_specialisations (ID);
alter table Visits
    add foreign key (patient_ID) references Users (ID);
alter table Visits
    add foreign key (doctor_ID) references Employees (ID);
alter table Feedbacks
    add foreign key (visit_ID) references Visits (ID);
alter table Surveys
    add foreign key (patient_ID) references Users (ID);

delimiter $$$
create trigger is_user_employee1
    before insert
    on Employees
    for each row
begin
    if (select count(ID) from Users where new.ID = Users.ID and role_ID != 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is a patient';
    end if;
end;
$$$
delimiter $$$
create trigger is_user_employee2
    before update
    on Employees
    for each row
begin
    if (select count(ID) from Users where new.ID = Users.ID and role_ID != 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is a patient';
    end if;
end;
$$$


delimiter $$$
create trigger is_user_patient_chats1
    before insert
    on Chats
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$
delimiter $$$
create trigger is_user_patient_chats2
    before update
    on Chats
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$

delimiter $$$
create trigger is_user_patient_cardiologist_visits1
    before insert
    on Cardiologist_visits
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$
delimiter $$$
create trigger is_user_patient_cardiologist_visits2
    before update
    on Cardiologist_visits
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$

delimiter $$$
create trigger is_user_patient_documents1
    before insert
    on Documents
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$
delimiter $$$
create trigger is_user_patient_documents2
    before update
    on Documents
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$

delimiter $$$
create trigger is_user_patient_surveys1
    before insert
    on Surveys
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$
delimiter $$$
create trigger is_user_patient_surveys2
    before update
    on Surveys
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$

delimiter $$$
create trigger is_user_patient_visits1
    before insert
    on Visits
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$
delimiter $$$
create trigger is_user_patient_visits2
    before update
    on Visits
    for each row
begin
    if (select count(ID) from Users where ID = new.patient_ID and role_ID = 1) = 0 then
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'this user is not a patient';
    end if;
end $$$

delimiter $$$
create trigger add_history
    after update
    on Users
    for each row
begin
    if old.first_name != new.first_name or old.last_name != new.last_name or old.email != new.email or
       old.password != new.password or old.push != new.push or old.role_ID != new.role_ID then
        insert into Users_history (information, change_time, user_ID)
        values (json_object('first_name', old.first_name, 'last_name', old.last_name, 'email', old.email, 'password',
                            old.password, 'push', old.push, 'role_ID', old.role_ID), current_timestamp(), new.ID);
    end if;
end $$$

insert into Categories (category)
values ('Diagnostic'),
       ('Therapeutic'),
       ('Surgical'),
       ('Minimally'),
       ('Emergency'),
       ('Obstetric and Gynecological'),
       ('Preventive'),
       ('Rehabilitative'),
       ('Palliative'),
       ('Dental'),
       ('Cosmetic'),
       ('Ophthalmologic');
insert into Document_types (type)
values ('test result'),
       ('prescription'),
       ('medical certificate');
insert into Roles (role)
values ('patient'),
       ('admin'),
       ('doctor'),
       ('medical assistant');
insert into Medical_specialisations (medical_specialisation)
values ('Allergy and Immunology'),
       ('Anesthesiology'),
       ('Cardiology'),
       ('Dermatology'),
       ('Emergency Medicine'),
       ('Endocrinology'),
       ('Gastroenterology'),
       ('Geriatrics'),
       ('Hematology'),
       ('Infectious Disease'),
       ('Internal Medicine'),
       ('Nephrology'),
       ('Neurology'),
       ('Obstetrics and Gynecology (OB/GYN)'),
       ('Oncology'),
       ('Ophthalmology'),
       ('Orthopedics'),
       ('Otolaryngology (ENT)'),
       ('Pediatrics'),
       ('Plastic Surgery'),
       ('Psychiatry'),
       ('Pulmonology'),
       ('Radiology'),
       ('Rheumatology'),
       ('Surgery'),
       ('Urology');
insert into News_types (type)
values ('information about changes in opening hours'),
       ('days off'),
       ('special events');