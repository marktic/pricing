<?php

use Marktic\Pricing\PriceOptions\Models\PriceOption;

/** @var PriceOption[] $saleable_options */
$saleable_options = $this->saleable_options;
?>
<table>
    <thead>
    <tr>
        <td>
            <?= translator()->trans('name'); ?>
        </td>
        <td>
            <?= translator()->trans('value'); ?>
        </td>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($saleable_options as $option) { ?>
        <tr>
            <td>
                <?= $option->getName(); ?>
            </td>
            <td>
                <?= $option->getValue(); ?>
            </td>
        </tr>
    <?php
    } ?>
    </tbody>
</table>
