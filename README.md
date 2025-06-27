# API Backend in PHP

This repository includes a minimal REST API implemented in PHP. It provides basic CRUD operations for managing a list of items stored in `data/items.json`.

## Requirements
- PHP 7.4 or newer

## Running the server
Use PHP's built-in web server:

```bash
php -S localhost:8000
```

The API will be available at `http://localhost:8000`. Example endpoints:
- `GET /items` – list all items
- `POST /items` – create a new item (`{"name": "Item name"}`)
- `GET /items/{id}` – fetch a specific item
- `PUT /items/{id}` – update an item
- `DELETE /items/{id}` – delete an item

Data is persisted in `data/items.json`.

