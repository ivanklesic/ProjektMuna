<?php declare(strict_types = 1);

namespace App\Model\HistoryItem;

use App\Core\Data\Database;
use App\Core\Model\RepositoryInterface;

class HistoryItemRepository implements RepositoryInterface
{
    public function getList(): array
    {
        $list = [];
        $db = Database::getInstance();
        $statement = $db->prepare('select * from history_item ');
        $statement->execute();
        foreach ($statement->fetchAll() as $item) {
            $list[] = new HistoryItem([
                'id' => $item->id,
                'value' => $item->value,
                'time' => $item->time
            ]);
        }
        return $list;
    }

    public function insert($data): bool
    {
        $db = Database::getInstance();
        $statement = $db->prepare(
            'INSERT into history_item (value, time)
                      values (:value, :time)'
        );
        $statement->bindValue('value', $data['value']);
        $statement->bindValue('time', $data['time']);

        return $statement->execute();
    }
}