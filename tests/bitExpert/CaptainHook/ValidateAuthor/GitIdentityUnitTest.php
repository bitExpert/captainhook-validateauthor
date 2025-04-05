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

use PHPUnit\Framework\TestCase;

class GitIdentityUnitTest extends TestCase
{
    /**
     * @test
     * @see https://git-scm.com/docs/git-var#_examples
     */
    public function parsesGitIdentStringToNameAndEmail(): void
    {
        $ident = GitIdentity::fromIdentString('Eric W. Biederman <ebiederm@lnxi.com> 1121223278 -0600');
        self::assertSame('Eric W. Biederman', $ident->getName());
        self::assertSame('ebiederm@lnxi.com', $ident->getEmail());
    }
}
