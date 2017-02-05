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

namespace WellCommerce\Bundle\OrderBundle\Calculator;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use WellCommerce\Bundle\OrderBundle\Entity\ShippingMethod;

/**
 * Class WeightTableCalculator
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class WeightTableCalculator implements ShippingCalculatorInterface
{
    /**
     * {@inheritdoc}
     */
    public function calculate(ShippingMethod $shippingMethod, ShippingSubjectInterface $subject): Collection
    {
        return new ArrayCollection();
    }
    
    public function getAlias(): string
    {
        return 'weight_table';
    }
}
