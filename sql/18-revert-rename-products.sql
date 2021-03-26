ALTER TABLE produit_had DROP COLUMN otherLabel;
UPDATE produit_had SET isDeleted = 0 where lb_produit like '%FAUTEUIL DE REPOS SANS ROULETTES%';
