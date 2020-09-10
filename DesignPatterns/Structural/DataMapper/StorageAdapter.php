<?php

namespace DesignPatterns\Structural\DataMapper;

/**
 * Class StorageAdapter.
 */
class StorageAdapter
{
    /**
     * @var array
     */
    protected $data = [];

    /**
     * StorageAdapter constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function findById(int $id)
    {
        if (isset($this->data[$id])) {
            return $this->data[$id];
        }

        return null;
    }

    /**
     * @param string $island
     *
     * @return array|null
     */
    public function findByIsland(string $island)
    {
        $key = array_search($island, array_column($this->data, 'island'));
        if (false !== $key) {
            return $this->data[$key];
        }
        
        return null;
    }
}
