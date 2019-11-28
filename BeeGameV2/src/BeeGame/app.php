<?php

namespace BeeGame;

use Pimple\Container;
use BeeGame\Container\Log;
use BeeGame\Container\BeeProvider;
use BeeGame\Container\BeeHiveProvider;
use BeeGame\Container\GameMechanicsProvider;

class app
{
    /**
     * container placeholder
     *
     * @var Pimple\Container
     */
    public $container;

    /**
     * Several providers
     *
     * @var stdClass
     */
    private $providers;

    /**
     *
     * @param Container $container
     */
    public function __construct(Container $container = null)
    {
        if(!$container) {
            $this->container = new Container(['name' => 'BeeGame']);
        } else {
            $this->container = $container;
        }

        $this->providers = new class{};
    }

    /**
     * Initiate all required code settings and services
     *
     * @return void
     */
    public function init()
    {
        $this->loadSettings();
        $this->loadServiceProviders();
        $this->startGame();
    }

    /**
     * Load some settings
     *
     * @return void
     */
    protected function loadSettings()
    {
        $this->container[BeeProvider::INSTRUCTIONS_PATH] = sprintf('%s/Game/DnaFile.php', realpath(__DIR__));
    }

    /**
     * Start the aplication
     *
     * @return void
     */
    protected function startGame()
    {
        if (!empty($_SESSION['bees'])) {
            $this->container[GameMechanicsProvider::NAME_HIT_BEE];
        } else {
            $this->container[GameMechanicsProvider::NAME_INIT];
        }
    }

    /**
     * Load all providers
     *
     * @return void
     */
    protected function loadServiceProviders()
    {
        $this->providers->logger     = new Log();
        $this->providers->bee        = new BeeProvider();
        $this->providers->beeHive    = new BeeHiveProvider();
        $this->providers->GMProvider = new GameMechanicsProvider();

        // register all providers
        foreach($this->providers as $provider){
            $this->container->register( $provider );
        }
    }

    /**
     * return the main container
     *
     * @return void
     */
    public function container() {
        return $this->container;
    }
}
