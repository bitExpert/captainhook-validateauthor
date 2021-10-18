<?php

/*
 * This file is part of the Captain Hook Validate Author plugin package.
 *
 * (c) bitExpert AG
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace bitExpert\CaptainHook\ValidateAuthor;

use CaptainHook\App\Config;
use CaptainHook\App\Console\IO;
use CaptainHook\App\Hook\Action;
use SebastianFeldmann\Cli\Command\Runner\Simple;
use SebastianFeldmann\Cli\Processor\ProcOpen as Processor;
use SebastianFeldmann\Git\Command\Config\Get;
use SebastianFeldmann\Git\Command\Config\ListSettings\MapSettings;
use SebastianFeldmann\Git\Repository;

class ValidateAuthorAction implements Action
{
    /**
     * @var Simple
     */
    private $runner;

    /**
     * Creates new {@link \bitExpert\CaptainHook\ValidateAuthor\ValidateAuthorAction}.
     */
    public function __construct()
    {
        $this->runner = new Simple(new Processor());
    }

    /**
     * Executes the action.
     *
     * @param \CaptainHook\App\Config $config
     * @param \CaptainHook\App\Console\IO $io
     * @param \SebastianFeldmann\Git\Repository $repository
     * @param \CaptainHook\App\Config\Action $action
     * @return void
     * @throws \Exception
     */
    public function execute(Config $config, IO $io, Repository $repository, Config\Action $action): void
    {
        $options = $action->getOptions()->getAll();
        if (count($options) === 0) {
            return;
        }

        if (isset($options['name'])) {
            $userName = $this->getConfig($repository, 'user.name');
            if (!(bool)preg_match($options['name'], $userName)) {
                throw new \RuntimeException(
                    sprintf(
                        'Git user name "%s" does not match regex "%s" in captainhook.json. Check your git config!',
                        $userName,
                        $options['name']
                    )
                );
            }
        }

        if (isset($options['email'])) {
            $userEmail = $this->getConfig($repository, 'user.email');
            if (!(bool)preg_match($options['email'], $userEmail)) {
                throw new \RuntimeException(
                    sprintf(
                        'Git user email "%s" does not match regex "%s" in captainhook.json. Check your git config!',
                        $userEmail,
                        $options['email']
                    )
                );
            }
        }
    }

    /**
     * Returns the given config $setting for given $repository.
     *
     * @param Repository $repository
     * @param string $setting
     * @return string
     */
    protected function getConfig(Repository $repository, string $setting): string
    {
        $cmd = (new Get($repository->getRoot()))
            ->name($setting);

        $result = $this->runner->run($cmd, new MapSettings());
        /** @var array<String> $output */
        $output =$result->getFormattedOutput();
        return (string) key($output);
    }
}
