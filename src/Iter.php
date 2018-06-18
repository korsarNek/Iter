<?php declare(strict_types=1);

namespace Iter;

/**
 * @method Iter takeWhile(callable $predicate)
 * @method Iter take(int $count)
 * @method Iter skipWhile(callable $predicate)
 * @method Iter skip(int $count)
 * @method Iter where(callable $predicate)
 * @method Iter map(callable $mapper)
 * @method Iter flatten()
 * @method Iter concat(iterable ...$other)
 * @method Iter reverse()
 * @method Iter orderDescending(int $sortFlags = SORT_REGULAR)
 * @method Iter orderAscending(int $sortFlags = SORT_REGULAR)
 * @method Iter order(callable $sorter)
 */
final class Iter
{
    /** @var iterable */
    private $items;

    private function __construct(iterable $items)
    {
        $this->items = $items;
    }

    public static function from(iterable $items) : Iter
    {
        return new Iter($items);
    }

    public function __call(string $name, array $arguments) : Iter
    {
        $this->items = Functions::{$name}($this->items, ...$arguments);

        return $this;
    }

    public function get() : iterable
    {
        return $this->items;
    }

    public function toArray(bool $preserveKeys = false) : array
    {
        return Functions::toArray($this->items, $preserveKeys);
    }

    public function first()
    {
        return Functions::first($this->items);
    }

    public function last()
    {
        return Functions::last($this->items);
    }
}