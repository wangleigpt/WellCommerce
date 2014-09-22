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
namespace WellCommerce\Bundle\LayoutBundle\Form;

use Symfony\Component\Finder\Finder;
use WellCommerce\Bundle\CoreBundle\Form\AbstractForm;
use WellCommerce\Bundle\CoreBundle\Form\Builder\FormBuilderInterface;
use WellCommerce\Bundle\CoreBundle\Form\Elements\ElementInterface;
use WellCommerce\Bundle\CoreBundle\Form\FormInterface;
use WellCommerce\Bundle\CoreBundle\Form\Option;
use WellCommerce\Bundle\LayoutBundle\Form\DataTransformer\ColumnCollectionToArrayTransformer;

/**
 * Class LayoutPageForm
 *
 * @package WellCommerce\LayoutPage\Form
 * @author  Adam Piotrowski <adam@wellcommerce.org>
 */
class LayoutPageForm extends AbstractForm implements FormInterface
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $layoutPages = $this->get('layout_page.repository')->findAll();
        $layoutBoxes = $this->get('layout_box.repository')->findAll();

        $form = $builder->init($options);

        /**
         * @var \WellCommerce\Bundle\LayoutBundle\Entity\LayoutPage $layoutPage
         */
        foreach ($layoutPages as $layoutPage) {

            $columnData = $form->addChild($builder->getElement('fieldset', [
                'name'  => $layoutPage->getId(),
                'label' => $layoutPage->getName()
            ]));

            $columnDataColumns = $columnData->addChild($builder->getElement('fieldset_repeatable', [
                'name'        => 'columns',
                'repeat_min'  => 1,
                'repeat_max'  => ElementInterface::INFINITE,
                'transformer' => new ColumnCollectionToArrayTransformer($this->get('layout_page.repository'))
            ]));

            $columnDataColumns->addChild($builder->getElement('tip', [
                'tip'         => '<p>' . $this->trans('To extend the column to all remaining width please enter') . ' <strong>0</strong>.</p>',
                'retractable' => false
            ]));

            $columnDataColumns->addChild($builder->getElement('text_field', [
                'name'    => 'xs',
                'label'   => $this->trans('Extra small devices'),
                'comment' => $this->trans('Phones (<768px)'),
            ]));

            $columnDataColumns->addChild($builder->getElement('text_field', [
                'name'   => 'sm',
                'label'  => $this->trans('Small devices'),
                'comment' => $this->trans('Tablets (≥768px)'),
            ]));

            $columnDataColumns->addChild($builder->getElement('text_field', [
                'name'   => 'md',
                'label'  => $this->trans('Medium devices'),
                'comment' => $this->trans('Desktops (≥992px)'),
            ]));

            $columnDataColumns->addChild($builder->getElement('text_field', [
                'name'   => 'lg',
                'label'  => $this->trans('Large devices'),
                'comment' => $this->trans('Desktops (≥1200px)'),
            ]));

            $pageBoxes = $this->getBoxesForPage($layoutPage->getName(), $layoutBoxes);

            $columnDataColumns->addChild($builder->getElement('layout_boxes_list', [
                'name'  => 'boxes',
                'label' => $this->trans('Choose boxes'),
                'boxes' => Option::make($pageBoxes)
            ]));
        }


        $form->addFilter('no_code');
        $form->addFilter('trim');
        $form->addFilter('secure');

        return $form;
    }

    /**
     * Returns only boxes available for chosen page
     *
     * @param $page
     * @param $layoutBoxes
     *
     * @return array
     */
    public function getBoxesForPage($page, $layoutBoxes)
    {
        $boxes = [];

        /**
         * @var \WellCommerce\Bundle\LayoutBundle\Entity\LayoutBox $layoutBox
         */
        foreach ($layoutBoxes as $layoutBox) {
            $layoutBoxType = $layoutBox->getBoxType();
            if ($layoutBoxType->hasConfiguratorService()) {
                $configurator = $layoutBoxType->getConfiguratorService();
                if ($configurator->isAvailableForLayoutPage($page)) {
                    $boxes[$layoutBox->getId()] = $layoutBox->translate()->getName();
                }
            } else {
                $boxes[$layoutBox->getId()] = $layoutBox->translate()->getName();
            }
        }

        return $boxes;
    }
}
