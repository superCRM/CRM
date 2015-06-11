<?php
/**
 * Created by PhpStorm.
 * User: nmakarenko
 * Date: 11.06.15
 * Time: 19:54
 */

function createRefund($db, $email, $order_num, $products){

    //checking data

    for ($i = 0; $i < count($products); $i++) {
        $res1 = array();
        $res2 = array();

        $query = $db->prepare("SELECT sum FROM products WHERE order_id = :order_id AND name = :name");
        $query->bindParam(':order_id', $order_num, PDO::PARAM_STR);
        $query->bindParam(':name', $products[$i]['name'], PDO::PARAM_STR);

        $query->execute();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $res1[] = $row;
        }

        $query = $db->prepare("SELECT refund_sum FROM products WHERE order_id = :order_id AND name = :name");
        $query->bindParam(':order_id', $order_num, PDO::PARAM_STR);
        $query->bindParam(':name', $products[$i]['name'], PDO::PARAM_STR);

        $query->execute();

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $res2[] = $row;
        }

        $diff = $res1['sum'] - $res2['refund_sum'];
        if ($diff < $products[$i]['sum']) return 0;
    }

    //addind
    $res = array();

        $query = $db->prepare("INSERT INTO refund (email_us, order_num, data, status)
			 VALUES (:email, :order_num, now(),0)");
        $query->bindParam(':order_num', $order_num, PDO::PARAM_STR);
        $query->bindParam(':email', $email, PDO::PARAM_STR);

        $query->execute();
    $inserted_id = $db->lastInsertId();

    for ($i = 0; $i < count($products); $i++) {
        $query = $db->prepare("INSERT INTO refund_product (product_name, sum, id_refund)
			 VALUES (:product_name, :sum, :id_refund)");
        $query->bindParam(':product_name', $products[$i]['name'], PDO::PARAM_STR);
        $query->bindParam(':sum', $products[$i]['sum']);
        $query->bindParam(':id_refund', $inserted_id);

        $query->execute();

        $query = $db->prepare("UPDATE products SET refund_sum = refund_sum + :sum WHERE name = :name AND order_id = :order_num");
        $query->bindParam(':sum', $products[$i]['sum']);
        $query->bindParam(':name', $products[$i]['name'], PDO::PARAM_STR);
        $query->bindParam(':order_num', $order_num, PDO::PARAM_STR);
        $query->execute();
    }



    return 1;

}