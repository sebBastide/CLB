<?php

class OrderStatusRepository
{
    private $orderStatus;

    public function __construct()
    {
        $this->orderStatus = new dbtable('orderStatus');
    }

    /**
     * return orders status
     *
     * @param $orders array
     *
     * @return array
     */
    public function getSapStatus($orders)
    {
        $ordersStatus = [];
        if (count($orders) > 0) {
            $wsClient = new SoapClient(SAP_URL, [
                'soap_version' => SOAP_1_2,
                "trace" => 1,
                "exception" => 0,
                'login' => WEBSERVICE_LOGIN,
                'password' => WEBSERVICE_PASSWORD,
            ]);

            $result = $wsClient->ZsdclbGetStatut([
                'ItClbcde' => $orders,
                'OtMessage' => [],
                'OtOverview' => [],
            ]);


            $overview = $result->OtOverview->item;
            // if we just have one result
            if (!is_array($overview)) {
                $newDate = $this->getDateTimeFromString($overview->DocDateCreat, $overview->DocHeureCreat);

                return $this->getResultArray($orders, $overview, $newDate, $ordersStatus);
            }

            $currentOrder = null;
            foreach ($overview as $order) {
                $newDate = $this->getDateTimeFromString($order->DocDateCreat, $order->DocHeureCreat);
                if ($newDate !== false) {
                    if ($currentOrder && $order->ClbCde === $currentOrder->ClbCde) {
                        $currentDate = $this->getDateTimeFromString($currentOrder->DocDateCreat, $currentOrder->DocHeureCreat);
                        if ($currentDate === false || $newDate < $currentDate) {

                            continue;
                        }
                    }
                }

                $ordersStatus = $this->getResultArray($orders, $order, $newDate, $ordersStatus);
                $currentOrder = $order;
            }
        }

        return $ordersStatus;
    }

    private function getDateTimeFromString($date, $time)
    {
        $newDate = false;
        if ($date !== '0000-00-00') {
            $newDate = DateTime::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time);
        }

        return $newDate;
    }

    private function getResultArray($initialOrders, $sapOrder, $date, $result)
    {
        $orderStatus = $this->getOrderStatusFromSapStatus($sapOrder->Statut, $sapOrder->DocCode !== '');
        foreach ($initialOrders as $initialOrder) {
            if (strpos($sapOrder->ClbCde, $initialOrder['ClbCde']) !== false) {
                $result[$initialOrder['ClbCde']] = [
                    'numcde' => $initialOrder['ClbCde'],
                    'statusId' => $orderStatus['id'],
                    'dateStatus' => $date,
                    'sapId' => $sapOrder->DocCode,
                    'label' => $sapOrder->Libelle,
                ];

                return $result;
            }
        }

        return $result;
    }

    /**
     * @param $sapStatusId string
     * @param $isSap bool
     *
     * @return array
     */
    public function getOrderStatusFromSapStatus($sapStatus, $isSap)
    {
        if ($isSap && $sapStatus === 'A') {
            $sapStatus = 'AA';
        }

        $orderStatus = $this->orderStatus->find('sapStatus', $sapStatus);

        return $orderStatus;
    }

    /**
     * @param $statusId int
     *
     * @return string
     */
    public function getStatusLabel($statusId)
    {
        $orderStatus = $this->orderStatus->find('id', $statusId);

        return $orderStatus['label'];
    }

    public function getLastStatusId()
    {
        $orderStatus = $this->orderStatus->find('sapStatus', 'D');

        return $orderStatus['id'];
    }
}