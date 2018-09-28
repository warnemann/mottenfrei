<?php

namespace mottenfrei\Containers;

use Plenty\Plugin\Templates\Twig;

class mottenfreiContainer
{
    public function call(Twig $twig):string
    {
        return $twig->render('mottenfrei::content.mottenfrei');
    }
}