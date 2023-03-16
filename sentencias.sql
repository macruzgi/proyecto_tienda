ALTER TABLE cotizacion_detalle 
DROP CONSTRAINT fk_cotizaciondetalle_cotizacion;

ALTER TABLE cotizacion_detalle add constraint fk_cotizaciondetalle_cotizacion foreign key(id_cotizacion) 
references cotizacion(id_cotizacion) on delete cascade on update cascade;

select c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, DATE_FORMAT(c.fecha_ultima_modificacion, '%d-%m-%Y %H:%i:%s') as fecha_ultima_modificacion,  c.nombre_cliente,
			c.terminos_condiciones, c.costo,
			cd.id_detalle , cd.cantidad , cd.precio_venta , cd.subtotal, cd.codigoabastecimiento ,
			a.codigoproducto , a.precioventa, p.nombre , p.descripcion , p.tipo 
			from cotizacion c
			inner join cotizacion_detalle cd ON (cd.id_cotizacion = c.id_cotizacion)
			inner join abastecimiento a on(a.codigoabastecimiento = cd.codigoabastecimiento)
			inner join productos p on(p.codigoproducto = a.codigoproducto)
			where c.id_cotizacion = 22  order by cd.id_detalle asc
			
select codigofacturacion, estado from facturacion where codigofacturacion = 32155;
			
			select productos.codigoproducto,
                nombre, tipo from productos
                where (tipo = 'Cirugía'
                or tipo ='Grooming'
                or tipo ='Procedimiento');
                
    select sum(costo) as bruto, 
                                    (select sum(preciounitario*detallefacturacion.cantidad) 
                                    from abastecimiento, detallefacturacion, facturacion 
                                    where abastecimiento.codigoabastecimiento=detallefacturacion.codigoabastecimiento 
                                    and detallefacturacion.codigofacturacion=facturacion.codigofacturacion 
                                    and date(facturacion.fecha)='2023-02-13') as costo 
                                   from facturacion where date(fecha)='2023-02-13';
                                   
                                  
select count(codigofacturacion) as REGISTRO_ELIMINADO, codigofacturacion, estado
from facturacion where codigofacturacion =32180;


select productos.codigoproducto,abastecimiento.codigoabastecimiento,
                nombre, tipo, descripcion,
                preciounitario, precioventa, existencia from productos, abastecimiento, existencia
            where productos.codigoproducto = abastecimiento.codigoproducto
                and abastecimiento.codigoabastecimiento=existencia.codigoabastecimiento 
                         /*and existencia > 0*/
            and (nombre like '%teclado%'
                or tipo like '%teclado%'
                or medida like '%teclado%'
                or descripcion like '%teclado%'
               
                )
            
                order by nombre, tipo,codigoabastecimiento, preciounitario limit 10
                
  
select p.codigoproducto,ab.codigoabastecimiento,
p.nombre, p.tipo, p.descripcion,
ab.preciounitario, ab.precioventa, ex.existencia 
from productos p 
inner join abastecimiento ab on (ab.codigoproducto = p.codigoproducto)
inner join existencia ex on(ex.codigoabastecimiento = ex.codigoabastecimiento);
                


SELECT p.codigoproducto , p.nombre, p.descripcion , SUM(e.existencia) AS existencia_total, t2.precioventa AS ultimo_precio
FROM productos p
JOIN (
  SELECT a.codigoproducto, MAX(a.fecha) AS ultima_fecha, a.precioventa
  FROM abastecimiento a
  GROUP BY a.codigoproducto 
) t2 ON p.codigoproducto = t2.codigoproducto
JOIN abastecimiento a ON t2.codigoproducto = a.codigoproducto AND t2.ultima_fecha = a.fecha
JOIN existencia e ON a.codigoabastecimiento = e.codigoabastecimiento
where p.nombre like '%teclado%'
       or p.descripcion like '%teclado%'
GROUP BY p.codigoproducto, p.nombre , t2.precioventa;



SELECT p.codigoproducto, p.nombre, p.descripcion, SUM(e.existencia) AS existencia_total, t2.precioventa AS ultimo_precio
FROM productos p
JOIN (
  SELECT a.codigoproducto, MAX(a.fecha) AS ultima_fecha, MAX(a.precioventa) AS precioventa
  FROM abastecimiento a
  GROUP BY a.codigoproducto
) t2 ON p.codigoproducto = t2.codigoproducto
JOIN abastecimiento a ON t2.codigoproducto = a.codigoproducto AND t2.ultima_fecha = a.fecha
JOIN existencia e ON a.codigoabastecimiento = e.codigoabastecimiento
WHERE p.nombre LIKE '%teclado%' OR p.descripcion LIKE '%teclado%'
GROUP BY p.codigoproducto, p.nombre, p.descripcion, t2.precioventa;



SELECT p.codigoproducto, p.nombre, p.descripcion, SUM(e.existencia) AS existencia_total, t2.precioventa AS ultimo_precio
FROM productos p
JOIN (
  SELECT a.codigoproducto, MAX(a.fecha) AS ultima_fecha, MAX(a.precioventa) AS precioventa
  FROM abastecimiento a
  GROUP BY a.codigoproducto
) t2 ON p.codigoproducto = t2.codigoproducto
JOIN abastecimiento a ON t2.codigoproducto = a.codigoproducto 
JOIN existencia e ON a.codigoabastecimiento = e.codigoabastecimiento
WHERE p.nombre LIKE '%martillo%' OR p.descripcion LIKE '%martillo%'
GROUP BY p.codigoproducto, p.nombre, p.descripcion, t2.precioventa;

select p.codigoproducto , p.nombre, p.descripcion  from productos p
WHERE p.nombre LIKE '%te%' OR p.descripcion LIKE '%te%' order by nombre asc;

drop table com_proveedor;
create table com_proveedor(
id_proveedor int not null primary key auto_increment not null,
pro_codigo varchar(15) not null comment 'codiog del proveedor valor unico',
pro_razon_social varchar(250) not null comment 'nombre de la razon social',
pro_nombre_comercial varchar(250),
pro_nrc varchar(8) not null comment 'numero de registro del contribuyente',
pro_nit varchar(16) not null comment 'numero de identificacion tributaria',
pro_dui varchar(10),
pro_direcion varchar(250),
pro_fecha_alta datetime not null default current_timestamp,
unique index pro_codigo(pro_codigo),
unique index pro_nrc(pro_nrc)
)
engine=innodb;

create database ferre_update;


-- db_sisin.adm_modulo definition

