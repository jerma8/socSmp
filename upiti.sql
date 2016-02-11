select * from korisnik where ime like "%" and uloga like "%";
select * from namirnica;
select * from tvrtka;

insert into korisnik(ime,prezime,oib,datumRodenja,adresa,mjesto,brojClanovaObitelji,korisnik,lozinka,uloga) values('hehe','hehe',3232423451,'2011-03-11','op2','Os',1,'proba',md5('proba'),'admin');

update korisnik set prezime='damir1',ime='dadada' where sifra=15;

select distinct jedinicaMjere from namirnica;

select a.naziv=b.ime
from tvrtka a
inner join korisnik b on a.naziv=b.ime;

select b.naziv,a.kolicina from donira a inner join namirnica b on a.sifraNamirnice=b.sifra
where a.sifraNamirnice=2;

select * from namirnica where sifra=20;


delete from namirnica where sifra=8;

select sifra,naziv from namirnica where naziv='jaja';


select * from donira where sifraNamirnice=6;

select * from pripremaDonacije where sifraTvrtke=1;

delete from pripremaDonacije where naziv like "Salata";

update pripremaDonacije set kolicina=kolicina+10 where sifra=3;

select * from tvrtka;
select* from korisnik;

insert into pripremaDonacije(sifraTvrtke,sifraNamirnice,naziv,kolicina,jedinicaMjere,rokTrajanja) values
(1,null,'kkkkk',100,'kilogram',null);

update namirnica set stanje=100 where naziv like "Kruh";


select count(distinct sifraTvrtke) from pripremaDonacije;


select
a.sifra,a.naziv as nazivTvrtke,a.email, b.naziv as nazivNamirnice,b.sifra as sifraNamirnice, b.kolicina, b.rokTrajanja
from tvrtka a
inner join pripremaDonacije b on a.sifra=b.sifraTvrtke
group by a.sifra;


select
a.sifra,a.naziv as nazivTvrtke,a.email, b.naziv as nazivNamirnice, b.kolicina, b.rokTrajanja
from tvrtka a
inner join pripremaDonacije b on a.sifra=b.sifraTvrtke
where b.sifra=2;

describe korisnik;

delete from pripremaDonacije where sifra=3;

select a.naziv, a.jedinicaMjere, b.datumIsporuke, b.kolicina, b.rokTrajanja
from namirnica a
inner join donira b on a.sifra=b.sifraNamirnice
inner join tvrtka c on b.sifraTvrtke=c.sifra
where c.naziv like "konzum";



insert into namirnica(barkod,jedinicaMjere,naziv,kvotaPoDanu,kvotaPoClanu,stanje,trazeno) values 
('036220291752','litra', '23112eko',40,2,50,null);

select naziv, jedinicaMjere, stanje from namirnica where stanje is null;


select * from korisnik where sifra=1;

select * from uzima;

delete from uzima where sifraKorisnika=1 and sifraNamirnice=3 and DATE(datumUzimanja)='2015-04-03';


update uzima set kolicina=55 where sifraKorisnika=1 and sifraNamirnice=1 and kolicina=0;

select * from namirnica where sifra=1;


select
a.sifra,a.naziv,a.jedinicaMjere,a.kvotaPoDanu,a.kvotaPoClanu
from namirnica a
inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra;

select 
a.naziv as Naziv,
a.jedinicaMjere as Jedinica_mjere, 
b.kolicina as Kolicina,
b.datumUzimanja as Datum_uzimanja
from namirnica a
inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra
where c.sifra=1;



select
a.naziv as naziv,
a.adresa as adresa,
a.imeKontaktOsobe as imeKontaktOsobe,
a.telKontaktOsobe as telKontaktOsobe,
a.email as email,
e.ime as ime
from tvrtka a 
inner join donira b on a.sifra=b.sifraTvrtke
inner join namirnica c on b.sifraNamirnice=c.sifra
inner join uzima d on d.sifraNamirnice=c.sifra
inner join korisnik e on d.sifraKorisnika=e.sifra
where a.naziv like e.ime;


select * from narudzba where sifra=9;

select * from uzima;
select * from namirnica;

select
c.ime, c.prezime,b.sifraKorisnika,b.sifraNamirnice, b.datumUzimanja, b.kolicina, a.barkod, a.naziv, a.jedinicaMjere
from namirnica a
inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra
where c.sifra=1;

delete from uzima where sifraKorisnika=1 and sifraNamirnice=2 and datumUzimanja='2013-12-11 00:00:00';

select
a.sifra as sifraNarudzbe,a.naziv,a.kolicina,a.datumNarudzbe,
b.sifra,b.ime,b.prezime
from narudzba a
inner join korisnik b on b.sifra=a.sifraKorisnika
where b.sifra=1;


select *, count(kolicina) from uzima;

delete from uzima where 
sifraKorisnika=7 and 
sifraNamirnice=1 and
datumUzimanja="2015-03-20";

select * from korisnik where ime like "%konzum%";


select 
b.sifra,b.ime,b.prezime,a.naziv,a.kolicina,a.datumNarudzbe
from narudzba a
inner join korisnik b on a.sifraKorisnika = b.sifra
where b.sifra=1;

insert into uzima(sifraKorisnika,sifraNamirnice,datumUzimanja) values
(1,2,curtime());


