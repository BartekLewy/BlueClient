<?php

namespace BlueClient\Application;


/**
 * Class ItemListFilter
 * @package BlueClient\Application
 */
class ItemListFilter
{
    private const OUT_OF_STOCK = 0;
    private const IN_STOCK = 1;
    private const MORE_THAN_FIVE = 2;

    /**
     * @var array
     */
    private $items;

    /**
     * @var array
     */
    private static $firedFilters = [
        self::OUT_OF_STOCK => false,
        self::IN_STOCK => false,
        self::MORE_THAN_FIVE => false
    ];


    /**
     * ItemListFilter constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param bool $check
     * @return ItemListFilter
     */
    public function inStock(bool $check): self
    {
        self::$firedFilters[self::IN_STOCK] = $check;

        if ($check) {
            foreach ($this->items as $key => $item) {
                if ($item['amount'] < 1) {
                    unset($this->items[$key]);
                }
            }
        }
        return $this;
    }

    /**
     * @param bool $check
     * @return ItemListFilter
     */
    public function outOfStock(bool $check): self
    {
        self::$firedFilters[self::OUT_OF_STOCK] = $check;

        if ($check) {
            foreach ($this->items as $key => $item) {
                if ($item['amount'] != 0) {
                    unset($this->items[$key]);
                }
            }
        }

        return $this;
    }

    /**
     * @return ItemListFilter
     */
    public function moreThanFive(bool $check): self
    {
        self::$firedFilters[self::MORE_THAN_FIVE] = $check;

        if ($check) {
            foreach ($this->items as $key => $item) {
                if ($item['amount'] < 5) {
                    unset($this->items[$key]);
                }
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isAnyExclude()
    {
        return self::$firedFilters[self::OUT_OF_STOCK] && (self::$firedFilters[self::IN_STOCK] || self::$firedFilters[self::MORE_THAN_FIVE]);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->items;
    }
}