<?php

/**
 * @file
 * Room structure definition.
 *
 * @see Itafroma\Zork\Struc\StrucInterface
 * @see Itafroma\Zork\newstruc()
 */

namespace Itafroma\Zork\Struc;

class Room implements StrucInterface
{
    /** @var string $rid Room ID */
    public $rid;

    /** @var string $rdesc1 Long description */
    public $rdesc1;

    /** @var string $2desc2 Short description */
    public $rdesc2;

    /** @var EXIT $rexits List of exits */
    public $rexits;

    /** @var Itafroma\Zork\Struc\Object[] $robjs Objects in room */
    public $robjs;

    /** @var RAPPLIC $raction Room-action */
    public $raction;

    /** @var int $rbits Random flags */
    public $rbits;

    /** @var array $rprops Property list */
    public $rprops = [];
}