CREATE TABLE `adm_modulo` (
  `id_modulo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_modulo` varchar(100) NOT NULL,
  `modulo_descripcion` varchar(180) NOT NULL COMMENT 'descripcion del modulo',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_modulo`)
)  ENGINE=InnoDB ;

-- db_sisin.adm_modulo_opcion definition

CREATE TABLE `adm_modulo_opcion` (
  `id_modulo_opcion` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_opcion` varchar(250) NOT NULL,
  `link` char(100) DEFAULT NULL,
  `opcion_nivel` tinyint(4) NOT NULL COMMENT 'nivel de la opcion, 1 opcion del menu raiz, 2 opcion del submenu raiz 1,  3 opcion del submenu 2, etc..',
  `opcion_estado` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'estado de la opcion 1=activo 0=inactiva',
  `id_modulo` int(11) NOT NULL COMMENT 'llave foranea para relacionar con la tabla adm_modulo, indice',
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_modulo_opcion`),
  KEY `id_modulo` (`id_modulo`),
  CONSTRAINT `fk_moduloopcion_modulo` FOREIGN KEY (`id_modulo`) REFERENCES `adm_modulo` (`id_modulo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE `adm_modulo_opcion_usuario` (
  `id_usuario` int(10) unsigned NOT NULL,
  `id_modulo_opcion` int(11) NOT NULL,
  `tiene_permiso` tinyint(1) DEFAULT 0,
  UNIQUE KEY `id_usuario_id_opcion_menu` (`id_usuario`,`id_modulo_opcion`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_modulo_opcion` (`id_modulo_opcion`),
  CONSTRAINT `fk_moduloopcionenusuario_moduloopcion` FOREIGN KEY (`id_modulo_opcion`) REFERENCES `adm_modulo_opcion` (`id_modulo_opcion`) ON UPDATE CASCADE,
  CONSTRAINT `fk_moduloopcionenusuario_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`codigousuario`) ON UPDATE CASCADE
) ENGINE=InnoDB;

alter table adm_modulo_opcion_usuario add column agregar tinyint(1) DEFAULT 0;
alter table adm_modulo_opcion_usuario add column actualizar tinyint(1) DEFAULT 0;
alter table adm_modulo_opcion_usuario add column eliminar tinyint(1) DEFAULT 0; 
-- alter table adm_modulo_opcion_usuario drop column eliminar;

insert into adm_modulo (nombre_modulo, modulo_descripcion)
values('Facturación', 'Modulo de facturación'), 
('Inventario', 'Modoulo de inventario'),
('Reportes', 'Modulo de reportes'),
('Administración', 'Módulu de aministración');

select * from adm_modulo;


insert into adm_modulo_opcion (nombre_opcion, link, opcion_nivel, id_modulo)
values('Cotizaciones', 'Cotizacion/Cotizaciones', 1, 1),
('Por cobrar', 'Facturacion/Realizar_Facturacion', 1, 1),
('Productos', 'Inventario/Productos', 1, 2),
('Existencias', 'Inventario/existencia_de_productos', 1, 2),
('Compras', 'Inventario/Compras', 1, 2),
('Utilidad', '', 1, 3),
('Ventas', '', 1,3),
('Usuarios', '', 1, 4),
('Crear backup', '', 1, 4);


select * from adm_modulo_opcion amo ;
insert into adm_modulo_opcion_usuario (id_usuario, id_modulo_opcion)
select 2, amo.id_modulo_opcion  from adm_modulo_opcion amo ;


select u.codigousuario , u.nombreusuario, u.nombre,
amou.tiene_permiso, 
amo.id_modulo_opcion , amo.nombre_opcion, amo.link,
am.id_modulo, am.nombre_modulo 
from usuarios u 
inner join adm_modulo_opcion_usuario amou on (amou.id_usuario = u.codigousuario)
inner join adm_modulo_opcion amo on(amo.id_modulo_opcion = amou.id_modulo_opcion)
inner join adm_modulo am on (am.id_modulo = amo.id_modulo)
where amou.id_usuario = 1  order by am.id_modulo asc;

update usuarios  set contrasena = md5('010707') where codigousuario  >= 20;

select u.codigousuario , u.nombreusuario , u.tipousuario , u.nombre  
from usuarios u order by u.codigousuario desc;

update adm_modulo_opcion_usuario set tiene_permiso = 0, agregar = 0, actualizar  = 0, eliminar =0;

select f.codigofacturacion , f.fecha, f.no from facturacion f 

create table fac_cliente (
id_cliente int not null primary key auto_increment,
cli_codigo varchar(12) not null,
cli_nombre varchar (125) not null,
cli_direccion varchar(125),
cli_telefono varchar(9),
cli_fecha_creacion datetime NOT NULL DEFAULT current_timestamp(),
unique index cli_codigo(cli_codigo)
) engine=innodb;

select id_cliente, cli_codigo, cli_nombre, cli_telefono, 
DATE_FORMAT(cli_fecha_creacion, '%d-%m-%Y') as cli_fecha_creacion
from fac_cliente;

alter table adm_modulo add column fa_menu varchar(25) after modulo_descripcion; 
alter table adm_modulo add column mo_estado  tinyint(1) NOT NULL DEFAULT 1 after modulo_descripcion;
alter table adm_modulo drop column fa_menu;

alter table com_proveedor add column pro_telefono varchar(9)    after pro_direccion; 

select id_proveedor, pro_codigo, pro_razon_social, pro_nombre_comercial,
pro_nrc, pro_nit, pro_dui, pro_direccion, pro_telefono , pro_estado, DATE_FORMAT(pro_fecha_alta, '%d-%m-%Y') as pro_fecha_alta
from com_proveedor cp ;


create table  prod_tipos (
id_tipo_producto int not null primary key auto_increment,
tipo_nombre varchar(25) not null, 
tipo_fecha_creacion datetime NOT NULL DEFAULT current_timestamp()
) engine = innodb;


create table prod_tipo_unidad(
id_tipo_unidad int not null primary key auto_increment,
tipo_unidad_nombre varchar(25) not null,
tipo_fecha_creacion datetime NOT NULL DEFAULT current_timestamp()
) engine= innodb;

alter table productos add id_tipo_producto int not null; 
alter table productos add  index id_tipo_producto(id_tipo_producto);
alter table productos add id_tipo_unidad int not null;
alter table productos add index id_tipo_unidad(id_tipo_unidad);

DROP INDEX prod_tipo_unidad ON productos;
ALTER TABLE productos
DROP COLUMN prod_tipo_unidad;

select tipo from productos p  group by tipo;

UPDATE productos 
JOIN prod_tipos 
ON productos.tipo = prod_tipos.tipo_nombre 
SET productos.id_tipo_producto = prod_tipos.id_tipo_producto;

select * from prod_tipos;



alter table productos  add constraint fk_productos_tipoproducto foreign key(id_tipo_producto)
references prod_tipos(id_tipo_producto) on update cascade;

select medida from productos p  group by medida ;

insert into prod_tipo_unidad(tipo_unidad_nombre) values ('Unidad'), ('Libra'), 
('Quintal'), ('Media Libra'), ('Botella'), ('Caja'), 
('Metro'), ('Yarda'), ('Pie');

UPDATE productos 
JOIN prod_tipo_unidad 
ON productos.medida  = prod_tipo_unidad.tipo_unidad_nombre  
SET productos.id_tipo_unidad = prod_tipo_unidad.id_tipo_unidad;


select p.codigoproducto , p.nombre , p.descripcion,
ptu.tipo_unidad_nombre , pt.tipo_nombre 
from productos p 
inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad )
inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto )
order by codigoproducto desc;

update usuarios set contrasena = md5('010707');

