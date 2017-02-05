<?php
/*
 * WellCommerce Open-Source E-Commerce Platform
 *
 * This file is part of the WellCommerce package.
 *
 * (c) Adam Piotrowski <adam@wellcommerce.org>
 *
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 */
namespace WellCommerce\Bundle\PaymentBundle\Repository;

use WellCommerce\Bundle\CoreBundle\Repository\EntityRepository;
use WellCommerce\Bundle\PaymentBundle\Entity\PaymentMethod;

/**
 * Class PaymentMethodRepository
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class PaymentMethodRepository extends EntityRepository implements PaymentMethodRepositoryInterface
{
    public function getDefaultPaymentMethod(): PaymentMethod
    {
        return $this->findOneBy([], ['hierarchy' => 'asc']);
    }
}
