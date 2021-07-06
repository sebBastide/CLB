<?php

class dataTransformCtrl extends Controller
{
    private $boncde_entete;
    private $boncde_poste;
    private $bonrec_material;
    private $bonrec_poste;
    private $client_had;
    private $patient_had;
    private $produit_had;
    private $raison_had;
    private $utilisateur;

    public function __construct() {
        parent::__construct();
        $this->boncde_entete = new dbtable('boncde_entete');
        $this->boncde_poste = new dbtable('boncde_poste');
        $this->bonrec_material = new dbtable('bonrec_material');
        $this->bonrec_poste = new dbtable('bonrec_poste');
        $this->client_had = new dbtable('client_had');
        $this->patient_had = new dbtable('patient_had');
        $this->produit_had = new dbtable('produit_had');
        $this->raison_had = new dbtable('raison_had');
        $this->utilisateur = new dbtable('UTILISATEURS');
    }

    public function defaut() {
        $this->transformData();
    }

    private function transformData() {
        ini_set('memory_limit', '1024M');

        if (!is_dir('../dataTransform')) {
            mkdir('../dataTransform');
        }

        $filePath = '../dataTransform/dataTransform.sql';

        if (file_exists($filePath)) {
            $unlink = unlink($filePath);
            if ($unlink === false) {
                var_dump('Echec de la suppression');
                return;
            }
        }

        $request = 'SELECT @instanceId := id FROM instance WHERE sap_id = \'0000021832\';' .PHP_EOL;
        file_put_contents($filePath, $request, FILE_APPEND);

        $getUuid = 'UUID_TO_BIN(uuid(), 1)';

        //Insert user
        $userData = $this->utilisateur->query('SELECT * FROM UTILISATEURS WHERE coduti != \'VVEYET\' AND coduti != \'FGOY\' ;');
        if (count($userData) > 0) {
            $baseRequest = 'INSERT INTO user (id, email, roles, password, instance_id, login, firstname, lastname, active) VALUES (';
            foreach ($userData as $user) {
                $request = $baseRequest . $this->getRequestValue($getUuid, false) . $this->getRequestValue(($user['mail'] === '' ? $user['coduti'].'@test.fr' : $user['mail'])) . $this->getRequestValue('["ROLE_USER"]') . $this->getRequestValue('') . $this->getRequestValue('@instanceId', false) . $this->getRequestValue($user['coduti']) . $this->getRequestValue($user['prenom']) . $this->getRequestValue($user['nom']) . $this->getRequestValue($user['statut'] === 'A' ? 1 : 0, false, true) . ');' . PHP_EOL;
                file_put_contents($filePath, $request, FILE_APPEND);
            }
        }

        //Insert items
        $itemData = $this->produit_had->query('SELECT * FROM produit_had WHERE lb_hierachie <> \'\' AND lb_hierachie <> \'AUTRES\';');
        if (count($itemData) > 0) {
            $baseRequest = 'INSERT INTO item_category (id, label) VALUES ';
            $request = $baseRequest . '(' . $getUuid . ',\'MAD\'), ('. $getUuid .',\'RESPIRATOIRE\'), (' . $getUuid . ',\'NUTRITION\'), (' . $getUuid . ',\'PERFUSION\'), (' . $getUuid . ',\'DIVERS\'), (' . $getUuid . ',\'CAISSES MEDICAMENTEUSES\');' . PHP_EOL;
            file_put_contents($filePath, $request, FILE_APPEND);

            $baseRequest = 'INSERT INTO item (id, item_category_id, item_report_category_id, instance_id, item_sap_id, label, alternative_label, active) VALUES (';
            foreach ($itemData as $item) {
                file_put_contents($filePath, $this->getItemCategoryId($item['lb_hierachie']), FILE_APPEND);
                $request = $baseRequest . $this->getRequestValue($getUuid, false) . $this->getRequestValue('@itemCategoryId', false) . $this->getRequestValue('NULL', false) . $this->getRequestValue('@instanceId', false) . $this->getRequestValue((strlen($item['sk_produit']) > 2 ? $item['sk_produit'] : '')) . $this->getRequestValue($item['lb_produit']) . $this->getRequestValue($item['otherLabel']) . $this->getRequestValue((empty($item['isDeleted']) ? '1' : '0'), false, true) . ');' . PHP_EOL;
                file_put_contents($filePath, $request, FILE_APPEND);
            }
        }

        //Insert patients
        $patientData = $this->patient_had->query('SELECT * FROM patient_had;');
        if (count($patientData) > 0) {
            $request = '';

            foreach ($patientData as $patient) {
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('@instanceId', false) . $this->getRequestValue($patient['lb_nom']) . $this->getRequestValue(empty(trim($patient['dt_naissance'])) ? 'NULL' : DateTime::createFromFormat('d/m/Y', trim($patient['dt_naissance']))->format('Y-m-d')) . $this->getRequestValue($patient['lb_ville']) . $this->getRequestValue($patient['lb_codepostal']) . $this->getRequestValue($patient['lb_titre']) . $this->getRequestValue($patient['lb_nom2']) . $this->getRequestValue($patient['lb_adresse']) . $this->getRequestValue($patient['other_coordinates']) . $this->getRequestValue($patient['contact']) . $this->getRequestValue($patient['lb_telephone']) . $this->getRequestValue($patient['sk_patient']) . $this->getRequestValue(($patient['statut'] === 'A' ? 1 : 0), false) . $this->getRequestValue($patient['ext_patient']) . $this->getRequestValue($patient['lb_nomjf'], true, true) . '),';
            }
            $baseRequest = 'INSERT INTO patient (id, instance_id, name, birth_date, city, zip_code, civility, additional_name, address, additional_address, contact, phone, sap_id, active, external_id, maiden_name) VALUES ' . mb_substr($request, 0, -1) . ';';

            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);
        }

