The Bee Game! :honeybee:

## Instalation
copy the beegame folder to the desired location into your pc
Head inside the beegame folder and run
```shelscript
composer install
```

Then
```shelscript
php -S 0.0.0.0:8080 index.php
```

Head to you browser and type into the url
```shelscript
localhost:8080
```

## Objective

Create a game that generates a beehive with some bees in it.
There must be only one queen bee, some worker bees and some drones


Each bee has hit points a lifespan and the ability if killed kill all bees or not

The queen once dead all bees must die

The queen is the only bee with the previous ability

Each hit takes points from the bee lifespan

Once the bee lifespan gets to 0 the bee dies and gets removed from the beehive

All bee types have different lifespan values 

All bee types have different hit points 

Once all bees are dead the beehive gets reset and the game starts fresh

Each hit should hit a random live bee from the beehive 


### Specifications

    Queen bee   lifeSpan = 100 and damage per hit = 8
    Worker bee  lifeSpan = 75 and damage per hit = 10
    Drone bee   lifeSpan = 50 and damage per hit = 12
    
> More types can be added, the game should allow scaling bee types 

## Interface

No fancy interface is required, only a button that the user can click to hit a bee

## Requirements
Composer 
PHP 7