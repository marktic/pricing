<?php

namespace Marktic\Pricing\PriceAdjustments\Subscribers;

use Marktic\Pricing\PriceAdjustments\Models\PriceAdjustment;
use Nip\Records\EventManager\Events\Event;

abstract class AbstractSubscriber
{
    protected function handle(Event $event)
    {
        /** @var PriceAdjustment $item */
        $item = $event->getRecord();

        $this->notifySaleable($item, $event);
    }

    /**
     * @param PriceAdjustment $item
     * @param $event
     * @return void
     */
    protected function notifySaleable($item, $event)
    {
        $this->notifySubscriber($item->getSalesable(), $item, $event);
    }

    /**
     * @param PriceAdjustment $item
     * @param $event
     * @return void
     */
    protected function notifyTrigger($item, $event)
    {
        $this->notifySubscriber($item->getPricingTrigger(), $item, $event);
    }

    /**
     * @param $subscriber
     * @param $priceAdjustment
     * @param $event
     * @return void
     */
    protected function notifySubscriber($subscriber, $priceAdjustment, $event)
    {
        if(false === is_object($subscriber)){
            return;
        }
        if (false === method_exists($subscriber, 'onPriceAdjustmentEvent')) {
            return;
        }

        $subscriber->onPriceAdjustmentEvent($priceAdjustment, $event);
    }
}
