<?php

namespace mottenfrei\Providers;

use IO\Extensions\Functions\Partial;
use IO\Helper\ComponentContainer;
use IO\Helper\TemplateContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
/* use IO\Services\ItemSearch\Helper\ResultFieldTemplate; */

class mottenfreiServiceProvider extends ServiceProvider
    {
    const PRIORITY = 0;
    
    /**
    * Register the service provider.
    */
    
    public function register()
        {
        }
    
    /**
    * Boot a template for the footer that will be displayed in the template plugin instead of the original footer.
    */
    
    public function boot(Twig $twig, Dispatcher $eventDispatcher)
        {
        $eventDispatcher->listen('IO.tpl.home', function(TemplateContainer $templateContainer)
                                 {
                                     $templateContainer->setTemplate('mottenfrei::Homepage.mottenfreiHomepage');
                                     }, 0);
        
/*        $eventDispatcher->listen('IO.ResultFields.*', function(ResultFieldTemplate $templateContainer)
                                 {
                                     $templateContainer->setTemplates([ResultFieldTemplate::TEMPLATE_SINGLE_ITEM =>'mottenfrei::ResultFields.SingleItem'
                                                                       ]);
                                     }, 0);
*/        
        $eventDispatcher->listen('IO.init.templates', function(Partial $partial)
                                 {
                                     $partial->set('footer', 'mottenfrei::PageDesign.Partials.mottenfreiFooter');
                                     $partial->set('head', 'mottenfrei::PageDesign.Partials.Header.mottenfreiHead');
                                     }, 0);
        
        /**
        * Boot a template for the basket that will be displayed in the template plugin instead of the original basket.
        */
        
        $eventDispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
                                 {
                                     if ($container->getOriginComponentTemplate()=='Ceres::Item.Components.SingleItem')
                                         {
                                         $container->setNewComponentTemplate('mottenfrei::Item.Components.SingleItem');
                                         }

                                      if ($container->getOriginComponentTemplate()=='Ceres::Item.SingleItemWrapper')
                                         {
                                         $container->setNewComponentTemplate('mottenfrei::Item.mottenfreiSingleItemWrapper');
                                         }

                                     
                                     
                                              if ($container->getOriginComponentTemplate()=='Ceres::Checkout.Components.AcceptGtcCheck')
                                         {
                                         $container->setNewComponentTemplate('mottenfrei::Checkout.Components.AcceptGtcCheck');
                                         }
                             
                                 }, self::PRIORITY);
    
}
    }