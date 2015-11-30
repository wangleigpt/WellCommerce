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

namespace WellCommerce\Bundle\AppBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use WellCommerce\Bundle\CoreBundle\DataFixtures\AbstractDataFixture;

/**
 * Class LoadCompanyData
 *
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LoadCompanyData extends AbstractDataFixture
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $fakerGenerator = $this->getFakerGenerator();
        $company        = $this->container->get('company.factory')->create();
        $company->setName($fakerGenerator->company . ' ' . $fakerGenerator->companySuffix);
        $company->setShortName($fakerGenerator->company);
        $company->getAddress()->setCountry($fakerGenerator->countryCode);
        $company->getAddress()->setStreet($fakerGenerator->streetName);
        $company->getAddress()->setStreetNo($fakerGenerator->streetSuffix);
        $company->getAddress()->setFlatNo($fakerGenerator->randomNumber());
        $company->getAddress()->setPostCode($fakerGenerator->postcode);
        $company->getAddress()->setCity($fakerGenerator->city);
        $manager->persist($company);
        $manager->flush();

        $this->setReference('company', $company);
    }
}
