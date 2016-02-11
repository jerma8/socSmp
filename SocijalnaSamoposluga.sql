drop database if exists socijalnaSamoposluga;
create database socijalnaSamoposluga character set utf8;
use socijalnaSamoposluga;

ALTER DATABASE CHARACTER SET utf8 COLLATE utf8_unicode_ci;

create table korisnik(
sifra int not null primary key auto_increment,
ime varchar(50) not null,
prezime varchar(50) not null,
oib char(11) not null,
datumRodenja date,
adresa varchar(100) not null,
mjesto varchar(100) not null,
brojClanovaObitelji int,
korisnik varchar(50) not null,
lozinka char(32) not null,
uloga varchar(50) not null
)engine=innodb;

create table uzima(
sifraKorisnika int not null,
sifraNamirnice int not null,
datumUzimanja datetime,
kolicina decimal(15,3) not null
)engine=innodb;

create table namirnica(
sifra int not null primary key auto_increment,
barkod varchar(20) not null,
jedinicaMjere varchar(50) not null,
naziv varchar(100) not null,
kvotaPoDanu decimal(15,3),
kvotaPoClanu decimal(15,3),
stanje decimal(15,3) not null,
trazeno decimal(15,3) not null
)engine=innodb;

create table donira(
sifraTvrtke int not null,
sifraNamirnice int not null,
datumIsporuke datetime not null,
kolicina decimal(15,3),
rokTrajanja datetime
)engine=innodb;

create table tvrtka(
sifra int not null primary key auto_increment,
naziv varchar(200) not null,
adresa varchar(100) not null,
imeKontaktOsobe varchar(150),
telKontaktOsobe int,
email varchar(200)
)engine=innodb;


create table narudzba(
sifra int not null primary key auto_increment,
sifraKorisnika int,
naziv varchar(100) not null,
kolicina decimal(15,3) not null,
datumNarudzbe datetime not null
)engine=innodb;


create table pripremaDonacije(
sifra int not null primary key auto_increment,
sifraTvrtke int,
naziv varchar(100) not null,
kolicina decimal(15,3) not null,
rokTrajanja date,
datumSlanjaPripreme datetime
)engine=innodb;

create unique index i1 on korisnik(oib);
create unique index i2 on korisnik(korisnik);


alter table uzima add foreign key(sifraKorisnika) references korisnik(sifra);
alter table uzima add foreign key(sifraNamirnice) references namirnica(sifra);

alter table donira add foreign key (sifraTvrtke) references tvrtka(sifra);
alter table donira add foreign key (sifraNamirnice) references namirnica(sifra);

alter table narudzba add foreign key (sifraKorisnika) references korisnik(sifra);

alter table pripremaDonacije add foreign key (sifraTvrtke) references tvrtka(sifra);

insert into korisnik(ime,prezime,oib,datumRodenja,adresa,mjesto,brojClanovaObitelji,korisnik,lozinka,uloga) values
('PAMELA', 'FABIJAN',23411463774,'2013-12-01','Opatijska 3','Osijek',3,'korisnik1',md5('korisnik1'),'primateljiPomoci'),
('DOMINIKA-NADA', 'PANJKOV',76436511778,'2013-12-01','Opatijska 3','Osijek',null,'korisnik2',md5('korisnik2'),'primateljiPomoci'),
('JAŠKO', 'DERGEZ',78234529054,'2013-12-01','Opatijska 3','Osijek',2,'admin1',md5('admin1'),'admin'),
('GORIJAN', 'PACI',32323432054,'2013-12-01','Opatijska 3','Osijek',5,'adminprim1',md5('adminprim1'),'adminPrimateljPomoci'),
('JASEN', 'BIŠKO',28236529014,'2013-12-01','Opatijska 3','Osijek',2,'adminprim2',md5('adminprim2'),'adminPrimateljPomoci'),
('Konzum', 'd.d.',54214529551,'2006-05-15','Opatijska 3','Osijek',3,'tvrtka1',md5('tvrtka1'),'tvrtka');


insert into narudzba (sifraKorisnika,naziv,kolicina,datumNarudzbe) values 
(1,'Ajvar (blagi)',1,'2013-12-01'),
(1,'Šećer',2,'2006-05-15'),
(3,'WC papir',1,'2006-05-11'),
(4,'Pašteta',3,'2010-10-20'),
(5,'Brašno',5,'2008-05-15');


insert into tvrtka(naziv,adresa,imeKontaktOsobe,telKontaktOsobe,email) values
('Konzum','Opatijska 39','Ivica',031423532,'ivica@gmail.com'),
('Kaufland','Opatijska 39','Đuro',031423532,'đuro@gmail.com'),
('Ravlić','Opatijska 39','Tihana',031423532,'tihana@gmail.com'),
('Plodine','Opatijska 39','Valerija',031423532,'valerija@gmail.com');


insert into pripremaDonacije(sifraTvrtke,naziv,kolicina,rokTrajanja) values
(1,'Kruh', 100, '2014-08-08'),
(1,'Šećer', 30, '2014-04-18'),
(2,'Kava', 10, '2015-01-28'),
(3,'Meso', 10, '2012-06-28'),
(1,'Mlijeko', 10, '2012-06-28'),
(4,'Salata', 10, null);



insert into namirnica(barkod,jedinicaMjere,naziv,kvotaPoDanu,kvotaPoClanu,stanje,trazeno) values 
('036000291452','litra', 'Mlijeko',40,2,50,10),
('117353424323','pakovanje (10)', 'Jaja',40,2,150,20),
('321367332316','tuba/staklenka/vrećica', 'Majoneza',10,2,73,25),
('224545244589','litra', 'Jogurt',19,2,32,5),
('222222244589','kilogram', 'Kruh',20,2,null,30),
('111111111139','kilogram', 'Pile',20,1,null,5);


insert into donira(sifraTvrtke,sifraNamirnice,datumIsporuke,kolicina,rokTrajanja) values
(1,3,'2013-12-01', 100,'2014-01-15'),
(2,4,'2013-06-01', 50,'2014-01-15'),
(3,1,'2013-02-01', 50,'2014-01-15'),
(4,2,'2013-05-01', 200,'2014-01-15'),
(1,1,'2013-10-21' ,30,'2014-01-15');

insert into uzima(sifraKorisnika,sifraNamirnice,datumUzimanja,kolicina) values
(1,2,'2013-12-11',2),
(6,1,'2013-12-11',2),
(2,3,'2013-12-01',2),
(3,4,'2013-12-01',2),
(4,2,'2013-12-09',2),
(5,3,'2013-11-25',2);