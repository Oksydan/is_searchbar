<?php

namespace Oksydan\IsSearchbar\Search\DTO;

class SearchDTO
{
    private int $idLang;

    private string $expr;

    private int $perPage;

    public function __construct(int $idLang, string $expr, int $perPage = 1)
    {
        $this->idLang = $idLang;
        $this->expr = $expr;
        $this->perPage = $perPage;
    }

    public function getIdLang(): int
    {
        return $this->idLang;
    }

    public function getExpr(): string
    {
        return $this->expr;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }
}
