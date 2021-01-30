# bitexpert/captainhook-validateauthor

This package provides an action for [Captain Hook](https://github.com/CaptainHookPhp/captainhook) which will reject a commit when author name or email does not match a regex defined in the `captainhook.json` configuration file. Use this action if you want to make sure that your private email address does not end up in your companies' git repositories.

[![Build Status](https://github.com/bitExpert/captainhook-validateauthor/workflows/ci/badge.svg?branch=master)](https://github.com/bitExpert/captainhook-validateauthor/actions)
[![Coverage Status](https://coveralls.io/repos/github/bitExpert/captainhook-validateauthor/badge.svg?branch=master)](https://coveralls.io/github/bitExpert/captainhook-validateauthor?branch=master)
[![Infection MSI](https://badge.stryker-mutator.io/github.com/bitExpert/captainhook-validateauthor/master)](https://infection.github.io)


## Installation

The preferred way of installing `bitexpert/captainhook-validateauthor` is through Composer.
You can add `bitexpert/captainhook-validateauthor` as a dev dependency, as follows:

```
composer.phar require --dev bitexpert/captainhook-validateauthor
```

## Usage

Add the following code to your `captainhook.json` configuration file:

```
{
  "pre-commit": {
    "enabled": true,
    "actions": [
      {
        "action": "\\bitExpert\\CaptainHook\\ValidateAuthor\\ValidateAuthorAction",
        "options": {
            "name": "/^[A-Za-z0-09]+$/",
            "email": "/@example.com$/"
        }
      }
    ]
  }
}
```

[Captain Hook](https://github.com/CaptainHookPhp/captainhook) will now check
on every commit if author name and email match the defined regex. If not, the commit
will be canceled.

## Contribute

Please feel free to fork and extend existing or add new features and send a pull request with your changes! To establish a consistent code quality, please provide unit tests for all your changes and adapt the documentation.

## Want To Contribute?

If you feel that you have something to share, then we’d love to have you.
Check out [the contributing guide](CONTRIBUTING.md) to find out how, as well as what we expect from you.

## License

Captain Hook Validate Author Action is released under the Apache 2.0 license.
