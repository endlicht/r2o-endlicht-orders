# [Café Endlicht](https://www.htwg-konstanz.de/hochschule/einrichtungen/asta/cafe-endlicht/) backend for [ready2order pOS system](https://ready2order.com/de/)

## Getting started

1. Install `php` and `composer`.
2. Install dependencies with `composer` via `composer install`.
3. Register at [ready2order](https://ready2order.com/at/api/) as developer and get an API token.
4. Save API token in `.env` file. See below.
5. Start the editor and call `composer dev` in the command line. This will start a development server at `localhost:8000`.
6. You're ready to go.

### `.env` file

```env
DEVELOPER_TOKEN=eyJ0eXAiO...
```