select * from productos p where nombre ;

alter table productos add prod_fecha_creacion datetime NOT NULL DEFAULT current_timestamp() ;

alter table productos add prod_codigo varchar(25) after codigoproducto;
alter table productos add unique index prod_codigo(prod_codigo);

select count (*) from productos;
drop procedure insertar_valores;
DELIMITER $$
CREATE PROCEDURE insertar_valores()
BEGIN
    SET @i = 1;
    WHILE (@i <= 1853) DO
        update productos  set prod_codigo = (@i) where 1 = 1;
        SET @i = @i + 1;
    END WHILE;
end ;
DELIMITER ;

CALL insertar_valores();

UPDATE productos
SET prod_codigo = codigoproducto;

select p.codigoproducto , p.prod_codigo, p.nombre , p.descripcion ,
ptu.id_tipo_unidad, ptu.tipo_unidad_nombre , 
pt.id_tipo_producto, pt.tipo_nombre 
from productos p 
inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad )
inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto )
where p.codigoproducto = 2066;

select prov.id_proveedor , prov.pro_codigo, prov.pro_razon_social, prov.pro_nombre_comercial ,
prov.pro_nrc , prov.pro_nit  from com_proveedor prov where prov.pro_nrc = '1';

SELECT `p`.`codigoproducto`, `p`.`nombre`, `p`.`descripcion`
FROM `productos` `p`
WHERE `p`.`nombre` like :p.nombre:
OR `p`.`descripcion` like :p.descripcion:
ORDER BY `p`.`nombre` `as`
 LIMIT 10
 
 drop table com_compras;
 create table com_compras(
  id_compra int not null primary key auto_increment,
  `id_proveedor` int(11) not null,
  `com_codigo` varchar(15) NOT NULL COMMENT 'codiog del proveedor valor unico',
  `com_razon_social` varchar(250) NOT NULL COMMENT 'nombre de la razon social',
  `com_nombre_comercial` varchar(250) DEFAULT NULL,
  `com_nrc` varchar(8) NOT NULL COMMENT 'numero de registro del contribuyente',
  `com_nit` varchar(16) NOT NULL COMMENT 'numero de identificacion tributaria',
  com_numero_documednto varchar(15), 
  com_fecha_creacion datetime NOT NULL DEFAULT current_timestamp(),
  index id_proveedor(id_proveedor)
 )engine= innodb;

alter table com_compras add constraint fk_compras_proveedores foreign key(id_proveedor)
references com_proveedor(id_proveedor) on update cascade;

drop table com_compras_detalle;
create table com_compras_detalle(
 id_detalle_compra int not null primary key auto_increment,
 codigoproducto int(10) unsigned not null,
 det_cantidad decimal(10,2) not null,
 det_precio decimal(10,2) not null,
 det_sub_total decimal(10,2) not null,
 id_compra int not null,
 index codigoproducto(codigoproducto),
 index id_compra(id_compra)
)engine=innodb;

alter table com_compras_detalle add constraint fk_comprasdetalle_compras foreign key(id_compra)
references com_compras(id_compra) on update cascade;

alter table com_compras_detalle add constraint fk_comprasdetalle_productos foreign key(codigoproducto)
references productos(codigoproducto) on update cascade;

alter table com_compras add com_total decimal(10,2) not null after com_numero_documednto;

drop table inv_kardex;
create table inv_kardex(
id_kardex int not null primary key auto_increment,
kar_fecha_creacion datetime NOT NULL,
kar_tipo_transaccion  tinyint(1) NOT NULL  COMMENT 'tipo operacion, 1=comra, 2=venta, 3= entradas, 4=salidas',
kar_numero_documento varchar(15),
kar_cantidad decimal(10,2) not null,
kar_saldo decimal(10,2) not null, 
id_venta int,
id_compra int,
codigoproducto int(10) unsigned not null
);
alter  table inv_kardex add index codigoproducto(codigoproducto);
alter table inv_kardex add constraint fk_kardex_producto foreign key(codigoproducto)
references productos(codigoproducto) on update cascade;
-- NOTA A LA TABLA inv_kardex ES DE VER SI SE LE PUEDE AGREGAR LA FK DE COMPRAS Y VENTAS
SELECT kar_saldo FROM inv_kardex 
WHERE codigoproducto =256 ORDER BY kar_fecha_creacion DESC LIMIT 1;

SELECT kar_saldo FROM inv_kardex WHERE codigoproducto =256 ORDER BY kar_fecha_creacion DESC LIMIt 1

select cc.id_compra , cc.com_razon_social , cc.com_nombre_comercial , cc.com_nrc ,
cc.com_numero_documednto , cc.com_total , DATE_FORMAT(cc.com_fecha_creacion , '%d-%m-%Y') as com_fecha_creacion
from com_compras cc 


select DATE_FORMAT(ik.kar_fecha_creacion, '%d-%m-%Y') as kar_fecha_creacion , ik.kar_tipo_transaccion,
ccd.det_cantidad , ccd.det_precio, concat(p.nombre , ' (', p.descripcion , ')') as PRODUCTO 
from inv_kardex ik 
inner join com_compras cc on(cc.id_compra = ik.id_compra)
inner join com_compras_detalle ccd on(ccd.id_compra = cc.id_compra)
inner join productos p on(p.codigoproducto = ik.codigoproducto)
where  ik.codigoproducto  = 2064 order by ik.kar_fecha_creacion desc limit 10;

drop table prod_precios;
create table prod_precios(
id_precio int not null primary key auto_increment,
pre_precio decimal(10,2) not null,
pre_fecha_creacion datetime NOT null,
codigoproducto int(10) unsigned not null,
index codigoproducto(codigoproducto)
)engine=innodb;

alter table prod_precios add constraint fk_precios_producto foreign key(codigoproducto)
references productos(codigoproducto) on update cascade;

select DATE_FORMAT(pp.pre_fecha_creacion , '%d-%m-%Y') as pre_fecha_creacion , 
		pp.pre_precio , concat(p.nombre , ' (', p.descripcion , ')') as PRODUCTO
from prod_precios pp 
		inner join productos p on(p.codigoproducto = pp.codigoproducto)
where  pp.codigoproducto  = 173 order by pp.id_precio  desc limit 5;


select  cc.id_compra , cc.com_numero_documednto , cc.com_razon_social , cc.com_nrc , cc.com_total ,
DATE_FORMAT(cc.com_fecha_creacion, '%d-%m-%Y') as com_fecha_creacion , p.codigoproducto ,p.nombre , p.descripcion ,
ccd.det_cantidad , ccd.det_precio, ccd.det_sub_total , ccd.id_detalle_compra
from com_compras cc
inner join com_compras_detalle ccd ON (cc.id_compra=ccd.id_compra)
inner join productos p on (p.codigoproducto = ccd.codigoproducto)
where ccd.id_compra =34 order by ccd.id_detalle_compra asc; 

drop table inv_entradas;

