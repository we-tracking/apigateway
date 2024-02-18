<?php

namespace App\Console\Commands\Kernel;

use Database\Migration;
use App\Console\Command;
use QueryBuilder\QueryBuilder;
use App\Configuration\Environment;
use QueryBuilder\Connection\Connection;
use App\ORM\Connection\ConnectionHandler;

class MigrationDown extends Command
{
    public $command = "migration:down";
    public $description = "down a Migration";
    public $options = [
        "--version" => "down a specific version",
        "--force" => "forces to down a migration"
    ];
    private ?string $dataBase;

    public function handler()
    {
        $this->setEnvDataBase();
        $this->run($this->getMigrations());
        $this->success(" -- down applied with success");
    }

    private function run(array $migrations): void
    {
        rsort($migrations);
        $count = count($migrations);
        foreach ($migrations as $migration) {
            $executed = $this->execute(
                $this->withNamespace($migration)
            );

            if ($executed) {
                $count--;
            }
        }

        if ($count == count($migrations)) {
            $this->quote("Nothing to down!");
        }
    }

    private function execute(string $namespace): bool
    {
        if (!class_exists($namespace)) {
            throw new \Exception(sprintf("Migration %s not found", $namespace));
        }

        if (!method_exists($namespace, "down")) {
            throw new \Exception(sprintf("Method 'down' not found in %s", $namespace));
        }

        if (!$this->migrationAlreadyApplied($namespace) && !$this->force()) {
            return false;
        }

        $instance = $this->container()->make($namespace);
        $instance->down();
        $this->setApplied($namespace);

        return true;
    }

    private function getMigrationsFiles(): array
    {
        return glob(config("database.migration.path") . "/*.php", );
    }

    private function getMigrations(): array
    {
        if ($this->version() !== null) {
            return [$this->version()];
        }
        
        return array_map(
            fn($file) => pathinfo(basename($file))['filename'],
            $this->getMigrationsFiles()
        );
    }

    private function withNamespace(string $class)
    {
        return $this->getMigrationNamespace() . "\\" . $class;
    }

    private function getMigrationNamespace(): string
    {
        return config("database.migration.namespace");
    }

    private function queryBuilder(): QueryBuilder
    {
        return new QueryBuilder($this->getConnection());
    }

    private function getConnection(): Connection
    {
        return $this->getConnectionHandler()->getConnectionNoDatabase();
    }

    private function getConnectionHandler(): ConnectionHandler
    {
        return resolve(ConnectionHandler::class);
    }

    private function setEnvDataBase(): void
    {
        $this->dataBase = Environment::make()->get("DB_DATABASE");
    }

    private function dataBase(): ?string
    {
        return $this->dataBase;
    }

    private function migrationAlreadyApplied(string $version): bool
    {
        return $this->useDataBase()
            ->select()
            ->from("migration")
            ->where("version", "=", ":version")
            ->addParam(":version", $version)
            ->execute()->count() > 0;
    }

    private function useDataBase(): QueryBuilder
    {
        $query = $this->queryBuilder();
        $query->raw(sprintf("USE %s;", $this->dataBase()))->execute();
        return $query;
    }

    private function setApplied(string $migration): void
    {
        $this->useDataBase()->delete()
            ->from("migration")
            ->where("version", "=", ":version")
            ->addParam(":version", $migration)
            ->execute();

        $this->output(sprintf("Migration '%s' down", $migration));
    }


    private function seed(): bool
    {
        return $this->option("seed") === true;
    }

    private function force(): bool
    {
        return $this->option("force") === true;
    }

    private function version(): ?string
    {
        return $this->option("version");
    }

}