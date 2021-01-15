<?php


namespace app\core;


abstract class DBModel extends Model
{

    abstract public function tableName(): string;

    abstract public function attributes() :array;

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

    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}