select 
a.sifra, a.barkod, a.naziv, a.jedinicaMjere, a.kvotaPoDanu, a.kvotaPoClanu,a.stanje
from namirnica a 
inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra 
where c.sifra=7 ;



select 
c.naziv
from korisnik a
inner join uzima b on a.sifra=b.sifraKorisnika
inner join namirnica c on c.sifra=b.sifraNamirnice
where a.sifra=7;

select * from donira;
select * from pripremaDonacije;
select * from tvrtka;
select * from korisnik;

select * from uzima where sifraKorisnika=1;

delete from donira where sifraTvrtke=1;
delete from pripremaDonacije where sifraTvrtke=1;

delete from tvrtka where sifraKorisnika=6;

delete from korisnik where sifra=6;


update korisnik set ime="a",prezime="b"
where sifra=11;

select sifraKorisnika from tvrtka where sifraKorisnika=6;


select * from pripremadonacije where sifra=6;


select * from namirnica;

update namirnica set trazeno=trazeno+1 where sifra=6;

delete from narudzba where sifraKorisnika=1;

select
c.ime, c.prezime,b.sifraKorisnika,b.sifraNamirnice, b.datumUzimanja, b.kolicina, a.barkod, a.naziv, a.jedinicaMjere
from namirnica a
inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra
where c.sifra=2;

select * from donira;

select
a.sifra,a.naziv,b.sifraNamirnice,b.datumIsporuke,b.kolicina,b.rokTrajanja,c.naziv,c.stanje
from tvrtka a
inner join donira b on a.sifra=b.sifraTvrtke
inner join namirnica c on b.sifraNamirnice=c.sifra
where a.sifra=2
;

select * from namirnica;

select * from korisnik where sifra=7;
select * from uzima;

update uzima set kolicina=10 
where sifraKorisnika=1 and sifraNamirnice=2 and kolicina=0;

select
a.sifra,a.ime,a.prezime,b.sifraKorisnika,b.sifraNamirnice,b.datumIsporuke
from korisnik a
inner join donira b on a.sifra=b.sifraKorisnika
inner join namirnica c on b.sifraNamirnice=c.sifra
where b.sifraKorisnika=7;


select a.sifra, a.ime, a.prezime, a.oib,a.adresa,a.mjesto,b.naziv, b.kolicina, b.rokTrajanja
from korisnik a inner join pripremaDonacije b on a.sifra=b.sifraKorisnika
where a.sifra like '%';
        
select * from donira where sifraKorisnika=7;

select * from donira where sifraTvrtke=1;

select * from donira;
select * from pripremaDonacije;
SELECT * from namirnica;


select
a.sifra,a.ime,a.prezime,
b.sifraNamirnice,b.datumIsporuke,b.kolicina,b.rokTrajanja,
c.naziv,c.stanje,c.jedinicaMjere
from korisnik a
inner join donira b on a.sifra=b.sifraKorisnika
inner join namirnica c on b.sifraNamirnice=c.sifra
where a.sifra=7;


update uzima set kolicina=33
where sifraKorisnika=1 and sifraNamirnice=1 and 
datumUzimanja between DATE_SUB(NOW() , INTERVAL 10 MINUTE) AND NOW();

delete from uzima where 
sifraKorisnika=1 and sifraNamirnice=1 and DATE(datumUzimanja)='2015-04-08';


select * from donira;

select
distinct(a.naziv),a.imeKontaktOsobe,a.prezimeKontaktOsobe,a.telKontaktOsobe
from tvrtka a
inner join donira b on a.sifra=b.sifraTvrtke
inner join namirnica c on b.sifraNamirnice=c.sifra
where c.sifra=1;


select
distinct(a.ime),a.prezime,a.oib
from korisnik a
inner join donira b on a.sifra=b.sifraKorisnika
inner join namirnica c on b.sifraNamirnice=c.sifra
where c.sifra=5;


select distinct(a.ime),a.prezime,a.oib
from korisnik a
inner join uzima b on a.sifra=b.sifraKorisnika
inner join namirnica c on b.sifraNamirnice=c.sifra
where c.sifra=1;


select a.sifra,a.naziv,a.jedinicaMjere,a.barkod,a.kvotaPoClanu,a.kvotaPoDanu,a.sifra,a.trazeno,b.datumUzimanja
from namirnica a inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra
where c.sifra=1 and a.naziv like '%' and a.stanje is not null and b.datumUzimanja between DATE_SUB(NOW() , INTERVAL 5 MINUTE) AND NOW();

insert into uzima(sifraKorisnika,sifraNamirnice,datumUzimanja) value
(1,2,curdate());

select * from uzima where sifraKorisnika=1;
select * from namirnica;

select * from namirnica where barkod='231312';


delete from narudzba where sifraKorisnika=3;


select * from tvrtka;


select
a.sifra,a.barkod,a.naziv,a.jedinicaMjere, a.kvotaPoClanu,a.kvotaPoDanu,a.stanje,a.trazeno,
b.kolicina,b.datumUzimanja,
c.sifra
from namirnica a
inner join uzima b on a.sifra=b.sifraNamirnice
inner join korisnik c on b.sifraKorisnika=c.sifra
where a.stanje>0 and c.sifra=1;



select * from uzima where sifraKorisnika=1;

select sum(kolicina) as ukupno from uzima where sifraKorisnika=1 and date(datumUzimanja)='2015-04-17';

select * from uzima where sifraKorisnika=1 and date(datumUzimanja)='2015-04-20';