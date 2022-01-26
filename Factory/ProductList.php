<?php

namespace scandiweb\Factory;

class ProductList
{
    /**
     * @return void
     */
    public  function printAll(){
        $query = new QueryBuilder("select");


        $query->setTable('products');


        $query->addColumn("*");
        $query->setWhere("1");

        $sql_query = $query->buildQuery();

        $db = (new DBMan()) -> get();
        $rows = array();
        $result =  $db->query($sql_query);
        if ($result->num_rows > 0) {

            // output data of each row
            while($row = $result->fetch_assoc()) {
                $element = array(
                    'ID' => $row["ID"],
                    'sku' => $row["sku"],
                    'name' => $row["name"],
                    'price' => $row["price"],
                    'type' => $row["type"],
                    'attribute' => $row["attribute"]
                );
                array_push($rows, $element);
            }
        }
        $arrayKeys = array_keys($rows);
        $lastArrayKey = array_pop($arrayKeys);

        echo '[';
        foreach($rows as $key => $row){
            echo json_encode($row, JSON_PRETTY_PRINT);
            if($key !== $lastArrayKey)
                echo ",";
        }
        echo']';
    }

    /**
     * @param array $skus
     * @return void
     */
    public function massDelete(array $skus){
        $db = (new DBMan())->get();
        foreach($skus as $sku){
            $query = new QueryBuilder("delete");
            $query->setTable('products');
            $query->setWhere("sku = \"".$sku."\"");
            $db->query($query->buildQuery());
        }
    }
}