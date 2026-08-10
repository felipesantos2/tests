<?php

declare(strict_types=1);

namespace app\models;

use app\entities\Entity;
use core\Connection;
use PDO;

abstract class Model
{
    private ?string $table = null;

    public Entity|string|null $entity = null;

    public function __construct()
    {
        $this->table = $this->getTable();
        $this->entity = $this->getEntity()::class;
    }

    private function getTable(): string
    {

        $className = get_called_class();
        $className = explode('\\', $className);
        $className = end($className);

        return strtolower($className) . 's';
    }

    private function getEntity(?array $data = []): Entity
    {

        $className = get_called_class();
        $className = explode('\\', $className);
        $className = '\\app\\entities\\' . end($className) . 'Entity';

        return new $className(...$data);
    }

    public function create(array|Entity $data)
    {
        $keys = implode(', ', array_keys($data));

        $placeholder = implode(', ',
            array_map(function ($key) {
                return ":{$key}";
            }, array_keys($data))
        );

        $data = $this->getEntity($data);

        // verify return
        return $this->rawQuery(
            query: "INSERT INTO {$this->table} ({$keys}) VALUES ({$placeholder})",
            params: (array) $data
        );
    }

    public function all(): array
    {
        return $this->rawQuery(
            query: "SELECT * FROM {$this->table}",
            params: []
        );
    }

    public function first(): Entity|array|null
    {
        return $this->rawQuery(
            query: "SELECT * FROM {$this->table} ORDER BY id ASC LIMIT 1",
            params: []
        )[0];
    }

    public function last(): Entity|array|null
    {
        return $this->rawQuery(
            query: "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT 1",
            params: []
        )[0];
    }

    public function getById(int|string $id): Entity|array|null
    {
        $id = is_string($id) ? (int) $id : $id;

        return $this->rawQuery(
            query: "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1",
            params: ['id' => $id]
        )[0];
    }

    public function findById(int|string $id): Entity|array|null
    {
        return $this->getById($id);
    }

    public function find(string $value, string $field = 'id'): Entity|array|null
    {
        $value = trim((string) $value);
        $field = trim((string) $field);

        return $this->rawQuery(
            query: "SELECT * FROM {$this->table} WHERE {$field} LIKE :value ORDER BY id DESC LIMIT 1",
            params: ['value' => "%{$value}%"]
        );
    }

    /**
     * UPDATE method that makes basic use of a rudimentary Hydration system
     * We receive the ID of a record or an Entity instance and its data
     */
    public function update(int|string|Entity $field, array|Entity $data = []): mixed
    {
        $field = is_string($field) ? (int) $field : $field; // se for entity passa direto

        $data = $data instanceof Entity ?
            $data :
            static::hydrate($this->entity, $data);

        // TODO: remove this, fixed user params
        $params = [
            ':id'       => $field instanceof Entity ? $field->id : $field,
            ':name'     => $data->name ?? $field->name,
            ':email'    => $data->email ?? $field->email,
            ':password' => $data->password ?? $field->password,
            ':status'   => $data->status ?? $field->status,
        ];

        return $this->rawQuery(
            query: "UPDATE {$this->table} SET name = :name, email = :email, password = :password, status = :status WHERE id = :id",
            params: $params
        );
    }

    // TODO: remover o execute deste método
    public function count(): ?int
    {
        $pdo = Connection::getConnection();
        $query = "SELECT count(*) FROM {$this->table}";

        try {
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_COLUMN);

            return $result;
        } catch (\PDOException $e) {
            dd(error: $e->getMessage(), query: $query);
        }

    }

    /**
     * Executes the queries and returns the results
     *
     * @param  array  $params
     */
    private function rawQuery(string $query, array|Entity|null $params = []): array|object|null
    {
        try {
            $pdo = Connection::getConnection();

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            $result = $stmt->fetchAll(PDO::FETCH_CLASS, $this->entity);

            return $result;
        } catch (\PDOException $e) {
            dd(error: $e->getMessage(), query: $query, params: $params);
        }
    }

    /**
     * Converts data to a specific class type, Hydrat
     */
    private static function hydrate(string $class, array $data = []): ?object
    {

        $instance = new $class();

        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }

        return $instance ?? null;
    }
}
