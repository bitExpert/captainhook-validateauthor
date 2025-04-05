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

final class GitIdentity
{
    public function __construct(private string $name, private string $email)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Parses a git identity from an ident string as returned by e.g.
     * `git var GIT_AUTHOR_IDENT` or `git var GIT_COMMITTER_IDENT`.
     *
     * @param string $ident
     * @return self
     */
    public static function fromIdentString(string $ident): self
    {
        if (!(bool)preg_match('/^([^<]+) <([^>]+)>/', $ident, $matches)) {
            throw new \RuntimeException('Could not parse git ident string');
        }

        return new self($matches[1], $matches[2]);
    }
}
