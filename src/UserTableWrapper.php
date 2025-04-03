<?php

class UserTableWrapper implements TableWrapperInterface
{
    private array $rows = [];

    /**
     * @param array|[column => row_value] $values
     */
    public function insert(array $values): void
    {
        $this->rows[] = $values;
    }

    public function update(int $id, array $values): array
    {
        foreach ($values as $key => $value) {
            $this->rows[$id][$key] = $value;
        }
        return $this->rows[$id];
    }

    public function delete(int $id): void
    {
        unset($this->rows[$id]);
    }

    public function get(): array
    {
        return $this->rows;
    }
}
