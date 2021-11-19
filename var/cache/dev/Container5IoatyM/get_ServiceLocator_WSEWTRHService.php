<?php

namespace Container5IoatyM;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_WSEWTRHService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.wSEWTRH' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.wSEWTRH'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'dealRepository' => ['privates', 'App\\Repository\\DealRepository', 'getDealRepositoryService', true],
            'paginator' => ['services', 'knp_paginator', 'getKnpPaginatorService', true],
        ], [
            'dealRepository' => 'App\\Repository\\DealRepository',
            'paginator' => '?',
        ]);
    }
}