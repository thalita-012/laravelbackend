# Complete CRUD API Usage Guide

## 🚀 Quick Start

```bash
# 1. Navigate to project
cd C:\Users\Admin\Desktop\Backendlaravel

# 2. Start Laravel server
php artisan serve

# 3. Your API is ready at http://localhost:8000/api
```

---

## 📋 All API Endpoints

```
✅ GET    /api/products                  → List all products
✅ POST   /api/products                  → Create new product
✅ GET    /api/products/{id}             → Get product by ID
✅ PUT    /api/products/{id}             → Update product
✅ PATCH  /api/products/{id}             → Partial update product
✅ DELETE /api/products/{id}             → Delete product
✅ POST   /api/products/bulk-delete      → Delete multiple products
✅ GET    /api/products/search?q=text    → Search products
```

---

## 📚 Detailed Endpoint Documentation

### 1. GET /api/products - List All Products

**Description:** Retrieve all products from the database

**cURL:**
```bash
curl http://localhost:8000/api/products
```

**Response:**
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
  "count": 1
}
```

---

### 2. POST /api/products - Create Product

**Description:** Create a new product

**cURL:**
```bash
curl -X POST http://localhost:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Wireless Headphones",
    "slug": "wireless-headphones",
    "description": "Noise cancelling wireless headphones",
    "price": 199.99,
    "stock": 30,
    "sku": "HEADPHONES-001",
    "active": true
  }'
```

**Required Fields:**
- `name` - string, max 255 characters
- `slug` - string, must be unique
- `price` - decimal number, min 0
- `stock` - integer, min 0

**Optional Fields:**
- `description` - string
- `sku` - string, must be unique
- `active` - boolean (default: true)

**Success Response (201):**
```json
{
  "success": true,
  "message": "Product created successfully",
  "data": {
    "id": 6,
    "name": "Wireless Headphones",
    "slug": "wireless-headphones",
    "description": "Noise cancelling wireless headphones",
    "price": "199.99",
    "stock": 30,
    "sku": "HEADPHONES-001",
    "active": 1,
    "created_at": "2026-06-12T11:00:00.000000Z",
    "updated_at": "2026-06-12T11:00:00.000000Z"
  }
}
```

**Validation Error (422):**
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "slug": ["The slug has already been taken."],
    "price": ["The price must be a number."]
  }
}
```

---

### 3. GET /api/products/{id} - Get Single Product

**Description:** Retrieve a specific product by ID

**cURL:**
```bash
curl http://localhost:8000/api/products/1
```

**Success Response (200):**
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

**Not Found (404):**
```json
{
  "success": false,
  "message": "Product not found"
}
```

---

### 4. PUT /api/products/{id} - Update Product

**Description:** Update an entire product (or partial with PATCH)

**cURL (Full Update):**
```bash
curl -X PUT http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Laptop Pro Max",
    "slug": "laptop-pro-max",
    "description": "New description",
    "price": 1499.99,
    "stock": 20,
    "sku": "LAP-PRO-MAX-001",
    "active": true
  }'
```

**cURL (Partial Update - PATCH):**
```bash
curl -X PATCH http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{
    "price": 1199.99,
    "stock": 25
  }'
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Product updated successfully",
  "data": {
    "id": 1,
    "name": "Laptop Pro Max",
    "slug": "laptop-pro-max",
    "description": "New description",
    "price": "1499.99",
    "stock": 20,
    "sku": "LAP-PRO-MAX-001",
    "active": 1,
    "created_at": "2026-06-12T10:30:00.000000Z",
    "updated_at": "2026-06-12T11:15:00.000000Z"
  }
}
```

**Note:** PUT and PATCH both work the same way in this API. PATCH is typically for partial updates, PUT for full updates.

---

### 5. DELETE /api/products/{id} - Delete Product

**Description:** Permanently delete a product

**cURL:**
```bash
curl -X DELETE http://localhost:8000/api/products/1
```

**Success Response (200):**
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

### 6. POST /api/products/bulk-delete - Bulk Delete

**Description:** Delete multiple products at once

**cURL:**
```bash
curl -X POST http://localhost:8000/api/products/bulk-delete \
  -H "Content-Type: application/json" \
  -d '{
    "ids": [2, 3, 4]
  }'
```

**Success Response (200):**
```json
{
  "success": true,
  "message": "Products deleted successfully",
  "deleted_count": 3
}
```

**Validation Error (422):**
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

### 7. GET /api/products/search - Search Products

**Description:** Search products by name, SKU, or description

**cURL:**
```bash
curl "http://localhost:8000/api/products/search?q=laptop"
```

**Success Response (200):**
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

**Missing Query (400):**
```json
{
  "success": false,
  "message": "Search query is required"
}
```

---

## 🔧 Using with Different Tools

### Postman

1. **Create New Request**
   - Select HTTP method (GET, POST, etc.)
   - Enter URL: `http://localhost:8000/api/products`

2. **Set Headers**
   - `Content-Type: application/json`

3. **Add Body (for POST/PUT/PATCH)**
   - Select "raw" and "JSON"
   - Enter JSON data

4. **Send Request**

### JavaScript/Node.js

