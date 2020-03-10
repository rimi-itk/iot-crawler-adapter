# Smartcitizen IoT Crawler Adapter Proxy (SCICAP)

## Installation

Copy `config/local.json.dist` to `config/local.json.js` and edit appropriately.

```sh
yarn install
```

## Start the show

Install [pm2](https://pm2.keymetrics.io/).

For development, run

```sh
pm2 start ecosystem.config.js --env=development
```

For deployment, run

```sh
pm2 start ecosystem.config.js
```

After updates, run

```sh
pm2 reload ecosystem.config.js
```

## Coding standards

```sh
yarn coding-standards-check
```

```sh
yarn coding-standards-apply
```