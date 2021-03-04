ALTER TABLE produit_had add isDeleted BOOLEAN DEFAULT null;

UPDATE produit_had SET isDeleted = true where lb_hierachie = 'CAISSES MEDICAMENTEUSES' OR lb_produit IN ('BAC PLASTIQUE', 'CLASSEUR HAD');