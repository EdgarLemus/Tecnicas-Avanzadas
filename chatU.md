CREATE KEYSPACE chatU WITH replication = {'class':'SimpleStrategy', 'replication_factor':1};
USE chatU;

// Q1:
CREATE TABLE usuarios (loguinusuario TEXT, idusuario INT, dsusuario TEXT, fechaingreso TIMESTAMP, PRIMARY KEY (loguinusuario,idusuario,dsusuario,fechaingreso)) WITH CLUSTERING ORDER BY (idusuario ASC, dsusuario ASC, fechaingreso ASC);

/* SELECT usuarios_loguinusuario, idusuario, dsusuario, usuarios_loguinusuario, fechaingreso FROM usuarios WHERE usuarios_loguinusuario=? ORDER BY idusuario ASC, dsusuario ASC, usuarios_loguinusuario ASC, fechaingreso ASC; */

// Q2:
CREATE TABLE usuarios_has_grupos (usuarios_idusuario INT, grupos_idgrupo INT, principal TEXT, PRIMARY KEY (usuarios_idusuario,grupos_idgrupo,principal)) WITH CLUSTERING ORDER BY (grupos_idgrupo ASC, principal ASC);

/* SELECT usuarios_has_grupos_usuarios_idusuario, usuarios_has_grupos_usuarios_idusuario, usuarios_has_grupos_grupos_idgrupo, principal FROM usuarios_has_grupos WHERE usuarios_has_grupos_usuarios_idusuario=? ORDER BY usuarios_has_grupos_usuarios_idusuario ASC, usuarios_has_grupos_grupos_idgrupo ASC, principal ASC; */

// Q3:
CREATE TABLE grupos (idgrupo INT, dsgrupo TEXT, PRIMARY KEY (idgrupo));

/* SELECT dsgrupo FROM grupos WHERE idgrupo=?; */

// Q4:
CREATE TABLE grupos_has_eventos (grupos_idgrupo INT, eventos_idevento INT, PRIMARY KEY (grupos_idgrupo));

/* SELECT grupos_has_eventos_eventos_idevento FROM grupos_has_eventos WHERE grupos_has_eventos_grupos_idgrupo=?; */

// Q5:
CREATE TABLE eventos (idevento INT, dsevento TEXT, fechaevento TIMESTAMP, asistencias INT, PRIMARY KEY (idevento,dsevento,fechaevento,asistencias)) WITH CLUSTERING ORDER BY (dsevento ASC, fechaevento ASC, asistencias ASC);

/* SELECT eventos_idevento, eventos_idevento, dsevento, eventos_fecha, asistencias FROM eventos WHERE eventos_idevento=? ORDER BY eventos_idevento ASC, dsevento ASC, eventos_fecha ASC, asistencias ASC; */

// Q6:
CREATE TABLE usuarios_has_eventos (usuarios_idusuario INT, eventos_idevento INT, PRIMARY KEY (usuarios_idusuario));

/* SELECT usuarios_has_eventos_eventos_idevento FROM usuarios_has_eventos WHERE usuarios_has_eventos_usuarios_idusuario=?; */

// Q7:
CREATE TABLE comentarios (idcomentario INT, usuarios_idusuario INT, grupos_idgrupo INT, dscomentario TEXT, fecha TIMESTAMP, likes INT, PRIMARY KEY ((idcomentario,usuarios_idusuario,grupos_idgrupo),dscomentario,fecha,likes)) WITH CLUSTERING ORDER BY (dscomentario ASC, fecha ASC, likes ASC);

/* SELECT comentarios_grupos_idgrupo, idcomentario, dscomentario, comentarios_fecha, likes FROM comentarios WHERE comentarios_usuarios_idusuario=? ORDER BY comentarios_grupos_idgrupo ASC, idcomentario ASC, dscomentario ASC, comentarios_fecha ASC, likes ASC; */

