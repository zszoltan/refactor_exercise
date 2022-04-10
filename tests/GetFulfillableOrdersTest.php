<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use RefactorExercise\Repositories\InMemoryStockRepository;
use RefactorExercise\Exceptions\InvalidJsonException;

final class GetFulfillableOrdersTest extends TestCase
{
    public function testInvalidArgsNum(): void
    {
        $output = shell_exec("php .\get_fulfillable_orders.php {\\\"1\\\":8,\\\"2\\\":4,\\\"3\\\":5} 2");
        $this->assertEquals('Ambiguous number of parameters!', $output);
    }


    public function testInvalidArgsNum2(): void
    {
        $output = shell_exec("php .\get_fulfillable_orders.php");
        $this->assertEquals('Ambiguous number of parameters!', $output);
    }


    public function testInvalidJsonArgs(): void
    {
        $output = shell_exec("php .\get_fulfillable_orders.php {1\\\":8,\\\"2\\\":4,\\\"3\\\":5}");
        $this->assertEquals('Invalid json!', $output);
    }

    /*public function testInvalidQuantityJsonArgs(): void
    {
        $output = shell_exec("php .\get_fulfillable_orders.php {\\\"1\\\":\\\"aaaaaaa\\\",\\\"2\\\":4,\\\"3\\\":5}");
        //$this->assertEquals('Invalid json!',$output);
    }*/


    public function testGetFulfillableOrdersSortExpect(): void
    {
        $fulfillableOrders = $this->getFulfillableOrders(array("1" => 10, "2" => 10, "3" => 10));
        $this->assertCount(10, $fulfillableOrders);
        $this->checkOrderSort($fulfillableOrders);
    }

    public function testGetFulfillableOrdersEmptyStockAsExpect(): void
    {
        $fulfillableOrders = $this->getFulfillableOrders(array("1" => 0, "2" => 0, "3" => 0));
        $this->assertCount(0, $fulfillableOrders);
        $this->checkOrderSort($fulfillableOrders);
    }
    public function testGetFulfillableOrdersOnlyOneItemInStockAsExpect(): void
    {
        $fulfillableOrders = $this->getFulfillableOrders(array("1" => 2, "2" => 0, "3" => 0));
        $this->assertCount(2, $fulfillableOrders);
        $this->checkOrderSort($fulfillableOrders);
    }

    public function testGetFulfillableOrdersTwoItemInStockAsExpect(): void
    {
        $fulfillableOrders = $this->getFulfillableOrders(array("1" => 2, "2" => 0, "3" => 1));
        $this->assertCount(3, $fulfillableOrders);
        $this->checkOrderSort($fulfillableOrders);
    }

    public function testGetFulfillableOrdersOnlyNotOrderedItemInStockAsExpect(): void
    {
        $fulfillableOrders = $this->getFulfillableOrders(array("1" => 0, "2" => 0, "3" => 0, "4" => 3));
        $this->assertCount(0, $fulfillableOrders);
        $this->checkOrderSort($fulfillableOrders);
    }
    public function testGetFulfillableOrdersAllFilterdItemAsExpect(): void
    {
        $fulfillableOrders = $this->getFulfillableOrders(array("1" => 1, "2" => 2, "3" => 10));
        $this->assertCount(6, $fulfillableOrders);
        $this->checkOrderSort($fulfillableOrders);
    }


    public function testStockCreateFromJsonAsExpect(): void
    {
        $stockRepository = InMemoryStockRepository::createFromJson('{"1":8,"2":4,"3":5}');
        $items = $stockRepository->getAllItem();
        $this->assertCount(3, $items);
        $this->assertEquals(1,$items[0]->getProductId());
        $this->assertEquals(8,$items[0]->getQuantity());
        $this->assertEquals(2,$items[1]->getProductId());
        $this->assertEquals(4,$items[1]->getQuantity());
        $this->assertEquals(3,$items[2]->getProductId());
        $this->assertEquals(5,$items[2]->getQuantity());
        
    }

    public function testStockCreateFromJsonInvalidJson(): void
    {
        $this->expectException(InvalidJsonException::class);
        $stockRepository = InMemoryStockRepository::createFromJson('{""1":8,"2":4,"3":5}');
    }





    private function checkOrderSort(array $fulfillableOrders)
    {
        $priorityLevels = array("low", "medium", "high");
        $lastPriority = "high";
        $lastCreatedAt = null;
        foreach ($fulfillableOrders as $currentOrder) {
            $this->assertLessThanOrEqual(array_search($lastPriority, $priorityLevels), array_search($currentOrder['priority'], $priorityLevels));
            if ($lastCreatedAt == null || $currentOrder['priority'] != $lastPriority) {
                $lastCreatedAt = $currentOrder['created_at'];
            }
            $this->assertGreaterThanOrEqual($lastCreatedAt, $currentOrder['created_at']);
            $lastCreatedAt = $currentOrder['created_at'];
            $lastPriority = $currentOrder['priority'];
        }
    }
    private function getFulfillableOrders(array $stock)
    {
        $json = json_encode($stock);
        $json = str_replace('"', '\\"', $json);
        $output = shell_exec("php .\get_fulfillable_orders.php " . $json);
        return $this->convertOutput($output);
    }

    private function convertOutput($output)
    {
        $result = [];
        if (is_null($output) || empty($output))
            $output = false;
        try {
            $row = explode("\n", $output);
            for ($i = 2; $i < count($row); ++$i) {
                $values = preg_split("/ /", $row[$i], -1, PREG_SPLIT_NO_EMPTY);
                if (count($values) != 5)
                    continue;
                $result[] = array(
                    "product_id" => $values[0],
                    "quantity" => $values[1],
                    "priority" => $values[2],
                    "created_at" => $values[3] . " " . $values[4]
                );
            }
        } catch (Exception $e) {
            $output = false;
        }

        return $result;
    }
}
