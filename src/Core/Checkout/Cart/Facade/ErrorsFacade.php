<?php declare(strict_types=1);

namespace Shopware\Core\Checkout\Cart\Facade;

use Shopware\Core\Checkout\Cart\Error\Error;
use Shopware\Core\Checkout\Cart\Error\ErrorCollection;
use Shopware\Core\Checkout\Cart\Error\GenericCartError;

/**
 * @implements \IteratorAggregate<array-key, \Shopware\Core\Checkout\Cart\Error\Error>
 */
class ErrorsFacade implements \IteratorAggregate
{
    private ErrorCollection $collection;

    public function __construct(ErrorCollection $collection)
    {
        $this->collection = $collection;
    }

    public function error(string $key, ?string $id = null, array $parameters = []): void
    {
        $this->createError($key, true, $parameters, Error::LEVEL_ERROR, $id);
    }

    public function warning(string $key, ?string $id = null, array $parameters = []): void
    {
        $this->createError($key, false, $parameters, Error::LEVEL_WARNING, $id);
    }

    public function notice(string $key, ?string $id = null, array $parameters = []): void
    {
        $this->createError($key, false, $parameters, Error::LEVEL_NOTICE, $id);
    }

    public function has(string $key): bool
    {
        return $this->collection->has($key);
    }

    public function remove(string $key): void
    {
        $this->collection->remove($key);
    }

    public function get(string $key): ?Error
    {
        return $this->collection->get($key);
    }

    public function getIterator(): \Traversable
    {
        yield from $this->collection;
    }

    private function createError(string $key, bool $block, array $parameters, int $level, ?string $id = null): void
    {
        $this->collection->add(
            new GenericCartError($id ?? $key, $key, $parameters, $level, $block, true)
        );
    }
}
