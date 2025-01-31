<?php declare(strict_types=1);

namespace Shopware\Core\Checkout\Cart\Facade\Traits;

use Shopware\Core\Checkout\Cart\Facade\CartFacadeHelper;
use Shopware\Core\Checkout\Cart\Facade\ItemFacade;
use Shopware\Core\Checkout\Cart\LineItem\LineItemCollection;
use Shopware\Core\System\SalesChannel\SalesChannelContext;

/**
 * @implements \IteratorAggregate<array-key, \Shopware\Core\Checkout\Cart\LineItem\LineItem>
 */
trait ItemsIteratorTrait
{
    private CartFacadeHelper $helper;

    private LineItemCollection $items;

    private SalesChannelContext $context;

    public function getIterator(): \ArrayIterator
    {
        $items = [];
        foreach ($this->getItems() as $key => $item) {
            $items[$key] = new ItemFacade($item, $this->helper, $this->context);
        }

        return new \ArrayIterator($items);
    }

    private function getItems(): LineItemCollection
    {
        return $this->items;
    }
}
