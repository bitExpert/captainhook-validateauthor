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
use SebastianFeldmann\Git\Repository;

class ValidateAuthorAction implements Action
{
    /**
     * Creates new {@link \bitExpert\CaptainHook\ValidateAuthor\ValidateAuthorAction}.
     */
    public function __construct()
    {
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

        $authorIdentity = $this->getGitAuthorIdentity($repository);

        if (isset($options['name'])) {
            $userName = $authorIdentity->getName();
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
            $userEmail = $authorIdentity->getEmail();
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

    protected function getGitAuthorIdentity(Repository $repository): GitIdentity
    {
        $gitAuthorIdentString = $repository->getConfigOperator()->getVar('GIT_AUTHOR_IDENT');
        return GitIdentity::fromIdentString($gitAuthorIdentString);
    }
}
