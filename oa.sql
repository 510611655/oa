create database oa;
set names gbk;
use oa;

-- 创建一个oa系统的部门表(组织结构);
-- 记得加表前缀(为了区分表混淆);
create table oa_dept(
  id smallint not null auto_increment,
  name varchar(45) not null default '' comment '部门名称',
  pid smallint not null default 0 comment '上级部门ID',
  sort smallint not null default 50 comment '部门排序字段',
  intro text comment '部门介绍',
  add_time date comment '部门的添加时间',
  primary key(id)
)engine=innodb charset=utf8;

-- 创建一个职员表
create table oa_user(
    id int not null auto_increment,
    username varchar(40) not null default '',
    password char(32) not null default '',
    sex tinyint not null default 0,
    truename varchar(30) not null default '',
    dept_id smallint not null default 0,
    tel char(11) not null  default '',
    birthday date not null  default '0000-00-00',
    email varchar(30) not null default '',
    photo varchar(150) not null default '',
    add_time date not null default '0000-00-00',
    primary key(id)
)engine=innodb charset=utf8;

-- 创建一个邮件表
create table oa_email(
  id int not null auto_increment,
  title varchar(150) not null default "" comment "邮件标题",
  content text comment "邮件内容",
  send_time datetime not null default "0000-00-00 00:00" comment "发送时间",
  send_id int not null default 0 comment "发件人",
  receiver_id int not null default 0 comment "收件人",
  file varchar(150) not null default "" comment "附件",
  is_read tinyint not null default 0 comment "判断是否已读 0-未读 1-已读",
  primary key(id)
)engine=innodb charset=utf8;

-- 创建一个权限表
create table oa_auth(
    id smallint not null auto_increment,
    name varchar(100) not null default '' comment '权限名称 如:部门列表,删除',
    pid smallint not null default 0 comment '权限的父级权限id',
    m_name varchar(100) not null default '' comment '权限所属的模块 如:Admin,Home',
    c_name varchar(100) not null default '' comment '权限所属的控制器 如:Doc,Email',
    a_name varchar(100) not null default '' comment '权限所属的模块 如:add,send,receive,index',
    level tinyint not null default 0 comment '权限的级别 如:部门管理-0 部门列表-1 部门删除-2',
    sort smallint not null default 50 comment '级别的排序,方便显示',
    primary key(id)
)engine=innodb charset=utf8;

-- 创建角色表
create table oa_role(
    id smallint not null auto_increment,
    role_name varchar(100) not null default '' comment '角色的名称 如:管理员,普通员工' ,
    auth_ids varchar(200) not null default '' comment '对应权限表的id 如:1,2,3,4' ,
    primary key(id)
)engine=innodb charset=utf8;

-- 创建一个日程安排表
create table oa_plan(
    id int not null auto_increment,
    title varchar(50) not null default "" comment "日程标题",
    content text comment "日程内容",
    plan_time datetime default "00-00-00 00:00:00" comment "日程时间",
    author_id int not null default 0 comment '发布公文的作者',
    primary key(id)
)engine=innodb charset=utf8

-- 创建一个公文表
create table oa_doc(
    id int not null auto_increment,
    title varchar(50) not null default '' comment '公文的标题',
    content text comment '公文的内容',
    author_id int not null default 0 comment '发布公文的作者',
    file varchar(130) not null default '' comment '公文的附件',
    add_time date,
    primary key(id)
)engine=innodb charset=utf8;

-- 模拟oa_auth表的数据
insert into  oa_auth values(1,'日常办公',0,'Admin','Index','Home',0,1);

insert into  oa_auth values(2,'公文管理',0,'','','',0,2);
insert into  oa_auth values(3,'公文列表',2,'Admin','Doc','index',1,1);
insert into  oa_auth values(4,'添加公文',2,'Admin','Doc','add',1,1);
insert into  oa_auth values(5,'公文编辑',3,'Admin','Doc','edit',2,1);
insert into  oa_auth values(6,'公文删除',3,'Admin','Doc','del',2,1);

insert into  oa_auth values(7,'部门管理',0,'','','',0,3);
insert into  oa_auth values(8,'部门列表',7,'Admin','Dept','index',1,1);
insert into  oa_auth values(9,'部门添加',7,'Admin','Dept','add',1,1);
insert into  oa_auth values(10,'部门编辑',8,'Admin','Dept','edit',2,1);
insert into  oa_auth values(11,'部门删除',8,'Admin','Dept','del',2,1);

insert into  oa_auth values(12,'职员管理',0,'','','',0,4);
insert into  oa_auth values(13,'职员列表',12,'Admin','User','index',1,1);
insert into  oa_auth values(14,'职员添加',12,'Admin','User','add',1,1);
insert into  oa_auth values(15,'职员编辑',13,'Admin','User','edit',2,1);
insert into  oa_auth values(16,'职员删除',13,'Admin','User','ajaxdel',2,1);

insert into  oa_auth values(17,'邮件管理',0,'','','',0,5);
insert into  oa_auth values(18,'发送邮件',17,'Admin','Email','send',1,1);
insert into  oa_auth values(19,'收件箱',17,'Admin','Email','receive',1,1);

insert into  oa_auth values(20,'系统管理',0,'','','',0,5);
insert into  oa_auth values(21,'角色管理',20,'Admin','Role','index',1,1);
insert into  oa_auth values(22,'权限管理',20,'Admin','Auth','index',1,1);