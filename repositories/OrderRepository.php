<?php

class OrderRepository
{
    private $orderStatusRepository;
    private $bonrec_materiel;
    private $boncde_entete;

    public function __construct()
    {
        $this->orderStatusRepository = new OrderStatusRepository();
        $this->bonrec_materiel = new dbtable('bonrec_materiel');
        $this->boncde_entete = new dbtable('boncde_entete');
    }

    public function updateOrderStatus($order, $isOrder)
    {
        $orderId = $isOrder === true ? $order['numcde'] : $order['numbrmat'];
        $orderStatus = isset($order['statusId']) ? $order['statusId'] : 0;
        $sapStatus = $this->orderStatusRepository->getSapStatus([['ClbCde' => $orderId]]);

        if (!empty($sapStatus[$orderId])) {
            $sapStatus = $sapStatus[$orderId];

            if ($sapStatus['statusId'] !== $orderStatus) {
                $dateStatus = $sapStatus['dateStatus'] !== false ?
                    $sapStatus['dateStatus']
                        ->format('Y-m-d H:i:s') :
                    DateTime::createFromFormat('Y-m-d H:i:s', $order['credat'] . ' ' . $order['creheu'])
                        ->format('Y-m-d H:i:s');

                if ($isOrder === true) {
                    $this->boncde_entete->update('numcde', $orderId,[
                        'statusId' => $sapStatus['statusId'],
                        'dateStatus' => $dateStatus,
                        'numcdesap' => $sapStatus['sapId']
                    ]);
                } else {
                    $this->bonrec_materiel->update('numbrmat', $orderId, [
                        'statusId' => $sapStatus['statusId'],
                        'dateStatus' => $dateStatus,
                        'numbrmatsap' => $sapStatus['sapId']
                    ]);
                }

                $order['statusId'] = $sapStatus['statusId'];
                $order['dateStatus'] = $dateStatus;
            }
        }

        return $order;
    }

    public function updateAllOrdersStatus($isOrder)
    {
        $lastStatusId = $this->orderStatusRepository->getLastStatusId();
        $tableName = $isOrder === true ? 'boncde_entete' : 'bonrec_materiel';
        $dbTable = $isOrder === true ? $this->boncde_entete : $this->bonrec_materiel;
        $columnName = $isOrder === true ? 'numcde' : 'numbrmat';

        $sql = 'SELECT ' . $columnName . ' FROM ' . $tableName . ' WHERE ISNULL(statusId) = 1 OR statusId <> ' . $lastStatusId;
        $result = $dbTable->query($sql);
        $orders = [];
        foreach ($result as $findOrder) {
            $orders[] = ['ClbCde' => $findOrder[$columnName]];
        }

        $ordersSapStatus = $this->orderStatusRepository->getSapStatus($orders);

        foreach ($ordersSapStatus as $orderSapStatus) {
            if ($orderSapStatus['dateStatus'] === false) {
                $order = $dbTable->find($columnName, $orderSapStatus['numcde']);
                $orderStatusDate = DateTime::createFromFormat('Y-m-d H:i:s', $order['credat'] . ' ' . $order['creheu'])
                    ->format('Y-m-d H:i:s');
            } else {
                $orderStatusDate = $orderSapStatus['dateStatus']
                    ->format('Y-m-d H:i:s');
            }

            $dbTable->update($isOrder === true ? 'numcde' : 'numbrmat', $orderSapStatus['numcde'],[
                'statusId' => $orderSapStatus['statusId'],
                'dateStatus' => $orderStatusDate,
                $isOrder === true ? 'numcdesap' : 'numbrmatsap' => $orderSapStatus['sapId']
            ]);
        }
    }
}