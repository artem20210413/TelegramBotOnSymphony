<?php


namespace App\Services\Telegram\Message;


use JetBrains\PhpStorm\ArrayShape;

class GetUpdateParams implements IToArray
{

    private int $offset = 0;
    private int $limit = 100;
    private int $timeout = 0;

    public static function create(int $offset = null, int $limit = null, int $timeout = null): GetUpdateParams
    {
        $new = new self();
        $new->setOffset($offset)
            ->setLimit($limit)
            ->setTimeout($timeout);

        return $new;
    }

    /**
     * @return int
     */
    public function getOffset(): int
    {
        return $this->offset;
    }

    /**
     * @param int $offset
     */
    private function setOffset(?int $offset): self
    {
        $this->offset = $offset ?? $this->offset;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    private function setTimeout(?int $timeout): self
    {
        $this->timeout = $timeout ?? $this->timeout;

        return $this;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @param int $limit
     */
    private function setLimit(?int $limit): self
    {
        $this->limit = $limit ?? $this->limit;

        return $this;
    }

    #[ArrayShape(['offset' => "int", 'limit' => "int", 'timeout' => "int"])]
    public function toArray(): array
    {
        return [
            'offset' => $this->getOffset(),
            'limit' => $this->getLimit(),
            'timeout' => $this->getTimeout(),
        ];
    }


}