create table inv_entradas (
id_entrada int not null primary key auto_increment,
  `en_numero_documento` varchar(15) NOT NULL COMMENT 'Numero del documento',
  `en_comentario` varchar(250)  COMMENT 'comentario',
   en_fecha_creacion datetime NOT NULL DEFAULT current_timestamp(),
   en_total decimal(10,2),
   codigousuario int(10) unsigned  not null
)engine=innodb;

alter table inv_entradas add constraint fk_entradas_kardex foreign key (id_kardex)
references 

drop table inv_entradas_detalle;
create table inv_entradas_detalle(
id_entrada_detalle int not null primary key auto_increment,
codigoproducto int(10) unsigned not null,
 ende_cantidad decimal(10,2) not null,
 ende_precio decimal(10,2) not null,
 ende_sub_total decimal(10,2) not null,
 id_entrada int not null,
 index codigoproducto(codigoproducto),
 index id_entrada(id_entrada)
)engine=innodb;

alter table inv_entradas_detalle add constraint fk_entradadetalle_entradas foreign key (id_entrada)
references inv_entradas(id_entrada) on update cascade;
alter table inv_entradas_detalle add constraint fk_entradadetalle_productos foreign key (codigoproducto)
references productos(codigoproducto) on update cascade;



select ie.id_entrada , ie.en_numero_documento , 
ie.en_comentario, DATE_FORMAT(ie.en_fecha_creacion , '%d-%m-%Y') as en_fecha_creacion ,
ie.en_total , u.nombreusuario , u.nombre 
from inv_entradas ie 
inner join usuarios u on(u.codigousuario = ie.codigousuario);

select ied.id_entrada_detalle , ied.codigoproducto , ied.ende_cantidad , ied.ende_precio , 
ied.ende_sub_total , 
ie.en_numero_documento , DATE_FORMAT(ie.en_fecha_creacion , '%d-%m-%Y') as en_fecha_creacion  , ie.en_total ,
p.nombre , p.descripcion 
from inv_entradas_detalle ied 
inner join inv_entradas ie on(ie.id_entrada = ied.id_entrada)
inner join productos p on(p.codigoproducto = ied.codigoproducto)
where ied.id_entrada = 2 order by ied.id_entrada_detalle asc;



drop table inv_salidas;

create table inv_salidas (
id_salida int not null primary key auto_increment,
  `sa_numero_documento` varchar(15) NOT NULL COMMENT 'Numero del documento',
  `sa_comentario` varchar(250)  COMMENT 'comentario',
   sa_fecha_creacion datetime NOT NULL DEFAULT current_timestamp(),
   sa_total decimal(10,2),
   codigousuario int(10) unsigned  not null
)engine=innodb;

 

drop table inv_salidas_detalle;
create table inv_salidas_detalle(
id_salida_detalle int not null primary key auto_increment,
codigoproducto int(10) unsigned not null,
 salde_cantidad decimal(10,2) not null,
 salde_precio decimal(10,2) not null,
 salde_sub_total decimal(10,2) not null,
 id_salida int not null,
 index codigoproducto(codigoproducto),
 index id_salida(id_salida)
)engine=innodb;

alter table inv_salidas_detalle add constraint fk_salidadetalle_salidas foreign key (id_salida)
references inv_salidas(id_salida) on update cascade;
alter table inv_salidas_detalle add constraint fk_salidadetalle_productos foreign key (codigoproducto)
references productos(codigoproducto) on update cascade;


select isal.id_salida  , isal.sa_numero_documento  , 
isal.sa_comentario , DATE_FORMAT(isal.sa_fecha_creacion  , '%d-%m-%Y') as sa_fecha_creacion ,
isal.sa_total  , u.nombreusuario , u.nombre 
from inv_salidas isal
inner join usuarios u on(u.codigousuario = isal.codigousuario);

select isd.id_salida_detalle  , isd.codigoproducto , isd.salde_cantidad  , isd.salde_precio  , 
isd.salde_sub_total  , 
isa.sa_numero_documento  , DATE_FORMAT(isa.sa_fecha_creacion  , '%d-%m-%Y') as sa_fecha_creacion  , 
isa.sa_total  ,
p.nombre , p.descripcion 
from inv_salidas_detalle isd   
inner join inv_salidas isa  on(isa.id_salida  = isd.id_salida)
inner join productos p on(p.codigoproducto = isd.codigoproducto)
where isd.id_salida  = 5 order by isd.id_salida_detalle  asc;

delete from inv_kardex ;

SELECT kar_saldo FROM inv_kardex WHERE codigoproducto = 257 
ORDER BY kar_fecha_creacion DESC LIMIT 1;

alter table facturacion add id_cliente int;
update facturacion set id_cliente = 1;
ALTER TABLE facturacion MODIFY COLUMN id_cliente int(11) NOT NULL;
alter table facturacion add index id_cliente(id_cliente);
alter table facturacion add constraint fk_facutacion_cliente foreign key(id_cliente)
references fac_cliente(id_cliente) on update cascade;
alter table facturacion add factu_numero_factura varchar(10);
-- alter table facturacion add index estado(estado);

select f.codigofacturacion , DATE_FORMAT(f.fecha  , '%d-%m-%Y') as fecha,
f.nombre_cliente , f.costo ,
u.nombreusuario , u.nombre 
from facturacion f 
inner join usuarios u on(u.codigousuario= f.codigousuario  )
where f.estado =1 order by f.codigofacturacion desc limit 1000 ;


select count(*) from facturacion f where f.estado =1;

select fc.id_cliente , fc.cli_codigo , fc.cli_nombre , fc.cli_direccion , fc.cli_telefono 
from fac_cliente fc where fc.cli_codigo  ;

select p.codigoproducto , p.prod_codigo, p.nombre, p.descripcion,
pt.tipo_nombre 
from productos p 
inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto)

SELECT 
  p.codigoproducto, 
  p.prod_codigo, 
  p.nombre, 
  p.descripcion, 
  pt.tipo_nombre,
  coalesce((SELECT kar_saldo FROM inv_kardex  
  WHERE codigoproducto = p.codigoproducto ORDER BY kar_fecha_creacion DESC LIMIT 1) ,0) AS existencia,
  coalesce((select pre_precio FROM prod_precios 
  WHERE codigoproducto = p.codigoproducto ORDER BY pre_fecha_creacion DESC LIMIT 1), 0) as precio
FROM 
  productos p 
  INNER JOIN prod_tipos pt ON (pt.id_tipo_producto = p.id_tipo_producto)  
WHERE 
  p.codigoproducto = 257 
  
  select fac.id_configuracion , fac.valor_configuracion 
  from ferro_adm_configuraciones fac where fac.id_configuracion = 1;


  select pre_precio FROM prod_precios  
  WHERE codigoproducto = 2065 ORDER BY pre_fecha_creacion DESC LIMIT 1
  
  select * from prod_precios pp 
  
  
  SELECT kar_saldo FROM inv_kardex  
  WHERE codigoproducto = 173 ORDER BY kar_fecha_creacion DESC LIMIT 1
  
  SELECT COALESCE((SELECT kar_saldo FROM inv_kardex WHERE codigoproducto = 173 ORDER BY kar_fecha_creacion DESC LIMIT 1), 0) as existencia;

 
 SELECT 
  p.codigoproducto, 
  p.prod_codigo, 
  p.nombre, 
  p.descripcion, 
  pt.tipo_nombre,
  coalesce((SELECT kar_saldo FROM inv_kardex  
  WHERE codigoproducto = p.codigoproducto ORDER BY kar_fecha_creacion DESC LIMIT 1) ,0) AS existencia
