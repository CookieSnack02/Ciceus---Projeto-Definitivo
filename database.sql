CREATE TABLE ciceus (
    idCiceus INT PRIMARY KEY AUTO_INCREMENT, 
    nmUsuario VARCHAR(255) NOT NULL, 
    emailUsuario VARCHAR(255) NOT NULL UNIQUE, 
    senhaUsuario VARCHAR(255) NOT NULL,
    dtCriacaoUsuario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    telefoneUsuario VARCHAR(20) NOT NULL,
    sxUsuario CHAR(1) NOT NULL, 
    dtNasUsuario DATE NOT NULL,
    codPasta INT 

);

CREATE TABLE pasta (
    codPasta INT PRIMARY KEY AUTO_INCREMENT, 
    nmPasta VARCHAR(255) NOT NULL, 
    corPasta VARCHAR(1), 
    dtCriacaoPasta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    idCiceus INT,



);

CREATE TABLE notas (
    idNotas INT PRIMARY KEY AUTO_INCREMENT, 
    tituloNota VARCHAR(255) NOT NULL, 






);




CREATE TABLE quadro (

)

CREATE TABLE questao (

)

CREATE TABLE gabarito (

)

CREATE TABLE timer (

)



