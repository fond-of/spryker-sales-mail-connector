<?php

namespace FondOfSpryker\Zed\SalesMailConnector\Communication\Plugin\Mail;

use Orm\Zed\Country\Persistence\SpyCountryQuery;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;
use Spryker\Zed\Oms\Communication\Plugin\Mail\OrderConfirmationMailTypePlugin as SprykerOrderConfirmationMailTypePlugin;

class OrderConfirmationMailTypePlugin extends SprykerOrderConfirmationMailTypePlugin
{
    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return void
     */
    public function build(MailBuilderInterface $mailBuilder): void
    {
        parent::build($mailBuilder);

        $this->addIso2CodeToBillingAddress($mailBuilder);
    }

    /**
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return $this
     */
    protected function addIso2CodeToBillingAddress(MailBuilderInterface $mailBuilder)
    {
        $billingAddress = $mailBuilder->getMailTransfer()->getOrder()->getBillingAddress();

        if ($billingAddress->getFkCountry()) {
            $spyCountry = SpyCountryQuery::create()->findOneByIdCountry($billingAddress->getFkCountry());
            $billingAddress->setIso2Code($spyCountry->getIso2Code());
        }

        return $this;
    }
}
