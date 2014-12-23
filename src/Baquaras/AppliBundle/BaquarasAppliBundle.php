<?php

namespace Baquaras\AppliBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Classe générée automatiquement par le générateur de bundle de symfony
 * @author eh712273
 *
 */
class BaquarasAppliBundle extends Bundle
{
    public function boot()
    {
        $em = $this->container->get('doctrine.orm.entity_manager');
        $evm = $em->getEventManager();
    }
}
