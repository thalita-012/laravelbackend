# Enhanced CRUD API Controller - Complete Documentation

## Controller Overview

The `ProductController` has been enhanced with comprehensive CRUD operations, error handling, and additional useful methods for managing products.

### Location
`app/Http/Controllers/Api/ProductController.php`

---

## API Endpoints

### 1. GET All Products
**Endpoint:** `GET /api/products`

**Description:** Retrieve all products with proper error handling

**Response (Success - 200):**
```json
{
  "success": true,
  "message": "Products retrieved successfully",
  "data": [
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
  ],
  "count": 5
}
```

**Response (Error - 500):**
```json
{
  "success": false,
  "message": "Error retrieving products",
  "error": "Database connection error"
}
```

---

### 2. POST Create Product
**Endpoint:** `POST /api/products`

**Description:** Create a new product with validation

**Request Body:**
```json
{
  "name": "Gaming Mouse",
  "slug": "gaming-mouse",
  "description": "RGB Gaming Mouse with 10000 DPI",
  "price": 79.99,
  "stock": 50,
  "sku": "MOUSE-GAME-001",
  "active": true
}
```

**Validation Rules:**
| Field | Rule |
|-------|------|
| name | required, string, max 255 |
| slug | required, string, unique |
| description | optional, string |
| price | required, numeric, min 0, max 9999999.99 |
| stock | required, integer, min 0 |
| sku | optional, string, unique |
| active | optional, boolean (defaults to true) |

**Response (Success - 201):**
```json
{
  "success": true,
  "message": "Product created successfully",
  "data": {
    "id": 6,
    "name": "Gaming Mouse",
    "slug": "gaming-mouse",
    "description": "RGB Gaming Mouse with 10000 DPI",
    "price": "79.99",
    "stock": 50,
    "sku": "MOUSE-GAME-001",
    "active": 1,
    "created_at": "2026-06-12T10:45:00.000000Z",
    "updated_at": "2026-06-12T10:45:00.000000Z"
  }
}
```

**Response (Validation Error - 422):**
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "slug": ["The slug has already been taken."],
    "price": ["The price field is required."]
  }
}
```

---

### 3. GET Single Product
**Endpoint:** `GET /api/products/{id}`

**Description:** Retrieve a specific product by ID

**URL Parameters:**
- `id` (integer, required): Product ID

**Response (Success - 200):**
```json
{
  "success": true,
  "message": "Product retrieved successfully",
  "data": {
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
}
```

**Response (Not Found - 404):**
```json
{
  "success": false,
  "message": "Product not found"
}
```

**Response (Invalid ID - 400):**
```json
{
  "success": false,
  "message": "Invalid product ID"
}
```

---

### 4. PUT/PATCH Update Product
**Endpoint:** `PUT/PATCH /api/products/{id}`

**Description:** Update an existing product (partial updates supported)

**URL Parameters:**
- `id` (integer, required): Product ID

**Request Body (partial update):**
```json
{
  "price": 199.99,
  "stock": 25,
  "active": true
}
```

**Validation Rules (same as create, but all optional):**
| Field | Rule |
|-------|------|
| name | optional, string, max 255 |
| slug | optional, string, unique (excluding current product) |
| description | optional, string |
| price | optional, numeric, min 0, max 9999999.99 |
| stock | optional, integer, min 0 |
| sku | optional, string, unique (excluding current product) |
| active | optional, boolean |

**Response (Success - 200):**
```json
{
  "success": true,
  "message": "Product updated successfully",
  "data": {
    "id": 1,
    "name": "Laptop Pro",
    "slug": "laptop-pro",
    "description": "High performance laptop with 16GB RAM",
    "price": "199.99",
    "stock": 25,
    "sku": "LAP-PRO-001",
    "active": 1,
    "created_at": "2026-06-12T10:30:00.000000Z",
    "updated_at": "2026-06-12T10:50:00.000000Z"
  }
}
```

---

### 5. DELETE Product
**Endpoint:** `DELETE /api/products/{id}`

**Description:** Delete a product permanently

**URL Parameters:**
- `id` (integer, required): Product ID

**Response (Success - 200):**
```json
{
  "success": true,
  "message": "Product deleted successfully",
  "data": {
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
}
```

---

### 6. POST Bulk Delete Products
**Endpoint:** `POST /api/products/bulk-delete`

**Description:** Delete multiple products at once

**Request Body:**
```json
{
  "ids": [1, 2, 3, 4]
}
```

**Validation Rules:**
- `ids`: required, array
- `ids.*`: integer

**Response (Success - 200):**
```json
{
  "success": true,
  "message": "Products deleted successfully",
  "deleted_count": 4
}
```

**Response (Validation Error - 422):**
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "ids": ["The ids field is required."]
  }
}
```

---

### 7. GET Search Products
**Endpoint:** `GET /api/products/search?q=keyword`

**Description:** Search products by name, SKU, or description

**Query Parameters:**
- `q` (string, required): Search query keyword

**Response (Success - 200):**
```json
{
  "success": true,
  "message": "Search completed",
  "query": "laptop",
  "data": [
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
  ],
  "count": 1
}
```

**Response (Missing Query - 400):**
```json
{
  "success": false,
  "message": "Search query is required"
}
```

---

## Key Features

### 1. **Consistent Response Format**
All endpoints return JSON responses with:
- `success`: Boolean indicating success/failure
- `message`: Human-readable message
- `data`: Response data (if applicable)
- `count`: Count of records (for list operations)
- `errors`: Validation errors (if applicable)

### 2. **Comprehensive Error Handling**
- Try-catch blocks for exception handling
- Specific handling for validation exceptions
- Generic error handling for unexpected issues
- Proper HTTP status codes

### 3. **Input Validation**
- Request validation using Laravel's validator
- Unique constraints for slug and SKU
- Price and stock constraints
- Custom validation messages

### 4. **Status Codes Used**
| Code | Meaning |
|------|---------|
| 200 | OK - Successful GET, PUT, PATCH, DELETE |
| 201 | Created - Successful POST |
| 400 | Bad Request - Invalid input (e.g., non-numeric ID) |
| 404 | Not Found - Resource doesn't exist |
| 422 | Unprocessable Entity - Validation error |
| 500 | Internal Server Error - Server-side error |

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
    "name": "Gaming Mouse",
    "slug": "gaming-mouse",
    "price": 79.99,
    "stock": 50,
    "description": "RGB Gaming Mouse",
    "sku": "MOUSE-GAME-001"
  }'
```

### Update Product
```bash
curl -X PUT http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{
    "price": 199.99,
    "stock": 25
  }'
```

### Delete Product
```bash
curl -X DELETE http://localhost:8000/api/products/1
```

### Bulk Delete Products
```bash
curl -X POST http://localhost:8000/api/products/bulk-delete \
  -H "Content-Type: application/json" \
  -d '{
    "ids": [1, 2, 3]
  }'
```

### Search Products
```bash
curl -X GET "http://localhost:8000/api/products/search?q=laptop"
```

---

## Starting the Server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000/api`

---

## File Locations

- **Controller:** `app/Http/Controllers/Api/ProductController.php`
- **Model:** `app/Models/Product.php`
- **Routes:** `routes/api.php`
- **Migration:** `database/migrations/2026_06_12_001158_create_products_table.php`

---

## Notes

- All timestamps are returned in UTC format
- Products are returned in descending order by creation date (newest first)
- Search is case-insensitive and searches name, SKU, and description
- Validation errors are returned with field names and error messages
- All numeric responses use proper JSON types (strings for prices to avoid precision issues)