        //Insert orders
        $orderData = $this->boncde_entete->query('SELECT * FROM boncde_entete WHERE lieliv <> \'S\';');
        $request = '';
        if (count($orderData) > 0) {
            foreach ($orderData as $order) {
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('@instanceId', false) . $this->getRequestValue($order['numcde']) . $this->getRequestValue($order['numcdesap']) . $this->getRequestValue($this->getSqlDateFormat($order['datdem'])) . $this->getRequestValue($this->getSqlDateFormat($order['datliv'])) . $this->getRequestValue('(SELECT address FROM patient WHERE external_id =\''.trim($order['numpat']).'\')', false) . $this->getRequestValue('(SELECT city FROM patient WHERE external_id =\''.trim($order['numpat']).'\')', false) . $this->getRequestValue('(SELECT zip_code FROM patient WHERE external_id =\''.trim($order['numpat']).'\')', false) . $this->getRequestValue('(SELECT additional_address FROM patient WHERE external_id =\''.trim($order['numpat']).'\')', false) . $this->getRequestValue($order['com']) . $this->getRequestValue(0, false) . $this->getRequestValue('(SELECT id FROM patient WHERE external_id =\''.trim($order['numpat']).'\')', false) . $this->getRequestValue('(SELECT id FROM user WHERE login =\''.trim($order['creuti']).'\')', false) . $this->getRequestValue('NULL', false) . $this->getRequestValue('(SELECT phone FROM patient WHERE external_id =\''.trim($order['numpat']).'\')', false, true) . '),';
            }
            $baseRequest = 'INSERT INTO `order` (id, instance_id, reference, sap_id, date, delivery_date, address, city, zip_code, additional_address, comment, type, patient_id, user_id, order_recovery_detail_id, phone) VALUES ' . mb_substr($request, 0, -1) . ';';
            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);
        }

        $orderHadData = $this->boncde_entete->query('SELECT * FROM boncde_entete WHERE lieliv = \'S\';');
        $request = '';
        if (count($orderHadData) > 0) {
            foreach ($orderHadData as $orderHad) {
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('@instanceId', false) . $this->getRequestValue($orderHad['numcde']) . $this->getRequestValue($orderHad['numcdesap']) . $this->getRequestValue($this->getSqlDateFormat($orderHad['datdem'])) . $this->getRequestValue($this->getSqlDateFormat($orderHad['datliv'])) . $this->getRequestValue('(SELECT address FROM instance WHERE id = @instanceId)', false) . $this->getRequestValue('(SELECT city FROM instance WHERE id = @instanceId)', false) . $this->getRequestValue('(SELECT zip_code FROM instance WHERE id = @instanceId)', false) . $this->getRequestValue('') . $this->getRequestValue($orderHad['com']) . $this->getRequestValue(0, false) . $this->getRequestValue('(SELECT id FROM patient WHERE external_id =\''.trim($orderHad['numpat']).'\')', false) . $this->getRequestValue('(SELECT id FROM user WHERE login =\''.trim($orderHad['creuti']).'\')', false) . $this->getRequestValue('NULL', false) . $this->getRequestValue('(SELECT phone FROM instance WHERE id = @instanceId)', false, true) . '),';
            }

            $baseRequest = 'INSERT INTO `order` (id, instance_id, reference, sap_id, date, delivery_date, address, city, zip_code, additional_address, comment, type, patient_id, user_id, order_recovery_detail_id, phone) VALUES ' . mb_substr($request, 0, -1) . ';';
            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);
        }

        $nurseData = $this->boncde_entete->query('SELECT * FROM boncde_entete WHERE coordidel <> \'\';');
        if (count($nurseData) > 0) {
            $request = '';
            foreach ($nurseData as $nurse) {
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($nurse['numcde']).'\')', false) . $this->getRequestValue(trim($nurse['coordidel'])) . $this->getRequestValue(trim($nurse['telidel']), true, true) . '),';
            }

            $baseRequest = 'INSERT INTO nurse (id, order_id, contact, telephone) VALUES ' . mb_substr($request, 0, -1) . ';';

            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);
        }

        $recoveryOrderData = $this->bonrec_material->query('SELECT * FROM bonrec_materiel;');
        if (count($recoveryOrderData) > 0) {
            $request = '';
            foreach ($recoveryOrderData as $recoveryOrder) {
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('@instanceId', false) . $this->getRequestValue($recoveryOrder['numbrmat']) . $this->getRequestValue($recoveryOrder['numbrmatsap']) . $this->getRequestValue($this->getSqlDateFormat($recoveryOrder['datdem'])) . $this->getRequestValue($this->getSqlDateFormat($recoveryOrder['datrec'])) . $this->getRequestValue('(SELECT address FROM patient WHERE external_id =\''.trim($recoveryOrder['numpat']).'\')', false) . $this->getRequestValue('(SELECT city FROM patient WHERE external_id =\''.trim($recoveryOrder['numpat']).'\')', false) . $this->getRequestValue('(SELECT zip_code FROM patient WHERE external_id =\''.trim($recoveryOrder['numpat']).'\')', false) . $this->getRequestValue($recoveryOrder['lierecaut']) . $this->getRequestValue('') . $this->getRequestValue(1, false) . $this->getRequestValue('(SELECT id FROM patient WHERE external_id =\''.trim($recoveryOrder['numpat']).'\')', false) . $this->getRequestValue('(SELECT id FROM user WHERE login =\''.trim($recoveryOrder['creuti']).'\')', false) . $this->getRequestValue('NULL', false) . $this->getRequestValue('(SELECT phone FROM patient WHERE external_id =\''.trim($recoveryOrder['numpat']).'\')', false, true) . '),';
            }

            $baseRequest = 'INSERT INTO `order` (id, instance_id, reference, sap_id, date, delivery_date, address, city, zip_code, additional_address, comment, type, patient_id, user_id, order_recovery_detail_id, phone) VALUES ' . mb_substr($request, 0, -1) . ';';

            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);

            foreach ($recoveryOrderData as $recoveryOrder) {
                $selectUuid = 'SELECT @dataId := ' . $this->getRequestValue($getUuid, false, true) . ';' . PHP_EOL;
                $request = '(' . $this->getRequestValue('@dataId', false) . $this->getRequestValue('(SELECT CASE WHEN ISNULL(id) = 1 THEN NULL ELSE id END FROM recovery_reason WHERE label =\''.trim($recoveryOrder['raifinhad']).'\')', false) . $this->getRequestValue($this->getSqlDateFormat($recoveryOrder['datfinhad'])) . $this->getRequestValue($this->getSqlDateFormat($recoveryOrder['passsad'])) . $this->getRequestValue($this->getSqlDateFormat($recoveryOrder['com_int'])) . $this->getRequestValue(trim($recoveryOrder['com_div'])) . $this->getRequestValue(trim($recoveryOrder['r_autre']), true, true) . ');';
                $baseRequest = 'INSERT INTO order_recovery_detail (id, recovery_reason_id, date, sad_date, internal_comment, various_comment, other_comment) VALUES ' . $request . PHP_EOL;
                $updateOrderRequest = 'UPDATE `order` SET order_recovery_detail_id = @dataId WHERE reference = \'' . $recoveryOrder['numbrmat'] . '\';' . PHP_EOL;
                file_put_contents($filePath, $selectUuid . $baseRequest . $updateOrderRequest, FILE_APPEND);
            }
        }

        // Insert order items
        $orderItems = $this->boncde_poste->query("SELECT * FROM boncde_poste WHERE sk_produit NOT IN ('1','2','3','4','5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15') AND numbrmat <> '';");
        if (count($orderItems) > 0) {
            $request = '';
            foreach ($orderItems as $orderItem) {
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($orderItem['numcde']).'\')', false) . $this->getRequestValue('(SELECT id FROM item WHERE item_sap_id =\''.trim($orderItem['sk_produit']).'\')', false) . $this->getRequestValue(trim($orderItem['qt_produit']), false) . $this->getRequestValue(trim($orderItem['co_produit'])) . $this->getRequestValue('NULL', false, true) . '),';
            }

            $baseRequest = 'INSERT INTO order_item (id, order_id, item_id, quantity, comment, quote_item_id) VALUES ' . mb_substr($request, 0, -1) . ';';

            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);
        }

        $orderItemsRecup = $this->bonrec_poste->query("SELECT * FROM bonrec_poste WHERE sk_produit NOT IN ('1','2','3','4','5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15');");
        if (count($orderItemsRecup) > 0) {
            $request = '';
            foreach ($orderItemsRecup as $orderItemRecup) {
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($orderItemRecup['numbrmat']).'\')', false) . $this->getRequestValue('(SELECT id FROM item WHERE item_sap_id =\''.trim($orderItemRecup['sk_produit']).'\')', false) . $this->getRequestValue(0, false) . $this->getRequestValue('') . $this->getRequestValue('NULL', false, true) . '),';
            }

            $baseRequest = 'INSERT INTO order_item (id, order_id, item_id, quantity, comment, quote_item_id) VALUES ' . mb_substr($request, 0, -1) . ';';

            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);
        }

        //Insert quote items
        $orderItems = $this->boncde_poste->query("SELECT * FROM boncde_poste WHERE sk_produit IN ('1','2','3','4','5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15') AND numbrmat <> '';");
        if (count($orderItems) > 0) {
            foreach ($orderItems as $orderItem) {
                $product = $this->produit_had->query('SELECT lb_produit FROM produit_had WHERE sk_produit = \''.$orderItem['sk_produit'].'\'');
                $selectUuid = 'SELECT @dataId := ' . $this->getRequestValue($getUuid, false, true) . ';' . PHP_EOL;
                $quoteRequest = '(' . $this->getRequestValue('@dataId', false) . $this->getRequestValue((trim($product[0]['lb_produit']) === '') ? trim($orderItem['co_produit']) : trim($product[0]['lb_produit']), true, true) . ');';
                $quoteInsertRequest = 'INSERT INTO quote_item (id, label) VALUES ' . $quoteRequest . PHP_EOL;
                $request = '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($orderItem['numcde']).'\')', false) . $this->getRequestValue('NULL', false) . $this->getRequestValue(trim($orderItem['qt_produit']), false) . $this->getRequestValue(trim($orderItem['co_produit'])) . $this->getRequestValue('@dataId', false, true) . ');';
                $baseRequest = 'INSERT INTO order_item (id, order_id, item_id, quantity, comment, quote_item_id) VALUES ' . $request . PHP_EOL;
                file_put_contents($filePath, $selectUuid . $quoteInsertRequest . $baseRequest, FILE_APPEND);
            }
        }

        $orderItemsRecup = $this->bonrec_poste->query("SELECT * FROM bonrec_poste WHERE sk_produit IN ('1','2','3','4','5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15');");
        if (count($orderItemsRecup) > 0) {
            foreach ($orderItemsRecup as $orderItemRecup) {
                $product = $this->produit_had->query('SELECT lb_produit FROM produit_had WHERE sk_produit = \''.$orderItemRecup['sk_produit'].'\'');
                $selectUuid = 'SELECT @dataId := ' . $this->getRequestValue($getUuid, false, true) . ';' . PHP_EOL;
                $quoteRequest = '(' . $this->getRequestValue('@dataId', false) . $this->getRequestValue(trim($product[0]['lb_produit']), true, true) . ');';
                $quoteInsertRequest = 'INSERT INTO quote_item (id, label) VALUES ' . $quoteRequest . PHP_EOL;
                $request = '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($orderItemRecup['numbrmat']).'\')', false) . $this->getRequestValue('NULL', false) . $this->getRequestValue(0, false) . $this->getRequestValue('') . $this->getRequestValue('@dataId', false, true) . ');';
                $baseRequest = 'INSERT INTO order_item (id, order_id, item_id, quantity, comment, quote_item_id) VALUES ' . $request . PHP_EOL;
                file_put_contents($filePath, $selectUuid . $quoteInsertRequest . $baseRequest, FILE_APPEND);
            }
        }

        // Insert patient items
        $orderItems = $this->boncde_poste->query("SELECT * FROM boncde_poste WHERE sk_produit NOT IN ('1','2','3','4','5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15') AND numbrmat = '';");
        if (count($orderItems) > 0) {
            foreach ($orderItems as $orderItem) {
                $selectUuid = 'SELECT @dataId := ' . $this->getRequestValue($getUuid, false, true) . ';' . PHP_EOL;
                $request = '(' . $this->getRequestValue('@dataId', false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($orderItem['numcde']).'\')', false) . $this->getRequestValue('(SELECT id FROM item WHERE item_sap_id =\''.trim($orderItem['sk_produit']).'\')', false) . $this->getRequestValue(trim($orderItem['qt_produit']), false) . $this->getRequestValue(trim($orderItem['co_produit'])) . $this->getRequestValue('NULL', false, true) . ');';
                $baseRequest = 'INSERT INTO order_item (id, order_id, item_id, quantity, comment, quote_item_id) VALUES ' . $request . PHP_EOL;
                $patientItemRequest = '('.$this->getRequestValue($getUuid, false). $this->getRequestValue('(SELECT id FROM patient WHERE id = (Select patient_id FROM `order` WHERE reference =\''.trim($orderItem['numcde']).'\'))', false) . $this->getRequestValue('@dataId', false) . $this->getRequestValue(1, false, true) . ');';
                $patientItemInsertRequest = 'INSERT INTO patient_item (id, patient_id, order_item_id, active) VALUES ' . $patientItemRequest . PHP_EOL;

                file_put_contents($filePath, $selectUuid . $baseRequest . $patientItemInsertRequest, FILE_APPEND);
            }
        }

        $orderItems = $this->boncde_poste->query("SELECT * FROM boncde_poste WHERE sk_produit IN ('1','2','3','4','5', '6', '7', '8', '9', '10', '11', '12', '13', '14', '15') AND numbrmat = '';");
        if (count($orderItems) > 0) {
            foreach ($orderItems as $orderItem) {
                $product = $this->produit_had->query('SELECT lb_produit FROM produit_had WHERE sk_produit = \''.$orderItem['sk_produit'].'\'');
                $selectUuid = 'SELECT @dataId := ' . $this->getRequestValue($getUuid, false, true) . ';' . PHP_EOL;
                $quoteRequest = '(' . $this->getRequestValue('@dataId', false) . $this->getRequestValue((trim($product[0]['lb_produit']) === '') ? trim($orderItem['co_produit']) : trim($product[0]['lb_produit']), true, true) . ');';
                $quoteInsertRequest = 'INSERT INTO quote_item (id, label) VALUES ' . $quoteRequest . PHP_EOL;
                $selectOrderitemUuid = 'SELECT @OrderItemId := ' . $this->getRequestValue($getUuid, false, true) . ';' . PHP_EOL;
                $request = '(' . $this->getRequestValue('@OrderItemId', false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($orderItem['numcde']).'\')', false) . $this->getRequestValue('NULL', false) . $this->getRequestValue(trim($orderItem['qt_produit']), false) . $this->getRequestValue(trim($orderItem['co_produit'])) . $this->getRequestValue('@dataId', false, true) . ');';
                $baseRequest = 'INSERT INTO order_item (id, order_id, item_id, quantity, comment, quote_item_id) VALUES ' . $request . PHP_EOL;
                $patientItemRequest = '('.$this->getRequestValue($getUuid, false). $this->getRequestValue('(SELECT id FROM patient WHERE id = (Select patient_id FROM `order` WHERE reference =\''.trim($orderItem['numcde']).'\'))', false) . $this->getRequestValue('@OrderItemId', false) . $this->getRequestValue(1, false, true) . ');';
                $patientItemInsertRequest = 'INSERT INTO patient_item (id, patient_id, order_item_id, active) VALUES ' . $patientItemRequest . PHP_EOL;

                file_put_contents($filePath, $selectUuid . $quoteInsertRequest . $selectOrderitemUuid . $baseRequest . $patientItemInsertRequest, FILE_APPEND);
            }
        }

        // Insert status history
        $orderItems = $this->boncde_entete->query('SELECT * FROM boncde_entete;');
        if (count($orderItems) > 0) {
            $request = '';
            foreach ($orderItems as $orderItem) {
                $status = $this->boncde_entete->query('SELECT * FROM orderStatus where id =' . $orderItem['statusId'] . ';');
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('(SELECT id FROM order_status WHERE sap_status =\''.trim($status[0]['sapStatus']).'\')', false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($orderItem['numcde']).'\')', false) . $this->getRequestValue($this->getSqlDateFormat(trim($orderItem['dateStatus'])), true, true) . '),';
            }

            $baseRequest = 'INSERT INTO order_status_history (id, status_id, order_id, date) VALUES ' . mb_substr($request, 0, -1) . ';';

            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);
        }
        $orderItemsRecup = $this->bonrec_material->query('SELECT * FROM bonrec_materiel;');
        if (count($orderItemsRecup) > 0) {
            $request = '';
            foreach ($orderItemsRecup as $orderItemRecup) {
                $status = $this->boncde_entete->query('SELECT * FROM orderStatus where id =' . $orderItemRecup['statusId'] . ';');
                $request .= '(' . $this->getRequestValue($getUuid, false) . $this->getRequestValue('(SELECT id FROM order_status WHERE sap_status =\''.trim($status[0]['sapStatus']).'\')', false) . $this->getRequestValue('(SELECT id FROM `order` WHERE reference =\''.trim($orderItemRecup['numbrmat']).'\')', false) . $this->getRequestValue($this->getSqlDateFormat(trim($orderItemRecup['dateStatus'])), true, true) . '),';
            }

            $baseRequest = 'INSERT INTO order_status_history (id, status_id, order_id, date) VALUES ' . mb_substr($request, 0, -1) . ';';

            file_put_contents($filePath, $baseRequest . PHP_EOL, FILE_APPEND);
        }
    }

    private function getSqlDateFormat($date) {
        if (empty(trim($date)) || trim($date) === '0000-00-00' || trim($date) === '0000-00-00 00:00:00') {
            return 'NULL';
        }

        return $date;
    }

    private function getItemCategoryId($itemCategoryLabel) {
        return 'SELECT @itemCategoryId := id FROM item_category WHERE label like \'%' . $itemCategoryLabel . '%\';' .PHP_EOL;
    }

    private function getRequestValue($value, $withQuote = true, $isLastValue = false) {
        $separator = ',';
        if ($value === 'NULL') {
            return $value . ($isLastValue ? '' : $separator);
        }

        if ($withQuote) {
            return $this->addQuote(trim($value)) . ($isLastValue ? '' : $separator);
        }

        if (!$isLastValue) {
            return $value . $separator;
        }

        return $value;
    }

    private function addQuote($value) {
        $quote = '\'';
        return $quote . str_replace('\'', '\'\'', $value) . $quote;
    }
}