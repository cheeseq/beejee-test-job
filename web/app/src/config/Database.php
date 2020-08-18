<?php

declare(strict_types=1);

namespace App\config;


use Illuminate\Database\Capsule\Manager as Capsule;

class Database
{
    public function initialize()
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            "driver" => "mysql",
            "host" => $_ENV["MYSQL_HOST"],
            "database" => $_ENV["MYSQL_DATABASE"],
            "username" => $_ENV["MYSQL_ROOT_USER"],
            "password" => $_ENV["MYSQL_ROOT_PASSWORD"],
            "charset" => "utf8",
            "collation" => "utf8_unicode_ci",
            "prefix" => "",
        ]);

        $capsule->bootEloquent();
    }
}