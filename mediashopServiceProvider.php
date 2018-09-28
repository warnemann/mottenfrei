<?php

namespace mediashop\Providers;

use IO\Extensions\Functions\Partial;
use IO\Helper\ComponentContainer;
use IO\Helper\TemplateContainer;
use Plenty\Plugin\Events\Dispatcher;
use Plenty\Plugin\ServiceProvider;
use Plenty\Plugin\Templates\Twig;
/* use IO\Services\ItemSearch\Helper\ResultFieldTemplate; */

class mediashopServiceProvider extends ServiceProvider
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
                                     $templateContainer->setTemplate('mediashop::Homepage.mediashopHomepage');
                                     }, 0);
        
/*        $eventDispatcher->listen('IO.ResultFields.*', function(ResultFieldTemplate $templateContainer)
                                 {
                                     $templateContainer->setTemplates([ResultFieldTemplate::TEMPLATE_SINGLE_ITEM =>'mediashop::ResultFields.SingleItem'
                                                                       ]);
                                     }, 0);
*/        
        $eventDispatcher->listen('IO.init.templates', function(Partial $partial)
                                 {
                                     $partial->set('footer', 'mediashop::PageDesign.Partials.mediashopFooter');
                                     $partial->set('head', 'mediashop::PageDesign.Partials.Header.mediashopHead');
                                     }, 0);
        
        /**
        * Boot a template for the basket that will be displayed in the template plugin instead of the original basket.
        */
        
        $eventDispatcher->listen('IO.Component.Import', function (ComponentContainer $container)
                                 {
                                     if ($container->getOriginComponentTemplate()=='Ceres::Item.Components.SingleItem')
                                         {
                                         $container->setNewComponentTemplate('mediashop::Item.Components.SingleItem');
                                         }

                                      if ($container->getOriginComponentTemplate()=='Ceres::Item.SingleItemWrapper')
                                         {
                                         $container->setNewComponentTemplate('mediashop::Item.mediashopSingleItemWrapper');
                                         }

                                     
                                     
                                              if ($container->getOriginComponentTemplate()=='Ceres::Checkout.Components.AcceptGtcCheck')
                                         {
                                         $container->setNewComponentTemplate('mediashop::Checkout.Components.AcceptGtcCheck');
                                         }
                             
                                 }, self::PRIORITY);
    
}
    }