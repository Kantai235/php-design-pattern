<?php

namespace DesignPatterns\Structural\DataMapper;

use InvalidArgumentException;

/**
 * Class TurnipsMapper.
 */
class TurnipsMapper
{
    /**
     * @var StorageAdapter
     */
    protected $adapter;

    /**
     * TurnipsMapper constructor.
     *
     * @param StorageAdapter $storage
     */
    public function __construct(StorageAdapter $storage)
    {
        $this->adapter = $storage;
    }

    /**
     * @param int $id
     *
     * @throws InvalidArgumentException
     * @return Turnips
     */
    public function findById(int $id): Turnips
    {
        $result = $this->adapter->findById($id);

        if ($result === null) {
            throw new InvalidArgumentException("找不到 ID 為「 $id 」的島嶼。");
        }

        return $this->mapRowToTurnips($result);
    }

    /**
     * @param int $id
     *
     * @throws InvalidArgumentException
     * @return Turnips
     */
    public function findByIsland(string $island): Turnips
    {
        $result = $this->adapter->findByIsland($island);

        if ($result === null) {
            throw new InvalidArgumentException("找不到名稱為「 $island 」的島嶼。");
        }

        return $this->mapRowToTurnips($result);
    }

    /**
     * @param array $row
     * 
     * @return Turnips
     */
    protected function mapRowToTurnips(array $row): Turnips
    {
        return Turnips::fromIsland($row);
    }
}
