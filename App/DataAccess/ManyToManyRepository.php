<?php namespace App\DataAccess;


use App\Helpers\ArrayWrapper;

class ManyToManyRepository {
    public static function setCollectionToTarget($table, $target, $collection, $target_id, $collection_id) {
        $db = DB::getInstance();

        $sqlSelect = "SELECT * FROM `{$table}` WHERE {$target_id} = :{$target_id}";
        $result = $db->queryAll($sqlSelect, [':' . $target_id => $target->getId()]);

        $resultMap = [];
        $collectionMap = [];
        $inserts = [];
        $deletes = [];

        foreach ($result as $item) {
            $resultMap[$item->{$collection_id}] = $item;
        }

        $resultMap = ArrayWrapper::construct($resultMap);

        foreach ($collection as $item) {
            $collectionMap[$item->getId()] = $item;

            if (!$resultMap->exists($item->getId())) {
                $inserts[] = $item;
            }
        }

        $collectionMap = ArrayWrapper::construct($collectionMap);

        foreach ($result as $item) {
            if (!$collectionMap->exists($item->{$collection_id})) {
                $deletes[] = $item;
            }
        }

        foreach ($deletes as $item) {
            $db->nonQuery("DELETE FROM `{$table}` WHERE {$target_id} = :{$target_id} AND {$collection_id} = :{$collection_id}", [
                ':' . $target_id => $item->{$target_id},
                ':' . $collection_id => $item->{$collection_id}
            ]);
        }

        foreach ($inserts as $item) {
            $db->nonQuery("INSERT INTO `{$table}` ({$target_id}, {$collection_id}) VALUES (:{$target_id}, :{$collection_id})", [
                ':' . $target_id => $target->getId(),
                ':' . $collection_id => $item->getId()
            ]);
        }
    }
}