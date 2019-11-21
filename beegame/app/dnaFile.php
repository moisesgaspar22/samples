<?php
/**
 * DNA object to be handled by the beehive factory
 * Need a new bee species/type? no problem, just add a new amount/dna node
 * and you're good to go
 */
return [
    /**
     * This is the queen DNA, there can be only one queen!
     */
    [
        'amount'    => 1,
        'dna'       => [
            'type'      => 'queen',
            'lifeSpan'  => 100,
            'killAll'   => true,
            'hitPoints' => 8
        ]
    ],
    /**
     * This is the worker bee DNA
     */
    [
        'amount'    => 5,
        'dna'       => [
            'type'      => 'worker',
            'lifeSpan'  => 75,
            'killAll'   => false,
            'hitPoints' => 10
        ]
    ],
    /**
     * This is the drone bee DNA
     */
    [
        'amount'    => 8,
        'dna'       => [
            'type'      => 'drone',
            'lifeSpan'  => 50,
            'killAll'   => false,
            'hitPoints' => 12
        ]
    ]
];
