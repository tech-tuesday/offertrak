use bdpa_class;

-- reset database by dropping all tables in this order..
drop table if exists offertrak_job_offer;
drop table if exists offertrak_applicants;
drop table if exists offertrak_contact_types;
drop table if exists offertrak_tax_table;
drop table if exists offertrak_tax_filing_status_types;
drop table if exists offertrak_users;
drop table if exists offertrak_agencies;
drop table if exists offertrak_jobs;
drop table if exists offertrak_job_categories;

create table if not exists offertrak_contact_types (
  contact_type_cd int(11) not null,
  contact_type_cd_desc varchar(255) not null,
  primary key (contact_type_cd)
) Engine=InnoDB Default Charset=utf8;

insert into offertrak_contact_types (
  contact_type_cd,
  contact_type_cd_desc 
) values 
(1,'Email'),
(2,'Phone'),
(3,'Phone Interview'),
(4,'Personal contact'),
(5,'Social Networking'),
(6,'Jobs Website');

create table if not exists offertrak_tax_filing_status_types (
  filing_status_cd int(11) not null auto_increment,
  filing_status_cd_desc varchar(255) not null,
  primary key (filing_status_cd)
) Engine=InnoDB Default Charset=utf8;

insert into offertrak_tax_filing_status_types (
  filing_status_cd,
  filing_status_cd_desc
) values
(1,'Single'),
(2,'Head of Household'),
(3,'Married filing Jointly'),
(4,'Married filing Separately');

create table if not exists offertrak_tax_table (
  tax_rate_id int(11) not null auto_increment,
  filing_status_cd int(11) not null,
  income_range_min decimal(15,2) not null default 0.00,
  income_range_max decimal(15,2) not null,
  tax_rate decimal(5,2) not null,
  primary key (tax_rate_id),
  foreign key (filing_status_cd) references offertrak_tax_filing_status_types(filing_status_cd) on update cascade on delete restrict
) Engine=InnoDB Default Charset=utf8;

insert into offertrak_tax_table (
  tax_rate_id,
  filing_status_cd,
  tax_rate,
  income_range_min,
  income_range_max
) values
(null,1,10.00,0.00,9525.00),
(null,1,12.00,9526.00,38700.00),
(null,1,22.00,38701.00,82500.00),
(null,1,24.00,82501.00,157500.00),
(null,1,32.00,157201.00,200000.00),
(null,1,35.00,200001.00,500000.00),
(null,1,37.00,500001.00,9999999999.00),
(null,2,10.00,0.00,13600.00),
(null,2,12.00,13601.00,51800.00),
(null,2,22.00,51801.00,82500.00),
(null,2,24.00,82501.00,157500.00),
(null,2,32.00,157201.00,200000.00),
(null,2,35.00,200001.00,500000.00),
(null,2,37.00,500001.00,9999999999.00),
(null,3,10.00,0.00,19050.00),
(null,3,12.00,19051.00,77400.00),
(null,3,22.00,77401.00,165000.00),
(null,3,24.00,165001.00,315000.00),
(null,3,32.00,315001.00,400000.00),
(null,3,35.00,400001.00,600000.00),
(null,2,37.00,600001.00,9999999999.00),
(null,4,10.00,0.00,9525.00),
(null,4,12.00,9526.00,38700.00),
(null,4,22.00,38701.00,82500.00),
(null,4,24.00,82501.00,157000.00),
(null,4,32.00,157001.00,200000.00),
(null,4,35.00,200001.00,300000.00),
(null,4,37.00,300001.00,9999999999.00);

create table if not exists offertrak_applicants (
  applicant_id int(11) not null auto_increment,
  last_name varchar(255) not null,
  first_name varchar(255) not null,
  filing_status_cd int(11) not null,
  contact_type_cd int(11) not null,
  coverletter_sw varchar(1) not null,
  resume_sw varchar(1) not null,
  reference_sw varchar(1) not null,
  reference_checked_sw varchar(1) not null,
  primary key (applicant_id),
  foreign key (contact_type_cd) references offertrak_contact_types(contact_type_cd) on update cascade on delete restrict,
  foreign key (filing_status_cd) references offertrak_tax_filing_status_types(filing_status_cd) on update cascade on delete restrict
) Engine=InnoDB Default Charset=utf8;

create table if not exists offertrak_agencies (
  agency_id int(11) not null auto_increment,
  agency_name varchar(255) not null,
  primary key (agency_id)
) Engine=InnoDB Default Charset=utf8;

insert into offertrak_agencies (
  agency_id,
  agency_name
) values
(1,'SSS'),
(2,'Headhunters'),
(3,'ACME');

create table if not exists offertrak_users (
  user_id int(11) not null auto_increment,
  email_id varchar(255) not null,
  login_pw varchar(255) not null,
  first_name varchar(255) not null,
  last_name varchar(255) not null,
  access_type varchar(1) not null,
  agency_id int(11) default null,
  login_count int(11) not null,
  bad_login_count int(11) default 0,
  last_login_date datetime default null,
  password_modified datetime default null,
  primary key (user_id),
  unique key (email_id),
  foreign key (agency_id) references offertrak_agencies(agency_id) on update cascade on delete restrict
) Engine=InnoDB Default Charset=utf8;

insert into offertrak_users (
  user_id,
  email_id,
  login_pw,
  first_name,
  last_name,
  access_type,
  agency_id,
  login_count,
  bad_login_count,
  last_login_date,
  password_modified
) values 
(1,'admin@example.com',md5('admin'),'Systems','Administrator','A',null,0,0,null,null),
(2,'rmorgam@example.com',md5('Sally12!'),'Roberta','Morgan','R',1,0,0,null,null),
(3,'ddarrow@example.com',md5('Donna78!'),'Dwight','Darrow','R',2,0,0,null,null),
(4,'jjohnson@example.com',md5('Pepper12!'),'Joyce','Johnson','R',1,0,0,null,null),
(5,'ggeronimo@example.com',md5('Skydive1!'),'George','Geronimo','R',3,0,0,null,null),
(6,'afranklin@example.com',md5('Lizzy01!'),'Albert','Franklin','R',3,0,0,null,null);

create table if not exists offertrak_job_categories (
  job_category_id int(11) not null auto_increment,
  job_category_id_desc varchar(255) not null,
  primary key (job_category_id)
) Engine=InnoDB Default Charset=utf8;

insert into  offertrak_job_categories (
  job_category_id,
  job_category_id_desc
) values
(1,'Management'),
(2,'Computer Science and Mathematics'),
(3,'Architecture / Engineering'),
(4,'Social Sciences'),
(5,'Education and Training'),
(6,'Sales');

create table if not exists offertrak_jobs (
  job_id int(11) not null auto_increment,
  job_category_id int(11) not null,
  job_title varchar(255) not null,
  city_name varchar(255) default null,
  state_cd varchar(2) default null,
  primary key (job_id),
  foreign key (job_category_id) references offertrak_job_categories(job_category_id) on update cascade on delete restrict
) Engine=InnoDB Default Charset=utf8;

create table if not exists offertrak_job_offer (
  offer_id int(11) not null auto_increment,
  applicant_id int(11) not null,
  job_id int(11) not null,
  offer_datetime datetime not null,
  salary_offered decimal(15,2) not null,
  agency_cost decimal(9,2) not null,
  primary key (offer_id),
  unique key (applicant_id,job_id),
  foreign key (applicant_id) references offertrak_applicants(applicant_id) on update cascade on delete restrict,
  foreign key (job_id) references offertrak_jobs(job_id) on update cascade on delete restrict
) Engine=InnoDB Default Charset=utf8;

