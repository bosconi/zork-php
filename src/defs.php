<?php

/**
 * @file
 * Defines.
 */

namespace Itafroma\Zork;

use Itafroma\Zork\Struc\Adv;
use Itafroma\Zork\Struc\ZObject;
use Itafroma\Zork\Struc\Room;
use Itafroma\Zork\Struc\StrucInterface;
use Itafroma\Zork\Struc\Syntax;
use \InvalidArgumentException;
use function Itafroma\Zork\flagword;
use function Itafroma\Zork\make_slot;
use function Itafroma\Zork\setg;

// Generalized oflags tester

function trnn(ZObject $obj, $bit) {
    return ($bit & $obj->oflags) !== 0;
}

function rtrnn(Room $rm, $bit) {
    return ($bit & $rm->rbits) !== 0;
}

function gtrnn(Room $rm, $bit) {
    return ($bit & $rm->rglobal) !== 0;
}

function rtrz(Room $rm, $bit) {
    $rm->rbits &= ($bit ^ -1);

    return $rm->rbits;
}

function trc(ZObject $obj, $bit) {
    $obj->oflags ^= $bit;

    return $obj->oflags;
}

function trz(ZObject $obj, $bit) {
    $obj->oflags &= ($bit ^ -1);

    return $obj->oflags;
}

function tro(ZObject $obj, $bit) {
    $obj->oflags |= $bit;

    return $obj->oflags;
}

function rtro(Room $rm, $bit) {
    $rm->rbits |= $bit;

    return $rm->rbits;
}

function rtrc(Room $rm, $bit) {
    $rm->rbits ^= $bit;

    return $rm->rbits;
}

function atrnn(Adv $adv, $bit) {
    return ($bit & $adv->aflags) !== 0;
}

function atrz(Adv $adv, $bit) {
    $adv->aflags &= ($bit ^ -1);

    return $adv->aflags;
}

function atro(Adv $adv, $bit) {
    $adv->aflags |= $bit;

    return $adv->aflags;
}

// Slots for room
make_slot('RVAL', 0);

// Value for entering
make_slot('RGLOBAL', gval('STAR_BITS'));

// Globals for room
flagword(...[
    'RSEENBIT',   // Visited?
    'RLIGHTBIT',  // Endogenous light source?
    'RLANDBIT',   // On land
    'RWATERBIT',  // Water room
    'RAIRBIT',    // Mid-air room
    'RSACREDBIT', // Thief not allowed
    'RFILLBIT',   // Can fill bottle here
    'RMUNGBIT',   // Room has been munged
    'RBUCKBIT',   // This room is a bucket
    'RHOUSEBIT',  // This room is part of the house
    'RENDGAME',   // This room is in the end game
    'RNWALLBIT',  // This room doesn't have walls
]);

// SFLAGs of a SYNTAX
flagword(...[
    'SFLIP', // T -- Flip args (for verbs like PICK)
    'SDRIVER', // T -- Default syntax for gwimming (sic) and orphanery
]);

/**
 * Test a bit in the SFLAGs slot of a SYNTAX
 *
 * @param Itafroma\Zork\Struc\Syntax $s   The syntax to test
 * @param int                       $bit The bit to test
 * @return boolean FALSE if bit is set, TRUE otherwise
 */
function strnn(Syntax $s, $bit) {
    return ($bit & $s->sflags) !== 0;
}

/**
 * Retrieves an object property.
 *
 * @param Itafroma\Zork\Struc\StrucInterface $o The object to access.
 * @param mixed                              $p The property to retrieve.
 * @return mixed The property value.
 */
function oget(StrucInterface $o, $p) {
    if (!($o instanceof ZObject || $o instanceof Room)) {
        throw new InvalidArgumentException('$o must be of type Itafroma\Zork\Struc\Object or Itafroma\Zorks\Struc\Room');
    }

    $v = ($o instanceof ZObject) ? $o->oprops : $o->rprops;

    if (empty($v)) {
        return null;
    }

    return isset($v[$p]) ? $v[$p] : null;
}

/**
 * Sets an object property.
 *
 * @param Itafroma\Zork\Struc\StrucInterface $o The object to modify.
 * @param mixed                              $p The property to modify.
 * @param mixed                              $x The value to set.
 */
function oput(StrucInterface $o, $p, $x, $add = true) {
    if (!($o instanceof ZObject || $o instanceof Room)) {
        throw new InvalidArgumentException('$o must be of type Itafroma\Zork\Struc\Object or Itafroma\Zork\Struc\Room');
    }

    $v = ($o instanceof ZObject) ? $o->oprops : $o->rprops;

    if ((empty($v) && $add) || isset($v[$p])) {
        if ($o instanceof ZObject) {
            $o->oprops[$p] = $x;
        }
        else {
            $o->rprops[$p] = $x;
        }
    }

    return $o;
}

setg('ROOMS', []);

setg('OBJECTS', []);

setg('ACTORS', []);
