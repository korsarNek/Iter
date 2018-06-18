<?php declare(strict_types=1);

namespace Iter;

final class Functions
{
    /*
     * It's forbidden to use functions that use the array pointer.
     * That would introduce state into these functions which is a source of not obvious errors.
     * 
     * We don't offer versions of these functions that work on keys instead of values to prevent function bloat.
     */

    private function __construct() {}

    public static function takeWhile(iterable $items, callable $predicate) : iterable
    {
        foreach ($items as $key => $item) {
            if ($predicate($key, $item)) {
                yield $key => $item;
            } else {
                break;
            }
        }
    }

    public static function take(iterable $items, int $count) : iterable
    {
        $i = 0;
        foreach ($items as $key => $item) {
            if ($i++ >= $count) {
                break;
            }
            yield $key => $item;
        }
    }

    public static function skipWhile(iterable $items, callable $predicate) : iterable
    {
        $skipping = true;
        foreach ($items as $key => $item) {
            if ($skipping && $predicate($key, $item)) {
                continue;
            } else {
                $skipping = false;
                yield $key => $item;
            }
        }
    }

    public static function skip(iterable $items, int $count) : iterable
    {
        $i = 0;
        foreach ($items as $key => $item) {
            if ($i++ < $count) {
                continue;
            }
            yield $key => $item;
        }
    }

    public static function where(iterable $items, callable $predicate) : iterable
    {
        foreach ($items as $key => $item) {
            if ($predicate($key, $item)) {
                yield $key => $item;
            }
        }
    }

    public static function map(iterable $items, callable $mapper) : iterable
    {
        foreach ($items as $key => $item) {
            yield $key => $mapper($item);
        }
    }

    public static function orderDescending(iterable $items, int $sortFlags = SORT_REGULAR) : array
    {
        if (!is_array($items)) {
            $items = self::toArray($items, true);
        }

        arsort($items, $sortFlags);

        return $items;
    }

    public static function order(iterable $items, callable $sorter) : array
    {
        if (!is_array($items)) {
            $items = self::toArray($items, true);
        }

        uasort($items, $sorter);

        return $items;
    }

    public static function orderAscending(iterable $items, int $sortFlags = SORT_REGULAR) : array
    {
        if (!is_array($items)) {
            $items = self::toArray($items, true);
        }

        asort($items, $sortFlags);

        return $items;
    }

    public static function concat(iterable $first, iterable ...$next) : iterable
    {
        yield from $first;
        foreach ($next as $set) {
            yield from $set;
        }
    }

    public static function flatten(iterable $items) : iterable
    {
        foreach ($items as $subItems) {
            if (is_iterable($subItems)) {
                yield from self::flatten($subItems);
            } else {
                yield $subItems;
            }
        }
    }

    public static function reverse(iterable $items) : array
    {
        if (!is_array($items)) {
            $items = self::toArray($items, true);
        }

        return array_reverse($items);
    }

    public static function last(iterable $items)
    {
        if (is_array($items) && count($items) > 0) {
            return $items[array_keys($items)[count($items) - 1]];
        }

        $value = null;
        foreach ($items as $item) {
            $value = $item;
        }

        return $value;
    }

    //lastByValue and lastByKey would just be combinations of where() and last().

    public static function first(iterable $items)
    {
        foreach ($items as $item) {
            return $item;
        }

        return null;
    }

    //firstByValue and firstByKey would just be combinations of skipWhile() and first()

    public static function toArray(iterable $items, bool $preserveKeys = false) : array
    {
        if (is_array($items)) {
            if ($preserveKeys) {
                return $items;
            } else {
                return array_values($items);
            }
        }

        return iterator_to_array($items, $preserveKeys);
    }
}