FROM 
  productos p 
  INNER JOIN prod_tipos pt ON (pt.id_tipo_producto = p.id_tipo_producto)  
WHERE 
  p.codigoproducto = 479;
  s
  
SELECT DATE_FORMAT(NOW( ), "%H:%i:%S" );
 select * from prod_precios pp ;
insert into prod_precios (pre_precio, codigoproducto, pre_fecha_creacion)
  select '2.36', codigoproducto , now() from productos p ;
  
 alter table detallefacturacion add codigoproducto int(10) unsigned not null;
 


select d.id_detalle_facturacion, d.codigoabastecimiento, a.codigoproducto  
from detallefacturacion d 
inner join abastecimiento a on(a.codigoabastecimiento = d.codigoabastecimiento)
order by d.id_detalle_facturacion asc;



SET FOREIGN_KEY_CHECKS=0;
SET FOREIGN_KEY_CHECKS=1;

-- ferre_update.facturacion definition
drop table fac_factura;
CREATE TABLE `fac_factura` (
  `id_factura` int  NOT NULL primary key AUTO_INCREMENT,
  `fac_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fac_nombre_cliente` varchar(200) DEFAULT NULL,
  `codigousuario` int(10) unsigned NOT NULL,
  `codigocajero` int(10) unsigned DEFAULT NULL,
  `fac_total` decimal(10,2) NOT NULL,
  `fac_estado` tinyint(1) NOT NULL DEFAULT 0,
  `id_cliente` int(11) NOT NULL,
  `fac_numero_factura` varchar(10) DEFAULT NULL,
  index id_cliente(id_cliente),
  index codigousuario(codigousuario)
 ) ENGINE=InnoDB;

alter table fac_factura add constraint fk_factura_cliente foreign key(id_cliente)
references fac_cliente(id_cliente) on update cascade;
alter table fac_factura add constraint fk_factura_usuario foreign key(codigousuario)
references usuarios(codigousuario) on update cascade;

select * from fac_factura;
insert into fac_factura (id_factura, fac_fecha_creacion, fac_nombre_cliente, codigousuario, codigocajero,
fac_total, fac_estado, id_cliente)
select f.codigofacturacion,  f.fecha , f.nombre_cliente , f.codigousuario , f.codigocajero , f.costo , f.estado , f.id_cliente 
from facturacion f;


drop table fac_factura_detalle;
CREATE TABLE `fac_factura_detalle` (
 `id_factura_detalle` int(11) NOT NULL auto_increment primary key,
  `facde_cantidad` decimal(12,2) NOT NULL,
  `facde_precio_venta` decimal(10,2) NOT NULL,
  `facde_subtotal` decimal(10,2) NOT NULL,
  `id_factura` int(10) NOT NULL,
  codigoproducto int(10) unsigned NOT NULL,
  `codigoabastecimiento` int(10) unsigned NOT NULL,
  index codigoproducto(codigoproducto),
  index id_factura(id_factura)
 ) ENGINE=InnoDB;


insert into fac_factura_detalle(facde_cantidad, facde_precio_venta, facde_subtotal, id_factura, 
codigoproducto, codigoabastecimiento)
select d.cantidad , d.precio_venta , d.subtotal , d.codigofacturacion, 0, d.codigoabastecimiento  
from detallefacturacion d;

alter table fac_factura_detalle add constraint fk_facturadetalle_factura foreign key(id_factura)
references fac_factura(id_factura) on update cascade;

UPDATE fac_factura_detalle d
JOIN abastecimiento a
 on(a.codigoabastecimiento = d.codigoabastecimiento)
SET d.codigoproducto = a.codigoproducto;

alter table fac_factura_detalle add constraint fk_facturadetalle_producto foreign key(codigoproducto)
references productos(codigoproducto) on update cascade;

select * from fac_factura_detalle ffd ;


ALTER TABLE fac_factura_detalle DROP codigoabastecimiento;

select count(id_factura) as REGISTRO_ELIMINADO, id_factura, fac_estado  
from fac_factura where id_factura = 32768;

select * from fac_factura_detalle ffd ;

select  ffd.facde_cantidad, ffd.facde_precio_venta, 
ffd.facde_subtotal, ffd.id_factura, ffd.codigoproducto
from fac_factura_detalle ffd 
inner join  fac_factura ff on(ff.id_factura = ffd.id_factura )
where ffd.id_factura = 32768;

commit;

select * from fac_factura_detalle ffd ;

-- ALTER TABLE `fac_factura_detalle` CHANGE ` id_factura_detalle` `id_factura_detalle` int(11) NOT NULL auto_increment;

select ff.id_factura , ff.fac_fecha_creacion , ff.fac_nombre_cliente , ff.fac_total ,
ff.id_cliente ,
p.codigoproducto , p.nombre , p.descripcion ,
ffd.id_factura_detalle, ffd.facde_cantidad , ffd.facde_precio_venta , ffd.facde_subtotal
from fac_factura ff 
inner join fac_factura_detalle ffd on(ffd.id_factura = ff.id_factura)
inner join productos p on(p.codigoproducto = ffd.codigoproducto)
where ff.id_factura = 327698 and ff.fac_estado  =1 order by ffd.id_factura_detalle asc;

update fac_factura set fac_estado = 1;


select * from inv_kardex ik ;

update inv_kardex set kar_cantidad = 0, kar_saldo = 0;

insert into inv_kardex (kar_fecha_creacion, kar_tipo_transaccion, kar_numero_documento,
kar_cantidad, kar_saldo, id_entrada, codigoproducto)
select now(), 3, '13', 100, 100, 13, codigoproducto  from productos ;


  
alter table cotizacion_detalle add codigoproducto int(10) unsigned NOT null;
alter table cotizacion_detalle add index codigoproducto(codigoproducto);

-- actualizao el comapo codigoproducto
UPDATE cotizacion_detalle d
JOIN abastecimiento a
 on(a.codigoabastecimiento = d.codigoabastecimiento)
SET d.codigoproducto = a.codigoproducto;

-- elimino el constrain a la tabla abastecimiento que ya no es corecto
ALTER TABLE cotizacion_detalle DROP FOREIGN KEY fk_cotizaciondetalle_abastecimiento;
-- elimino el indeci codigoabastacimiento
ALTER TABLE cotizacion_detalle DROP INDEX codigoabastecimiento;
-- elimino el campo codigoabastecimiento
ALTER TABLE cotizacion_detalle DROP COLUMN codigoabastecimiento;


alter table cotizacion_detalle add constraint fk_coitaciondetalle_productos foreign key (codigoproducto)
references productos(codigoproducto) on update cascade;

