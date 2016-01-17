--Funkcja do usuwania z tabeli Gry
-- TOC entry 306 (class 1255 OID 3031389)
-- Name: delete_gra(character varying); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION delete_gra(character varying) RETURNS void
    LANGUAGE plpgsql
    AS $_$
declare
x integer;
begin
select into x idgra from gra where nazwa=$1 ;
delete from kategorie where gra_idgra = x;
delete from tworcy where gra_idgra = x;
delete from gra where idgra= x;
return;
end$_$;


ALTER FUNCTION public.delete_gra(character varying) OWNER TO xmvwbdee;

--Funkcja do dodawania zaawansowanego
-- TOC entry 289 (class 1255 OID 2961967)
-- Name: insert_advanced(character varying, date, character varying, double precision, boolean, character varying, character varying, character varying, text, text); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION insert_advanced(character varying, date, character varying, double precision, boolean, character varying, character varying, character varying, text, text) RETURNS void
    LANGUAGE plpgsql
    AS $_$
begin
	insert into gra(nazwa,data_wydania,opis,ocena,multiplayer) values ($1,$2,$3,$4,$5);
	insert into producenci(nazwa) values ($6);
	insert into wydawca(nazwa) values ($7);
	insert into wydawca_pl(nazwa) values ($8);
	insert into tworcy(producenci_idproducenci,wydawca_idwydawca,wydawca_pl_idwydawca_pl,gra_idgra) values ((SELECT last_value from producenci_idproducenci_seq),(SELECT last_value from wydawca_idwydawca_seq),(SELECT last_value from wydawca_pl_idwydawca_pl_seq),(SELECT last_value from gra_idgra_seq));
	INSERT INTO kategorie(gra_idgra,kategoria_idkategoria)
	SELECT (SELECT last_value from gra_idgra_seq),
	cast(id AS INT)
	FROM unnest(string_to_array($9, ',')) AS dt(id);
	INSERT INTO platformy(gra_idgra,platforma_idplatforma)
	SELECT (SELECT last_value from gra_idgra_seq),
	cast(id AS INT)
	FROM unnest(string_to_array($10, ',')) AS plat(id);
end;
$_$;


ALTER FUNCTION public.insert_advanced(character varying, date, character varying, double precision, boolean, character varying, character varying, character varying, text, text) OWNER TO xmvwbdee;

--Funkcja do usuwania kategorii z statystyk (Trigger)
-- TOC entry 875 (class 1255 OID 3039100)
-- Name: kategorie_delete(); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION kategorie_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare
kategorie integer;
begin
select into kategorie ilosc_kategorii from statystyka;
update statystyka set ilosc_kategorii=kategorie-1;
return new ;
end$$;


ALTER FUNCTION public.kategorie_delete() OWNER TO xmvwbdee;

--Funkcja do zmiany oceny
-- TOC entry 305 (class 1255 OID 2894593)
-- Name: ocena_change(integer, integer); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION ocena_change(integer, integer) RETURNS void
    LANGUAGE plpgsql
    AS $_$
declare x float;
declare count integer;
declare count_new integer;
declare wynik float;
begin
select ocena into x from gra where idgra = $1;
select ilosc_ocen into count from gra where idgra = $1;
wynik=((x*count)+$2)/(count+1);
update gra set ocena=wynik where idgra = $1;
count_new=count+1;
update gra set ilosc_ocen=count_new where idgra = $1;
return;                                               
end;
$_$;


ALTER FUNCTION public.ocena_change(integer, integer) OWNER TO xmvwbdee;

--Funkcja do usuwania platformy z statystyk (Trigger)
-- TOC entry 877 (class 1255 OID 3039111)
-- Name: platforma_delete(); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION platforma_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare
platforma integer;
begin
select into platforma ilosc_platform from statystyka;
update statystyka set ilosc_platform=platforma-1;
return new ;
end$$;


ALTER FUNCTION public.platforma_delete() OWNER TO xmvwbdee;


--Funkcja tworzaca statystyki z tablicy gra (Trigger)
-- TOC entry 878 (class 1255 OID 3039092)
-- Name: statystyka(); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION statystyka() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare
gry integer;
oceny integer;
srednia_new double precision;
begin
select into gry ilosc_gier from statystyka;
update statystyka set ilosc_gier=gry+1;
select into oceny ilosc_ocen from statystyka;
update statystyka set ilosc_ocen=oceny+1;
select into srednia_new avg(ocena) from wszystko;
update statystyka set srednia = srednia_new;
return new ;
end$$;


ALTER FUNCTION public.statystyka() OWNER TO xmvwbdee;

--Funkcja do usuwania gier z statystyk (trigger)
-- TOC entry 879 (class 1255 OID 3039096)
-- Name: statystyka_delete(); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION statystyka_delete() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare
gry integer;
oceny integer;
srednia_new double precision;
begin
select into gry ilosc_gier from statystyka;
update statystyka set ilosc_gier=gry-1;
select into oceny ilosc_ocen from statystyka;
update statystyka set ilosc_ocen=oceny-1;
select into srednia_new avg(ocena) from wszystko;
update statystyka set srednia = srednia_new;
return new ;
end$$;


ALTER FUNCTION public.statystyka_delete() OWNER TO xmvwbdee;

--Funkcja do dodawania kategorii do statystyk (Trigger)
-- TOC entry 874 (class 1255 OID 3039099)
-- Name: statystyka_kategorie(); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION statystyka_kategorie() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare
kategorie integer;
begin
select into kategorie ilosc_kategorii from statystyka;
update statystyka set ilosc_kategorii=kategorie+1;
return new ;
end$$;


ALTER FUNCTION public.statystyka_kategorie() OWNER TO xmvwbdee;

--Funkcja do dodawania platform do statystyk (Trigger)
-- TOC entry 876 (class 1255 OID 3039110)
-- Name: statystyka_platforma(); Type: FUNCTION; Schema: public; Owner: xmvwbdee
--

CREATE FUNCTION statystyka_platforma() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
declare
platforma integer;
begin
select into platforma ilosc_platform from statystyka;
update statystyka set ilosc_platform=platforma+1;
return new ;
end$$;


ALTER FUNCTION public.statystyka_platforma() OWNER TO xmvwbdee;
