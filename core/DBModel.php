<?php


namespace app\core;


abstract class DBModel extends Model
{

    abstract public function tableName(): string;

    abstract public function attributes() :array;

    abstract public function primaryKey() : string;

    public function save()
    {
        $tablename = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tablename (".implode(',', $attributes) . ") VALUES (".implode(',', $params) . ")");

        foreach ($attributes as $attribute){
            $statement->bindValue("$attribute", $this->{$attribute});
        }

        $statement->execute();
        return true;
    }

    public function findOne($where) // [email => amaframe@gmail.com, firstname => amaframe]
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        // select * from $tableName where email = :email AND firstnme;
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }

        $statement->execute();
        return $statement->fetchObject(static::class);
    }

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}