select c.id_cotizacion , c.numero_cotizacion , 	DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, c.nombre_cliente,
c.terminos_condiciones, 	DATE_FORMAT(c.fecha_ultima_modificacion , '%d-%m-%Y') as fecha_ultima_modificacion,
c.costo ,
cd.id_detalle , cd.cantidad , cd.precio_venta , cd.subtotal,
cd.codigoproducto , p.nombre , p.descripcion,
fc.cli_codigo 
from cotizacion c
inner join cotizacion_detalle cd ON (cd.id_cotizacion = c.id_cotizacion)
inner join productos p on(p.codigoproducto = cd.codigoproducto)
inner join fac_cliente fc on(fc.id_cliente = c.id_cliente)
			where c.id_cotizacion =11 and c.estado = 0 order by cd.id_detalle asc

alter table cotizacion add id_cliente int not null;
alter table cotizacion add index id_cliente(id_cliente);
update cotizacion set id_cliente = 1;
alter table cotizacion add constraint fk_cotizacion_cliente foreign key (id_cliente)
references fac_cliente(id_cliente) on update cascade;


alter table fac_factura add id_cotizacion int;

update cotizacion set estado = 1 where id_cotizacion = 1

SELECT `c`.`id_cotizacion`, `c`.`numero_cotizacion`, DATE_FORMAT(c.fecha, '%d-%m-%Y') as fecha, `c`.`nombre_cliente`, `c`.`costo`, `c`.`terminos_condiciones`, DATE_FORMAT(c.fecha_ultima_modificacion, '%d-%m-%Y %H:%i:%s') as fecha_ultima_modificacion
FROM `cotizacion` `c`
WHERE `c`.`estado` = 0
OR `c`.`numero_cotizacion` like '%2210-333%'
OR `c`.`nombre_cliente` like '%2210-333%'
ORDER BY `c`.`nombre_cliente` asc
 LIMIT 10
 
 UPDATE cotizacion c 
JOIN fac_factura f 
ON c.id_cotizacion  = f.id_cotizacion
SET c.estado  = 1 where c.id_cotizacion = 200;


select u.codigousuario , u.nombreusuario, u.nombre,
		amou.tiene_permiso, amou.agregar, amou.eliminar, amou.actualizar,
		amo.id_modulo_opcion , amo.nombre_opcion, amo.link,amo.opcion_orden ,
		am.id_modulo, am.nombre_modulo, am.fa_menu 
		from usuarios u 
		inner join adm_modulo_opcion_usuario amou on (amou.id_usuario = u.codigousuario)
		inner join adm_modulo_opcion amo on(amo.id_modulo_opcion = amou.id_modulo_opcion)
		inner join adm_modulo am on (am.id_modulo = amo.id_modulo)
		where amou.id_usuario = 1 and amo.opcion_estado  = 1 order by am.id_modulo , amo.opcion_orden asc;
		
alter table adm_modulo_opcion add opcion_orden  tinyint(1) NOT null;

