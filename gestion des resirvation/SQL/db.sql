CREAT DATABASE gestion_resirvation;
USE gestion_resirvation;

CREAT TABLE users (
   id int PRIMERY KEY AUTO_INCRIMENT,
   name VARCHAR(200),
   email VARCHAR(200) NOT NULL UNIQUE,
   contact VARCHAR(100)
)ENGINE=INNODB;

CREAT TABLE admins (
   id int PRIMERY KEY ,
   expercience VARCHAR(100),
   FORINGE KEY (id) REFERENCE users(id)
)ENGINE=INNODB;

CREAT TABLE membres (
   id int PRIMERY KEY ,
   vielle VARCHAR(100),
   FORINGE KEY (id) REFERENCE users(id)
)ENGINE=INNODB;

CREAT TABLE auteurs (
   id int PRIMERY KEY AUTO_INCRIMENT,
   name VARCHAR(200),
   email VARCHAR(200) NOT NULL UNIQUE,
   contact VARCHAR(100)
)ENGINE=INNODB;

CREAT TABLE categores (
   id int PRIMERY KEY AUTO_INCRIMENT,
   name VARCHAR(200)
)ENGINE=INNODB;

CREAT TABLE livres (
   id int PRIMERY KEY AUTO_INCRIMENT,
   titre VARCHAR(200),
   date_creation date,
   auteur_id int ,
   FORINGE KEY (auteur_id) REFERENCE auteurs(id) DELETE EN CASCADE,
   categore_id int ,
   FORINGE KEY (categore_id) REFERENCE categores(id)
)ENGINE=INNODB;

CREAT TABLE resirvations (
   id int PRIMERY KEY AUTO_INCRIMENT,
   date_reservation date,
   date_reteur date,
   membre_id int ,
   FORINGE KEY (membre_id) REFERENCE membres(id),
   livre_id int ,
   FORINGE KEY (livre_id) REFERENCE livres(id)
)ENGINE=INNODB;