CREATE TABLE orderStatus
(
	id INT(6) AUTO_INCREMENT PRIMARY KEY,
	label VARCHAR(50) NOT NULL,
	sapStatus VARCHAR(2)
);

ALTER TABLE boncde_entete ADD COLUMN statusId INT(6) DEFAULT NULL;
ALTER TABLE boncde_entete ADD CONSTRAINT fk_status_id FOREIGN KEY (statusId) REFERENCES orderStatus(id);
ALTER TABLE boncde_entete ADD COLUMN dateStatus datetime DEFAULT NULL;

ALTER TABLE bonrec_materiel ADD COLUMN statusId INT(6) DEFAULT NULL;
ALTER TABLE bonrec_materiel ADD CONSTRAINT fk_bonrec_status_id FOREIGN KEY (statusId) REFERENCES orderStatus(id);
ALTER TABLE bonrec_materiel ADD COLUMN dateStatus datetime DEFAULT NULL;