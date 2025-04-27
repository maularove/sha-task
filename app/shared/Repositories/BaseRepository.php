<?php

namespace App\Shared\Repositories;

use App\Shared\Exceptions\PDOQueryException;
use App\Shared\Interfaces\DBInterface;
use App\Shared\Interfaces\ModelInterface;
use App\Shared\Models\BaseModel;
use Psr\Container\ContainerInterface;

class BaseRepository
{
    public string $tableName = '';
    public string $prefix = '';
    public string $class = BaseModel::class;
    public array $dependencies = [];

    public function __construct(protected DBInterface $db, protected ContainerInterface $container, string $dbType = 'db')
    {
        if ($dbType == 'db') {
            $this->prefix = $container->get('tenant')->prefijo_tabla . 'rrhh_';
        } else {
            $this->prefix = $container->get('settings')[$dbType]['prefix'];
        }
    }

    /**
     * @throws PDOQueryException
     */
    public function findAll(string $select = '*'): array
    {
        $s = $this->db->prepare('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' ');

        if (!$s) {
            throw new PDOQueryException('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' ');
        }
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetchAll();
    }
    public function findAllSD(string $select = '*'): array
    {
        $s = $this->db->prepare('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' WHERE deleted = 0 ');

        if (!$s) {
            throw new PDOQueryException('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' WHERE deleted = 0 ');
        }
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetchAll();
    }

    /**
     * @throws PDOQueryException
     */
    public function find(int $id, string $select = '*'): mixed
    {
        $s = $this->db->prepare('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' WHERE ' . $this->class::DB_IDENTIFIER . ' = :' . $this->class::DB_IDENTIFIER);

        if (!$s) {
            throw new PDOQueryException('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' WHERE ' . $this->class::DB_IDENTIFIER . ' = :' . $this->class::DB_IDENTIFIER);
        }

        $s->bindParam(':' . $this->class::DB_IDENTIFIER, $id, \PDO::PARAM_INT);
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetch();
    }
    public function findSD(int $id, string $select = '*'): mixed
    {
        $s = $this->db->prepare('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' WHERE ' . $this->class::DB_IDENTIFIER . ' = :' . $this->class::DB_IDENTIFIER . ' AND deleted = 0');

        if (!$s) {
            throw new PDOQueryException('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' WHERE ' . $this->class::DB_IDENTIFIER . ' = :' . $this->class::DB_IDENTIFIER . ' AND deleted = 0');
        }

        $s->bindParam(':' . $this->class::DB_IDENTIFIER, $id, \PDO::PARAM_INT);
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetch();
    }
    public function find2Identifer(int $id1, int $id2, string $select = '*'): mixed
    {
        $s = $this->db->prepare('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' WHERE ' . $this->class::DB_IDENTIFIER1 . ' = :' . $this->class::DB_IDENTIFIER1 . ' AND ' . $this->class::DB_IDENTIFIER2 . ' = :' . $this->class::DB_IDENTIFIER2);

        if (!$s) {
            throw new PDOQueryException('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' WHERE ' . $this->class::DB_IDENTIFIER1 . ' = :' . $this->class::DB_IDENTIFIER1 . ' AND ' . $this->class::DB_IDENTIFIER2 . ' = :' . $this->class::DB_IDENTIFIER2);
        }

        $s->bindParam(':' . $this->class::DB_IDENTIFIER1, $id1, \PDO::PARAM_INT);
        $s->bindParam(':' . $this->class::DB_IDENTIFIER2, $id2, \PDO::PARAM_INT);
        $s->execute();
        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetch();
    }

    /**
     * @throws PDOQueryException
     */
    public function findWhere(string $where = '', array $params = [], string $select = '*'): mixed
    {
        $s = $this->getFindPrepare($select, $where, $params);

        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetch();
    }

    /**
     * @throws PDOQueryException
     */
    public function findAllWhere(string $where = '', array $params = [], string $select = '*'): array
    {
        $s = $this->getFindPrepare($select, $where, $params);

        $s->setFetchMode(\PDO::FETCH_CLASS, $this->class, $this->dependencies);

        return $s->fetchAll();
    }

    /**
     * @throws PDOQueryException
     */
    public function rawWhere(string $where = '', array $params = [], string $select = '*', int $fetch_mode = \PDO::FETCH_OBJ): mixed
    {
        $s = $this->getFindPrepare($select, $where, $params);
        $s->setFetchMode($fetch_mode);

        return $s->fetch();
    }

    /**
     * @throws PDOQueryException
     */
    public function rawAllWhere(string $where = '', array $params = [], string $select = '*', int $fetch_mode = \PDO::FETCH_OBJ): array
    {
        $s = $this->getFindPrepare($select, $where, $params);
        $s->setFetchMode($fetch_mode);

        return $s->fetchAll();
    }

    /**
     * @throws PDOQueryException
     */
    public function countAllWhere(string $where = '', array $params = []): int
    {
        $s = $this->db->prepare('SELECT COALESCE(COUNT(*),0) FROM ' . $this->prefix . $this->tableName . ' ' . $where);

        if (!$s) {
            throw new PDOQueryException('SELECT COALESCE(COUNT(*),0) FROM ' . $this->prefix . $this->tableName . ' ' . $where);
        }

        foreach ($params as $keyParam => $param) {
            $s->bindParam($keyParam, $param['value'], $param['type']);
        }

        $s->execute();

        return (int)$s->fetchColumn() ?: 0;
    }

    /**
     * @throws PDOQueryException
     */
    public function save(ModelInterface $model, array $attributes = []): bool|int
    {
        if (isset($model->{$this->class::DB_IDENTIFIER})) {
            return $this->update($model, $attributes);
        }
        $attributes = $attributes === [] ? $model->getCreateValues() : $attributes;

        $insertValues = $this->prepareInsertValues($attributes);

        $s = $this->db->prepare(
            '
            INSERT INTO ' . $this->prefix . $this->tableName . '
                ' . $insertValues['columns'] . '
            VALUES
                ' . $insertValues['values'] . '
        '
        );

        if (!$s) {
            throw new PDOQueryException('
            INSERT INTO ' . $this->prefix . $this->tableName . '
                ' . $insertValues['columns'] . '
            VALUES
                ' . $insertValues['values'] . '
        ');
        }

        foreach ($attributes as $attribute) {
            $s->bindParam(':' . $attribute, $model->{$attribute});
        }

        if ($s->execute()) {
            return $this->db->lastInsertId();
        }

        return false;
    }

    /**
     * @throws PDOQueryException
     */
    public function save2Identifer(ModelInterface $model, array $attributes = []): bool|int
    {
        $attributes = $attributes === [] ? $model->getCreateValues() : $attributes;

        $insertValues = $this->prepareInsertValues($attributes);

        $s = $this->db->prepare(
            '
            INSERT INTO ' . $this->prefix . $this->tableName . '
                ' . $insertValues['columns'] . '
            VALUES
                ' . $insertValues['values'] . '
        '
        );

        if (!$s) {
            throw new PDOQueryException('
            INSERT INTO ' . $this->prefix . $this->tableName . '
                ' . $insertValues['columns'] . '
            VALUES
                ' . $insertValues['values'] . '
        ');
        }

        foreach ($attributes as $attribute) {
            $s->bindParam(':' . $attribute, $model->{$attribute});
        }

        if ($s->execute()) {
            return true;
        }

        return false;
    }

    /**
     * @throws PDOQueryException
     */
    public function update(ModelInterface $model, array $attributes = [], string $where = '', array $whereParams = []): bool
    {
        if (!isset($model->{$this->class::DB_IDENTIFIER})) {
            throw new \LogicException(
                'Cannot update user that does not yet exist in the database.'
            );
        }
        $attributes = $attributes === [] ? $model->getUpdateValues() : $attributes;
        [$whereParams, $where] = $this->prepareWhere($whereParams, $where);

        $set = $this->prepareSet($attributes);

        $s = $this->db->prepare(
            '
            UPDATE ' . $this->prefix . $this->tableName . '
            SET ' . $set . ' ' . $where
        );

        if (!$s) {
            throw new PDOQueryException('
            UPDATE ' . $this->prefix . $this->tableName . '
            SET ' . $set . ' ' . $where);
        }

        foreach ($attributes as $attribute) {
            $s->bindParam(':' . $attribute, $model->{$attribute});
        }

        foreach ($whereParams as $whereParam) {
            $s->bindParam(':' . $whereParam, $model->{$whereParam});
        }

        return $s->execute();
    }
    public function update2Identifer(ModelInterface $model, array $attributes = [], string $where = '', array $whereParams = []): bool
    {
        if (!isset($model->{$this->class::DB_IDENTIFIER1}) || !isset($model->{$this->class::DB_IDENTIFIER2})) {
            throw new \LogicException(
                'Cannot update that does not yet exist in the database.'
            );
        }
        $attributes = $attributes === [] ? $model->getUpdateValues() : $attributes;
        [$whereParams, $where] = $this->prepareWhere2identifer($whereParams, $where);

        $set = $this->prepareSet($attributes);

        $s = $this->db->prepare(
            '
            UPDATE ' . $this->prefix . $this->tableName . '
            SET ' . $set . ' ' . $where
        );

        if (!$s) {
            throw new PDOQueryException('
            UPDATE ' . $this->prefix . $this->tableName . '
            SET ' . $set . ' ' . $where);
        }

        foreach ($attributes as $attribute) {
            $s->bindParam(':' . $attribute, $model->{$attribute});
        }

        foreach ($whereParams as $whereParam) {
            $s->bindParam(':' . $whereParam, $model->{$whereParam});
        }

        return $s->execute();
    }

    private function prepareWhere(array $whereParams, string $where): array
    {
        $whereParams = $whereParams === [] ? [(string)$this->class::DB_IDENTIFIER] : $whereParams;
        $where = empty($where) ? 'WHERE ' . $this->class::DB_IDENTIFIER . ' = :' . $this->class::DB_IDENTIFIER : $where;

        return [$whereParams, $where];
    }

    private function prepareWhere2identifer(array $whereParams, string $where): array
    {
        $whereParams = $whereParams === [] ? [(string)$this->class::DB_IDENTIFIER1, (string)$this->class::DB_IDENTIFIER2] : $whereParams;
        $where = empty($where) ? 'WHERE ' . $this->class::DB_IDENTIFIER1 . ' = :' . $this->class::DB_IDENTIFIER1 . ' AND ' . $this->class::DB_IDENTIFIER2 . ' = :' . $this->class::DB_IDENTIFIER2  : $where;

        return [$whereParams, $where];
    }

    private function prepareSet(array $attributes): string
    {
        $set = '';

        foreach ($attributes as $attribute) {
            $set .= $attribute . ' = :' . $attribute . ',';
        }

        return rtrim($set, ',');
    }

    private function prepareInsertValues(array $attributes): array
    {
        $insertValues = [
            'columns' => '(',
            'values' => '(',
        ];

        foreach ($attributes as $attribute) {
            $insertValues['columns'] .= $attribute . ',';
        }

        $insertValues['columns'] = rtrim($insertValues['columns'], ',');
        $insertValues['columns'] .= ')';

        foreach ($attributes as $attribute) {
            $insertValues['values'] .= ':' . $attribute . ',';
        }

        $insertValues['values'] = rtrim($insertValues['values'], ',');
        $insertValues['values'] .= ')';

        return $insertValues;
    }

    /**
     * @param string $select
     * @param string $where
     * @param array $params
     *
     * @return \PDOStatement
     * @throws PDOQueryException
     */
    private function getFindPrepare(string $select, string $where, array $params): \PDOStatement
    {
        $s = $this->db->prepare('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' ' . $where . ' ');

        if (!$s) {
            throw new PDOQueryException('SELECT ' . $select . ' FROM ' . $this->prefix . $this->tableName . ' ' . $where . ' ');
        }

        foreach ($params as $keyParam => $param) {
            $s->bindParam($keyParam, $param['value'], $param['type']);
        }

        $s->execute();

        return $s;
    }

    /**
     * @throws PDOQueryException
     */
    public function delete(ModelInterface $model, string $where = '', array $whereParams = []): bool
    {
        if (!(property_exists($model, $this->class::DB_IDENTIFIER) && $model->{$this->class::DB_IDENTIFIER} !== null)) {
            throw new \LogicException(
                'Cannot delete that does not yet exist in the database.'
            );
        }

        [$whereParams, $where] = $this->prepareWhere($whereParams, $where);

        $s = $this->db->prepare(
            '
            DELETE FROM ' . $this->prefix . $this->tableName . '
            ' . $where
        );
        if (!$s) {
            throw new PDOQueryException('
            DELETE FROM ' . $this->prefix . $this->tableName . '
            ' . $where);
        }
        foreach ($whereParams as $whereParam) {
            $s->bindParam(':' . $whereParam, $model->{$whereParam});
        }

        return $s->execute();
    }

    /**
     * @throws PDOQueryException
     */
    public function delete2Identifer(ModelInterface $model, string $where = '', array $whereParams = []): bool
    {
        if (!(property_exists($model, $this->class::DB_IDENTIFIER1) && $model->{$this->class::DB_IDENTIFIER1} !== null) ||
            !(property_exists($model, $this->class::DB_IDENTIFIER2) && $model->{$this->class::DB_IDENTIFIER2} !== null)) {
            throw new \LogicException(
                'Cannot delete that does not yet exist in the database.'
            );
        }

        [$whereParams, $where] = $this->prepareWhere2identifer($whereParams, $where);

        $s = $this->db->prepare(
            '
            DELETE FROM ' . $this->prefix . $this->tableName . '
            ' . $where
        );
        if (!$s) {
            throw new PDOQueryException('
            DELETE FROM ' . $this->prefix . $this->tableName . '
            ' . $where);
        }
        foreach ($whereParams as $whereParam) {
            $s->bindParam(':' . $whereParam, $model->{$whereParam});
        }

        return $s->execute();
    }
}