```javascript
// GET all products
fetch('http://localhost:8000/api/products')
  .then(res => res.json())
  .then(data => console.log(data));

// POST create product
fetch('http://localhost:8000/api/products', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    name: 'New Product',
    slug: 'new-product',
    price: 99.99,
    stock: 50
  })
})
  .then(res => res.json())
  .then(data => console.log(data));

// PUT update product
fetch('http://localhost:8000/api/products/1', {
  method: 'PUT',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    price: 149.99,
    stock: 75
  })
})
  .then(res => res.json())
  .then(data => console.log(data));

// DELETE product
fetch('http://localhost:8000/api/products/1', {
  method: 'DELETE'
})
  .then(res => res.json())
  .then(data => console.log(data));
```

### Python

```python
import requests

# GET all products
response = requests.get('http://localhost:8000/api/products')
print(response.json())

# POST create product
data = {
    'name': 'New Product',
    'slug': 'new-product',
    'price': 99.99,
    'stock': 50
}
response = requests.post('http://localhost:8000/api/products', json=data)
print(response.json())

# PUT update product
data = {'price': 149.99, 'stock': 75}
response = requests.put('http://localhost:8000/api/products/1', json=data)
print(response.json())

# DELETE product
response = requests.delete('http://localhost:8000/api/products/1')
print(response.json())
```

### PHP (using Laravel Http)

```php
use Illuminate\Support\Facades\Http;

// GET all products
$response = Http::get('http://localhost:8000/api/products');
dd($response->json());

// POST create product
$response = Http::post('http://localhost:8000/api/products', [
    'name' => 'New Product',
    'slug' => 'new-product',
    'price' => 99.99,
    'stock' => 50
]);
dd($response->json());

// PUT update product
$response = Http::put('http://localhost:8000/api/products/1', [
    'price' => 149.99,
    'stock' => 75
]);
dd($response->json());

// DELETE product
$response = Http::delete('http://localhost:8000/api/products/1');
dd($response->json());
```

---

## ✅ Common Tasks

### Task 1: Get All Products
```bash
curl http://localhost:8000/api/products
```

### Task 2: Create New Product
```bash
curl -X POST http://localhost:8000/api/products \
  -H "Content-Type: application/json" \
  -d '{
    "name": "iPhone 15",
    "slug": "iphone-15",
    "price": 999,
    "stock": 100,
    "description": "Latest iPhone model",
    "sku": "IPHONE15-001"
  }'
```

### Task 3: Update Price
```bash
curl -X PATCH http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{"price": 899}'
```

### Task 4: Update Stock
```bash
curl -X PATCH http://localhost:8000/api/products/1 \
  -H "Content-Type: application/json" \
  -d '{"stock": 50}'
```

### Task 5: Delete Single Product
```bash
curl -X DELETE http://localhost:8000/api/products/1
```

### Task 6: Delete Multiple Products
```bash
curl -X POST http://localhost:8000/api/products/bulk-delete \
  -H "Content-Type: application/json" \
  -d '{"ids": [2, 3, 4, 5]}'
```

### Task 7: Search Products
```bash
curl "http://localhost:8000/api/products/search?q=mouse"
```

---

## 🛡️ Validation Rules Reference

| Field | Type | Rules |
|-------|------|-------|
| name | String | Required, max 255 |
| slug | String | Required, unique |
| description | String | Optional |
| price | Decimal | Required, min 0, max 9999999.99 |
| stock | Integer | Required, min 0 |
| sku | String | Optional, unique |
| active | Boolean | Optional (default: true) |

---

## 📊 HTTP Status Codes

| Code | Meaning | Example |
|------|---------|---------|
| 200 | OK | Successful GET, PUT, PATCH, DELETE |
| 201 | Created | Successful POST |
| 400 | Bad Request | Invalid ID or missing query |
| 404 | Not Found | Product doesn't exist |
| 422 | Unprocessable | Validation failed |
| 500 | Server Error | Database or server issue |

---

## 🎯 Next Steps

1. **Test Each Endpoint** - Try all operations with cURL
2. **Check Database** - Verify data is stored correctly
3. **Handle Errors** - Test validation and error responses
4. **Integrate** - Connect with frontend application
5. **Add Auth** - Implement authentication if needed
6. **Deploy** - Move to production server

---

## 📁 Project Structure

```
Backendlaravel/
├── app/Http/Controllers/Api/
│   └── ProductController.php      ← Main CRUD controller
├── app/Models/
│   └── Product.php                ← Product model
├── routes/
│   └── api.php                    ← API routes
├── database/
│   ├── migrations/
│   │   └── *_create_products_table.php
│   └── seeders/
│       └── ProductSeeder.php
├── CRUD_CONTROLLER_DOCUMENTATION.md
├── CRUD_QUICK_REFERENCE.md
├── CRUD_IMPLEMENTATION_SUMMARY.md
└── CRUD_COMPLETE_USAGE_GUIDE.md   ← This file
```

---

## 🎓 Learning Resources

- [Laravel API Documentation](https://laravel.com/docs)
- [RESTful API Best Practices](https://restfulapi.net/)
- [HTTP Status Codes](https://httpwg.org/specs/rfc7231.html#status.codes)

---

## 💡 Pro Tips

1. **Use Postman** for testing complex requests
2. **Enable query logging** to see actual SQL queries
3. **Use PATCH** for partial updates, PUT for full updates
4. **Always include** Content-Type header with JSON
5. **Test error cases** to ensure proper validation

---

## ✨ You're All Set!

Your CRUD API is fully functional and ready to use. Start with the quick examples above and explore each endpoint!

**Happy Coding! 🚀**