CREATE TABLE `adm_departamento` (
  `id_departamento` tinyint(2) NOT NULL AUTO_INCREMENT COMMENT 'llave primaria incremental',
  `departamento_nombre` varchar(150) NOT NULL COMMENT 'nombreo o descripcion del departamento',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_departamento`)
) ENGINE=InnoDB;

CREATE TABLE `adm_municipio` (
  `id_municipio` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'llave primaria',
  `municipio_nombre` varchar(150) NOT NULL COMMENT 'nombre o descripcion del municipio',
  `id_departamento` tinyint(2) NOT NULL COMMENT 'llave foranea para relacionar con la tabla adm_departamento, indice',
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id_municipio`),
  KEY `id_departamento` (`id_departamento`),
  CONSTRAINT `fk_municipio_departamento` FOREIGN KEY (`id_departamento`) REFERENCES `adm_departamento` (`id_departamento`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

insert into adm_departamento
select * from db_crudci4.adm_departamento ;

insert into adm_municipio
select * from db_crudci4.adm_municipio ;

select ad.id_departamento , ad.departamento_nombre  from adm_departamento ad 
order by ad.id_departamento asc;


select * from fac_cliente fc ;

alter table fac_cliente 
add column cli_razon_social varchar(125) not null after cli_telefono, 
add column cli_nombre_comercial varchar(125) after cli_razon_social,
add column cli_nrc varchar(8) NOT NULL COMMENT 'numero de registro del contribuyente' after cli_nombre_comercial,
add column cli_nit varchar(17) NOT NULL COMMENT 'numero de identificacion tributaria' after cli_nrc,
add column cli_dui varchar(10) after cli_nit,
add column cli_estado tinyint(1) NOT NULL DEFAULT 1 after  cli_dui;

alter table fac_cliente  add id_municipio int not null;
alter table fac_cliente  add index id_municipio(id_municipio);
update  fac_cliente set id_municipio = 193;
alter table fac_cliente add constraint fk_cliente_municipio foreign key (id_municipio)
references adm_municipio(id_municipio) on update cascade;

select id_cliente, cli_codigo, cli_nombre, cli_direccion, 
cli_telefono, cli_razon_social, cli_nombre_comercial, 
cli_dui, cli_nit, cli_nrc,
am.id_municipio , am.municipio_nombre , 
ad.id_departamento , ad.departamento_nombre 
from fac_cliente fc 
inner join adm_municipio am ON (am.id_municipio=fc.id_municipio)
inner join adm_departamento ad on(ad.id_departamento= am.id_departamento)
where id_cliente = 10;


select count(id_cliente) as CUENTA from fac_cliente fc where fc.id_cliente = 1000;

alter table com_proveedor  add id_municipio int not null;
alter table com_proveedor  add index id_municipio(id_municipio);
update  com_proveedor set id_municipio = 193;
alter table com_proveedor add constraint fk_proveedor_municipio foreign key (id_municipio)
references adm_municipio(id_municipio) on update cascade;

select p.id_proveedor, p.pro_codigo, p.pro_razon_social, p.pro_nombre_comercial,
		p.pro_nrc, p.pro_nit, p.pro_dui, p.pro_direccion, p.pro_telefono,
		am.id_municipio , am.municipio_nombre , 
		ad.id_departamento , ad.departamento_nombre 
from com_proveedor p
inner join adm_municipio am on(am.id_municipio = p.id_municipio)
inner join adm_departamento ad on(ad.id_departamento = am.id_departamento)
where id_proveedor  = 9;


select sum(costo) as bruto
     from facturacion where date(fecha)='2023-03-06';
     
 select sum(preciounitario*detallefacturacion.cantidad) 
 from abastecimiento, detallefacturacion, facturacion 
 where abastecimiento.codigoabastecimiento=detallefacturacion.codigoabastecimiento 
   and detallefacturacion.codigofacturacion=facturacion.codigofacturacion 
     and date(facturacion.fecha)='2023-03-06' ;
     
    SELECT kar_saldo FROM inv_kardex WHERE codigoproducto = 257 
ORDER BY kar_fecha_creacion DESC LIMIT 1;

select sum(ccd.det_precio * ffd.facde_cantidad)
from
		inv_kardex ik 
		inner join com_compras cc on(cc.id_compra = ik.id_compra)
		inner join com_compras_detalle ccd on(ccd.id_compra = cc.id_compra)
		inner join productos p on(p.codigoproducto = ik.codigoproducto)
		inner join fac_factura_detalle ffd on(ffd.codigoproducto = p.codigoproducto)
		inner join fac_factura ff on(ff.id_factura= ffd.id_factura)
		where date(ff.fac_fecha_creacion) ='2023-03-06'; -- ik.codigoproducto= 257
		-- order by ik.kar_fecha_creacion desc limit 1
		
		
select * from fac_factura ff where date(ff.fac_fecha_creacion) ='2023-03-06';


select sum(ccd.det_precio * ffd.facde_cantidad)
from  com_compras cc 
inner join com_compras_detalle ccd on (ccd.id_compra = cc.id_compra)
inner join productos p on(p.codigoproducto = ccd.codigoproducto)
inner join fac_factura_detalle ffd on(ffd.codigoproducto = p.codigoproducto)
inner join fac_factura ff on(ff.id_factura= ffd.id_factura)
where date(ff.fac_fecha_creacion) ='2023-03-06'

SELECT
    DATE(ff.fac_fecha_creacion) AS fecha,
    SUM(ffd.facde_cantidad * ffd.facde_precio_venta  - ccd.det_cantidad  * ccd.det_precio) AS utilidad
FROM fac_factura ff
join fac_factura_detalle ffd  ON ffd.id_factura  = ff.id_factura 
JOIN productos p ON p.codigoproducto = ffd.codigoproducto 
join com_compras_detalle ccd   ON ccd.codigoproducto = p.codigoproducto
JOIN com_compras cc ON cc.id_compra = ccd.id_compra
WHERE DATE(ff.fac_fecha_creacion) = '2023-03-06'
GROUP BY DATE(ff.fac_fecha_creacion)


SELECT
    DATE(ff.fac_fecha_creacion) AS fecha,
    SUM(ffd.facde_cantidad * ffd.facde_precio_venta - ccd.det_cantidad * ccd.det_precio) AS utilidad
FROM fac_factura ff
JOIN fac_factura_detalle ffd ON ffd.id_factura = ff.id_factura 
JOIN productos p ON p.codigoproducto = ffd.codigoproducto 
JOIN com_compras_detalle ccd ON ccd.codigoproducto = p.codigoproducto
JOIN com_compras cc ON cc.id_compra = ccd.id_compra
WHERE DATE(ff.fac_fecha_creacion) = '2023-03-06'
GROUP BY DATE(ff.fac_fecha_creacion);


SELECT
    DATE(ff.fac_fecha_creacion) AS fecha,
    SUM(ffd.facde_cantidad * ffd.facde_precio_venta - ccd.det_cantidad * ccd.det_precio) AS utilidad
FROM fac_factura_detalle ffd
JOIN fac_factura ff ON ff.id_factura = ffd.id_factura
JOIN productos p ON p.codigoproducto = ffd.codigoproducto
JOIN com_compras_detalle ccd ON ccd.codigoproducto = p.codigoproducto
JOIN com_compras cc ON cc.id_compra = ccd.id_compra AND cc.com_fecha_creacion >= '2023-03-06'
WHERE DATE(ff.fac_fecha_creacion) = '2023-03-06'
GROUP BY DATE(ff.fac_fecha_creacion)


SELECT
    DATE(ff.fac_fecha_creacion) AS fecha,
    SUM(ffd.facde_cantidad * ffd.facde_precio_venta - 
        (SELECT COALESCE(SUM(ccd.det_cantidad * ccd.det_precio), 0)
         FROM com_compras_detalle ccd
         JOIN com_compras cc ON ccd.id_compra = cc.id_compra
         WHERE ccd.codigoproducto = ffd.codigoproducto
           AND cc.com_fecha_creacion <= ff.fac_fecha_creacion)
       ) AS utilidad
FROM fac_factura ff
JOIN fac_factura_detalle ffd ON ffd.id_factura = ff.id_factura 
JOIN productos p ON p.codigoproducto = ffd.codigoproducto 
WHERE DATE(ff.fac_fecha_creacion) = '2023-03-06'
GROUP BY DATE(ff.fac_fecha_creacion);


SELECT
    DATE_FORMAT(ff.fac_fecha_creacion, '%d-%m-%Y')  AS fecha,
    SUM(ffd.facde_cantidad * ffd.facde_precio_venta - ffd.facde_cantidad * (
        SELECT det_precio FROM com_compras_detalle
        WHERE codigoproducto = ffd.codigoproducto
        ORDER BY id_detalle_compra DESC LIMIT 1
    )) AS utilidad,
    SUM(ffd.facde_cantidad * (
        SELECT det_precio FROM com_compras_detalle
        WHERE codigoproducto = ffd.codigoproducto
        ORDER BY id_detalle_compra DESC LIMIT 1
    )) AS costo_verdadero,
    SUM(ffd.facde_cantidad * ffd.facde_precio_venta) AS venta_total
FROM fac_factura ff
JOIN fac_factura_detalle ffd ON ffd.id_factura = ff.id_factura
WHERE DATE(ff.fac_fecha_creacion) >= '2023-03-01' and  DATE(ff.fac_fecha_creacion) <= '2023-03-06'
GROUP BY DATE(ff.fac_fecha_creacion);



select DATE_FORMAT(ik.kar_fecha_creacion, '%d-%m-%Y') as kar_fecha_creacion , ik.kar_tipo_transaccion,
		ccd.det_cantidad , ccd.det_precio, ik.codigoproducto , concat(p.nombre , ' (', p.descripcion , ')') as PRODUCTO
from inv_kardex ik 
		inner join com_compras cc on(cc.id_compra = ik.id_compra)
		inner join com_compras_detalle ccd on(ccd.id_compra = cc.id_compra and ik.codigoproducto = ccd.codigoproducto)
		inner join productos p on(p.codigoproducto = ik.codigoproducto)
where ik.codigoproducto = 2069
order by ik.kar_fecha_creacion desc;

SELECT `fac`.`id_configuracion`, `fac`.`valor_configuracion`
FROM `ferro_adm_configuraciones` `fac`
WHERE `fac`.`id_configuracion` `in` = :fac.id_configuracion in:


select u.codigousuario , u.nombreusuario , u.nombre  from usuarios u ;

select ff.id_factura , DATE_FORMAT(ff.fac_fecha_creacion, '%d-%m-%Y %H:%i:%s') fac_fecha_creacion, ff.fac_total  ,
u.nombreusuario
from fac_factura ff  
inner join usuarios u on(u.codigousuario = ff.codigousuario)
where date(ff.fac_fecha_creacion)>= '2023-03-01' 
and date(ff.fac_fecha_creacion)<= '2023-03-07'
and ff.codigocajero=? 

select u.codigousuario , u.nombreusuario, u.tipousuario 
from usuarios u where nombreusuario  = 'josalalvr';
order by ff.id_factura  asc

SELECT ik.codigoproducto, SUM(ik.kar_saldo) AS existencia,
 p.prod_codigo , p.nombre , p.descripcion, ptu.tipo_unidad_nombre, pt.tipo_nombre 
FROM inv_kardex ik 
inner join productos p on(p.codigoproducto = ik.codigoproducto)
inner join prod_tipo_unidad ptu on(ptu.id_tipo_unidad = p.id_tipo_unidad)
inner join prod_tipos pt on(pt.id_tipo_producto = p.id_tipo_producto)
GROUP BY ik.codigoproducto
HAVING existencia >= 0 order by p.nombre asc;

select DATE_FORMAT(pp.pre_fecha_creacion , '%d-%m-%Y') as pre_fecha_creacion , 
		pp.pre_precio , concat(p.nombre , ' (', p.descripcion , ')') as PRODUCTO
from 
prod_precios pp 
		inner join productos p on(p.codigoproducto = pp.codigoproducto)
	where pp.codigoproducto =173
	order by pp.id_precio desc
	limit 5;
	
create table adm_tipos_usuario(
id_tipo_usuario smallint(6) not null primary key auto_increment,
tipousu_nombre varchar(25) not null,
tipousu_estado tinyint(1) not null default 1, 
tipousu_fecha_creacion timestamp NOT NULL DEFAULT current_timestamp(),
codigousuario int(10) unsigned not null,
index codigousuario(codigousuario)
)
engine=innodb;

select ut.id_tipo_usuario , ut.tipousu_nombre , DATE_FORMAT(ut.tipousu_fecha_creacion  , '%d-%m-%Y') as 
fecha_creacion ,
ut.codigousuario from adm_tipos_usuario ut ;
insert into adm_tipos_usuario(tipousu_nombre, codigousuario)
values ('Administrador', 1), ('Cajero', 1), ('Vendedor', 1);

update usuarios_tipos set codigousuario = 1;

alter table adm_tipos_usuario add constraint fk_tipousuario_usuarios foreign key(codigousuario) 
references usuarios(codigousuario) on update cascade;

ALTER TABLE ferre_update.usuarios CHANGE tipousuario id_tipo_usuario SMALLINT(6) NOT NULL COMMENT '1= administrador, 2= cajero, 3= vendedor';
ALTER TABLE ferre_update.usuarios MODIFY COLUMN id_tipo_usuario SMALLINT(6) NOT NULL COMMENT '1= administrador, 2= cajero, 3= vendedor';

alter table usuarios add index id_tipo_usuario(id_tipo_usuario);

alter table usuarios add constraint fk_usuarios_tiposusuarios foreign key(id_tipo_usuario) 
references adm_tipos_usuario(id_tipo_usuario);

ALTER TABLE ferre_update.usuarios MODIFY COLUMN telefono VARCHAR(9) NULL;


select u.codigousuario, u.nombreusuario, u.nombre, u.id_tipo_usuario,u.direccion,u.telefono, tipou.tipousu_nombre
from usuarios u
		inner join adm_tipos_usuario tipou on(tipou.id_tipo_usuario  = u.id_tipo_usuario)
where u.codigousuario = 20


SELECT 
   DATE_FORMAT(kar_fecha_creacion  , '%d-%m-%Y') AS fecha, 
  case kar_tipo_transaccion
  	when 1 then 'Compra'
  	when 2 then 'Venta'
  	when 3 then 'Entrada al inventario'
  	when 4 then 'Salida del inventario' 
  end AS tipo, 
  kar_numero_documento AS numero, 
  kar_cantidad AS cantidad,  
  kar_saldo AS saldo 
FROM 
  inv_kardex ik  
WHERE 
  codigoproducto =  2065 and kar_fecha_creacion >= '2023-03-01' and kar_fecha_creacion <= '2023-03-11'
ORDER BY 
  kar_fecha_creacion  ASC

  
  SELECT
  DAYNAME(ff.fac_fecha_creacion) AS dia,
  WEEK(ff.fac_fecha_creacion) AS semana,
  MONTHNAME(ff.fac_fecha_creacion) AS mes,
  SUM(ff.fac_total) AS ventas
FROM fac_factura ff 
WHERE ff.fac_fecha_creacion >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) AND ff.fac_fecha_creacion <= CURDATE()
GROUP BY dia, semana, mes
ORDER BY semana ASC, FIELD(dia, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo') asc;


SELECT DATE_FORMAT(fac_fecha_creacion, '%W') AS dia_semana, 
CASE DAYNAME(fac_fecha_creacion)
	WHEN 'Sunday' THEN  'DOMINGO'
	WHEN 'Monday' THEN	'LUNES'
	WHEN 'Tuesday' THEN	'MARTES'
	WHEN 'Wednesday' THEN 'MIERCOLES'
	WHEN 'Thursday' THEN 'JUEVES'
	WHEN 'Friday' THEN	'VIERNES'
	WHEN 'Saturday' THEN	'SABADO'
 END AS NOMBRE_DIA_ESPANIOL,
DATE(fac_fecha_creacion) AS fecha, SUM(fac_total) AS total_ventas
FROM fac_factura ff 
WHERE fac_fecha_creacion BETWEEN DATE_ADD(CURDATE(), INTERVAL(1-DAYOFWEEK(CURDATE())) DAY) 
AND DATE_ADD(CURDATE(), INTERVAL(7-DAYOFWEEK(CURDATE())) DAY)
GROUP BY fecha;



SELECT DATE_FORMAT(fac_fecha_creacion, '%W') AS dia_semana, CASE DAYNAME(fac_fecha_creacion)
		WHEN 'Sunday' THEN  'DOMINGO'
		WHEN 'Monday' THEN	'LUNES'
		WHEN 'Tuesday' THEN	'MARTES'
		WHEN 'Wednesday' THEN 'MIERCOLES'
		WHEN 'Thursday' THEN 'JUEVES'
		WHEN 'Friday' THEN	'VIERNES'
		WHEN 'Saturday' THEN	'SABADO'
		END AS NOMBRE_DIA_ESPANIOL, DATE(fac_fecha_creacion) AS fecha, SUM(fac_total) AS total_ventas
FROM `fac_factura`
WHERE `fac_fecha_creacion` BETWEEN = :fac_fecha_creacion BETWEEN:
AND DATE_ADD(CURDATE(), INTERVAL(7-DAYOFWEEK(CURDATE())) DAY)
GROUP BY `fecha`

SELECT ff.codigousuario , SUM(ff.fac_total) AS ventas_mes_actual,
u.nombreusuario 
FROM fac_factura ff 
inner join usuarios u on(u.codigousuario = ff.codigousuario)
WHERE MONTH(ff.fac_fecha_creacion) = MONTH(NOW())
AND YEAR(ff.fac_fecha_creacion) = YEAR(NOW())
GROUP BY ff.codigousuario ;


SELECT `ff`.`codigousuario`, SUM(ff.fac_total) AS ventas_mes_actual, `u`.`nombreusuario`
FROM FROM fac_factura ff 
		inner join usuarios u on(u.codigousuario = ff.codigousuario)
WHERE MONTH(ff.fac_fecha_creacion) = MONTH(NOW())
AND YEAR(ff.fac_fecha_creacion) = YEAR(NOW())
GROUP BY `ff`.`codigousuario`
