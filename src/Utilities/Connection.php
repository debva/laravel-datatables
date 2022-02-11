<?php

namespace Debva\Utilities;

trait Connection
{
    protected $connection;
    
    /**
     * @return void
     */
    protected function setConnection()
    {
        $this->connection = \DB::connection()->getDriverName();
    }

    /**
     * @return string
     */
    public function getConnection(): string
    {
        return $this->connection;
    }

    /**
     * @return string
     */
    public function getOperator(): string
    {
        return $this->connection === 'pgsql' ? 'ILIKE' : 'LIKE';
    }
}
