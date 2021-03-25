ALTER TABLE boncde_entete DROP FOREIGN KEY fk_status_id;
ALTER TABLE boncde_entete DROP INDEX fk_status_id;
ALTER TABLE boncde_entete DROP COLUMN statusId;
ALTER TABLE boncde_entete DROP COLUMN dateStatus;

ALTER TABLE bonrec_materiel DROP FOREIGN KEY fk_bonrec_status_id;
ALTER TABLE bonrec_materiel DROP INDEX fk_bonrec_status_id;
ALTER TABLE bonrec_materiel DROP COLUMN statusId;
ALTER TABLE bonrec_materiel DROP COLUMN dateStatus;

DROP TABLE orderStatus;