<?php

namespace RefactorExercise\Services;

use RefactorExercise\Repositories\IOrderRepository;
use RefactorExercise\Core\IDataSource;
use RefactorExercise\Models\Order;
use RefactorExercise\Exceptions\MissingDataColumnException;

class OrderDataSourceProcessService
{
    private $dataSource;
    private $orderRepository;
    private $csvHeader;
    public function __construct(IOrderRepository $orderRepository, IDataSource $dataSource)
    {
        $this->dataSource = $dataSource;
        $this->orderRepository = $orderRepository;
    }
    public function process()
    {
        $this->csvHeader = $this->dataSource->readDataRow();
        $productIdIndex = array_search('product_id', $this->csvHeader, true);
        $quantityIndex = array_search('quantity', $this->csvHeader, true);
        $priorityIndex = array_search('priority', $this->csvHeader, true);
        $createdAtIndex = array_search('created_at', $this->csvHeader, true);
        $missingDataColumn = [];
        if ($productIdIndex  === false)
        $missingDataColumn []= 'product_id';

        if ($quantityIndex  === false)
        $missingDataColumn []= 'product_id';

        if ($priorityIndex  === false)
        $missingDataColumn []= 'product_id';

        if ($createdAtIndex  === false)
        $missingDataColumn []= 'product_id';
        if( count($missingDataColumn) > 0)
        {
            throw new MissingDataColumnException($missingDataColumn);
        }

        while (($data = $this->dataSource->readDataRow()) !== false) {

            $this->orderRepository->insert(new Order($data[$productIdIndex], $data[$quantityIndex], $data[$priorityIndex], $data[$createdAtIndex]));
        }
    }
    public function getCsvHeaders()
    {
        return $this->csvHeader;
    }
}
