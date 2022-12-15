<?php

namespace Juzaweb\CMS\Repositories\Events;

use Juzaweb\CMS\Support\Repository\Events\RepositoryEventBase;

/**
 * Class RepositoryEntityDeleted
 *
 * @package Prettus\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityDeleting extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleting";
}