# Products API Documentation

## Base URL
```
http://localhost:8000/api
```

## Available Endpoints

### 1. Get All Products
**Endpoint:** `GET /api/products`

**Description:** Retrieve all products from the database

**Response Example:**
```json
[
  {
    "id": 1,
    "name": "Laptop Pro",
    "slug": "laptop-pro",
    "description": "High performance laptop with 16GB RAM",
    "price": "1299.99",
    "stock": 15,
    "sku": "LAP-PRO-001",
    "active": 1,
    "created_at": "2026-06-12T10:30:00.000000Z",
    "updated_at": "2026-06-12T10:30:00.000000Z"
  },
  ...
]
```

---

### 2. Get Single Product
**Endpoint:** `GET /api/products/{id}`

**Description:** Retrieve a specific product by ID

**URL Parameters:**
- `id` (integer, required): Product ID

**Response Example (Success - 200):**
```json
{
  "id": 1,
  "name": "Laptop Pro",
  "slug": "laptop-pro",
  "description": "High performance laptop with 16GB RAM",
  "price": "1299.99",
  "stock": 15,
  "sku": "LAP-PRO-001",
  "active": 1,
  "created_at": "2026-06-12T10:30:00.000000Z",
  "updated_at": "2026-06-12T10:30:00.000000Z"
}
```

**Response Example (Error - 404):**
```json
{
  "message": "Product not found"
}
```

---

### 3. Create Product
**Endpoint:** `POST /api/products`

**Description:** Create a new product

**Request Body:**
```json
{
  "name": "New Product",
  "slug": "new-product",
  "description": "Product description",
  "price": 99.99,
  "stock": 50,
  "sku": "PROD-001",
  "active": true
}
```

**Validation Rules:**
- `name`: required, string, max 255 characters
- `slug`: required, string, unique in products table
- `description`: optional, string
- `price`: required, numeric, minimum 0
- `stock`: required, integer, minimum 0
- `sku`: optional, string, unique in products table
- `active`: optional, boolean (defaults to true)

**Response (Success - 201):**
```json
{
  "name": "New Product",
  "slug": "new-product",
  "description": "Product description",
  "price": "99.99",
  "stock": 50,
  "sku": "PROD-001",
  "active": 1,
  "updated_at": "2026-06-12T10:35:00.000000Z",
  "created_at": "2026-06-12T10:35:00.000000Z",
  "id": 6
}
```

---

### 4. Update Product
**Endpoint:** `PUT/PATCH /api/products/{id}`

**Description:** Update an existing product

**URL Parameters:**
- `id` (integer, required): Product ID

**Request Body (partial update allowed):**
```json
{
  "name": "Updated Product Name",
  "price": 149.99,
  "stock": 75
}
```

**Validation Rules:**
- `name`: optional, string, max 255 characters
- `slug`: optional, string, unique (excluding current product)
- `description`: optional, string
- `price`: optional, numeric, minimum 0
- `stock`: optional, integer, minimum 0
- `sku`: optional, string, unique (excluding current product)
- `active`: optional, boolean

**Response (Success - 200):**
```json
{
  "id": 1,
  "name": "Updated Product Name",
  "slug": "laptop-pro",
  "description": "High performance laptop with 16GB RAM",
  "price": "149.99",
  "stock": 75,
  "sku": "LAP-PRO-001",
  "active": 1,
  "created_at": "2026-06-12T10:30:00.000000Z",
  "updated_at": "2026-06-12T10:40:00.000000Z"
}
```

**Response (Error - 404):**
```json
{
  "message": "Product not found"
}
```

---

### 5. Delete Product
**Endpoint:** `DELETE /api/products/{id}`

**Description:** Delete a product

**URL Parameters:**
- `id` (integer, required): Product ID

**Response (Success - 200):**
```json
{
  "message": "Product deleted successfully"
}
```

**Response (Error - 404):**
```json
{
  "message": "Product not found"
}
```

---

## cURL Examples

### Get All Products
```bash
curl -X GET http://localhost:8000/api/products
```

### Get Single Product
```bash
curl -X GET http://localhost:8000/api/products/1
```

### Create Product
```bash
curl -X POST http://localhost:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{
    "name": "New Product",
    "slug": "new-product",
    "price": 99.99,
    "stock": 50,
    "description": "Product description",
    "sku": "PROD-001"
  }'
```

### Update Product
```bash
curl -X PUT http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Updated Name",
    "price": 199.99
  }'
```

### Delete Product
```bash
curl -X DELETE http://localhost:8000/api/products/1
```

---

## HTTP Status Codes
- `200 OK`: Successful GET, PUT, PATCH, DELETE request
- `201 Created`: Successful POST request
- `404 Not Found`: Product not found
- `422 Unprocessable Entity`: Validation error (for POST/PUT/PATCH)

## Starting the Server

Run the following command to start the Laravel development server:

```bash
php artisan serve
```

The API will be available at `http://localhost:8000/api`

---

## Database

The application uses SQLite by default. To run migrations:

```bash
php artisan migrate
```

To seed sample data:

```bash
php artisan db:seed --class=ProductSeeder
```
