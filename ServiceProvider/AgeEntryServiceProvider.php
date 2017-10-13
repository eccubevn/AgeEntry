<?php

namespace Plugin\AgeEntry\ServiceProvider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Plugin\AgeEntry\Form\Extension\EntryTypeExtension;

/**
 * Class AgeEntryServiceProvider
 * @package Plugin\AgeEntry\ServiceProvider
 */
class AgeEntryServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app->extend(
            'form.type.extensions',
            function ($extensions) use ($app) {
                $extensions[] = new EntryTypeExtension($app);

                return $extensions;
            }
        );
    }
}
