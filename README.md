<p align="center"><img width="200" src="https://github.com/robsontaviano/meadow-ui.com/blob/main/public/images/meadow.png?raw=true"></p>

<p align="center">
    <a href="https://packagist.org/packages/robsontaviano/meadow">
        <img src="https://img.shields.io/packagist/dt/robsontaviano/meadow?cacheSeconds=60">
    </a>
    <a href="https://packagist.org/packages/robsontaviano/meadow">
        <img src="https://img.shields.io/packagist/v/robsontaviano/meadow?label=stable&color=blue&cacheSeconds=60">
    </a>
    <a href="https://packagist.org/packages/robsontaviano/meadow">
        <img src="https://poser.pugx.org/robsontaviano/meadow/license.svg">
    </a>
</p>

## Introduction

The meadowUI package is a set of Gorgeous UI components for Livewire powered by daisyUI and Tailwind.

## Official Documentation

You can read the official documentation on the [meadowUI website](https://meadow-ui.com).

## Sponsor

Let's keep pushing it, [sponsor me](https://github.com/sponsors/robsontaviano) ❤️

## Discord

Come to say hello on [meadowUI Discord](https://discord.gg/c2Dv8T2X2s)

## Follow me

[@robsontaviano](https://twitter.com/robsontaviano)

## Contributing

Clone the repository into your project root.

```bash
git clone git@github.com:robsontaviano/meadow.git packages/meadow
```

Add the local repository to composer config.

```bash
composer config repositories.local '{"type": "path", "url": "packages/meadow"}'
```

Require the package again for local symlink.

```bash
composer require robsontaviano/meadow:@dev
```

Start the dev server.

```bash
yarn dev
```

You can roll back to the stable version by removing the local repository and requiring the package again.

```bash
composer config --unset repositories.local
composer require robsontaviano/meadow
```

## License

<a name="license"></a>

MeadowUI is open-sourced software licensed under the [MIT license](/license.md).
