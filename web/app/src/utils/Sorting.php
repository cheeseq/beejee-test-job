<?php

declare(strict_types=1);

namespace App\utils;


class Sorting
{
    private string $sortBy;
    private string $direction;

    public const DEFAULT_SORT_KEY = "id";
    public const DEFAULT_DIRECTION = "desc";

    public function __construct(?string $sortBy = 'id', ?string $direction = 'asc')
    {
        $this->sortBy = $sortBy ? $sortBy : self::DEFAULT_SORT_KEY;
        $this->direction = $direction && ($direction == 'asc' || $direction == 'desc') ? $direction : self::DEFAULT_DIRECTION;
    }

    public function getSortBy(): string
    {
        return $this->sortBy;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * Generates HTML sorter link for given key
     *
     * @param string $sortBy
     * @param Sorting $sorting
     * @return string
     */
    public static function renderSorter(string $sortBy, Sorting $sorting): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $inactiveSorter = "<a href='" . $path . $sorting->buildSortingQueryString($sortBy, 'asc') . "'><img src='/assets/sort-no.svg' style='width: 1em; height: 1em'></a>";

        if ($sorting->getSortBy() != $sortBy) {
            return $inactiveSorter;
        }

        if ($sorting->getDirection() == 'asc') {
            return "<a href='" . $path . $sorting->buildSortingQueryString($sortBy, 'desc') . "'><img src='/assets/sort-up.svg' style='width: 1em; height: 1em'></a>";
        } elseif ($sorting->getDirection() == 'desc') {
            return "<a href='" . $path . $sorting->buildSortingQueryString($sortBy, 'asc') . "'><img src='/assets/sort-down.svg' style='width: 1em; height: 1em'></a>";
        }

        return $inactiveSorter;
    }

    public function getSoringQueryString(): string
    {
        if ($this->isDefault()) {
            return "";
        }

        return $this->buildSortingQueryString($this->sortBy, $this->direction);
    }

    public function buildSortingQueryString($sortBy, $direction): string
    {
        return "?sortBy=$sortBy&direction=$direction";
    }

    private function isDefault()
    {
        return $this->sortBy == self::DEFAULT_SORT_KEY && $this->direction == self::DEFAULT_DIRECTION;
    }
}