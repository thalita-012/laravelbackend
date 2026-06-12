# CRUD Controller - Quick Reference

## All Endpoints Summary

| Method | Endpoint | Function | Status Code |
|--------|----------|----------|------------|
| GET | `/api/products` | List all products | 200/500 |
| POST | `/api/products` | Create product | 201/422/500 |
| GET | `/api/products/{id}` | Get product by ID | 200/400/404/500 |
| PUT | `/api/products/{id}` | Update product | 200/400/404/422/500 |
| PATCH | `/api/products/{id}` | Update product | 200/400/404/422/500 |
| DELETE | `/api/products/{id}` | Delete product | 200/400/404/500 |
| POST | `/api/products/bulk-delete` | Bulk delete | 200/422/500 |
| GET | `/api/products/search?q=...` | Search products | 200/400/500 |

---

## Controller Methods

### 1. `index()` - GET /api/products
Lists all products ordered by creation date (newest first)
- **Exception Handling:** Yes
- **Returns:** Array of products with count
- **Status:** 200 OK or 500 Error

### 2. `store()` - POST /api/products
Creates a new product with validation
- **Exception Handling:** Yes (validation + general)
- **Validation:** 7 fields
- **Returns:** Created product with ID
- **Status:** 201 Created, 422 Validation Error, or 500 Error

### 3. `show()` - GET /api/products/{id}
Retrieves a single product by ID
- **Exception Handling:** Yes
- **Validation:** ID must be numeric
- **Returns:** Single product
- **Status:** 200 OK, 400 Bad Request, 404 Not Found, or 500 Error

### 4. `update()` - PUT/PATCH /api/products/{id}
Updates an existing product (partial updates supported)
- **Exception Handling:** Yes (validation + general)
- **Validation:** 7 fields (all optional)
- **Unique Validation:** Excludes current product
- **Returns:** Updated product
- **Status:** 200 OK, 400 Bad Request, 404 Not Found, 422 Validation Error, or 500 Error

### 5. `destroy()` - DELETE /api/products/{id}
Deletes a product permanently
- **Exception Handling:** Yes
- **Validation:** ID must be numeric
- **Returns:** Deleted product data
- **Status:** 200 OK, 400 Bad Request, 404 Not Found, or 500 Error

### 6. `bulkDelete()` - POST /api/products/bulk-delete
Deletes multiple products in one request
- **Exception Handling:** Yes (validation + general)
- **Validation:** Array of IDs
- **Returns:** Count of deleted products
- **Status:** 200 OK, 422 Validation Error, or 500 Error

### 7. `search()` - GET /api/products/search?q=keyword
Searches products by name, SKU, or description
- **Exception Handling:** Yes
- **Validation:** Query parameter required
- **Search Fields:** name, sku, description (case-insensitive)
- **Returns:** Array of matching products with count
- **Status:** 200 OK, 400 Bad Request, or 500 Error

---

## Validation Rules

### Create (store)
```
name: required|string|max:255
slug: required|string|unique:products,slug
description: nullable|string
price: required|numeric|min:0|max:9999999.99
stock: required|integer|min:0
sku: nullable|string|unique:products,sku
active: sometimes|boolean
```

### Update (update)
```
name: sometimes|string|max:255
slug: sometimes|string|unique:products,slug,{id}
description: nullable|string
price: sometimes|numeric|min:0|max:9999999.99
stock: sometimes|integer|min:0
sku: nullable|string|unique:products,sku,{id}
active: sometimes|boolean
```

---

## Response Format

### Success Response
```json
{
  "success": true,
  "message": "Operation message",
  "data": { /* operation data */ },
  "count": 5
}
```

### Validation Error Response
```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "field_name": ["Error message"]
  }
}
```

### Not Found Response
```json
{
  "success": false,
  "message": "Product not found"
}
```

### Server Error Response
```json
{
  "success": false,
  "message": "Error message",
  "error": "Exception details"
}
```

---

## Key Features

✅ **Full CRUD Operations** - Create, Read, Update, Delete  
✅ **Bulk Operations** - Bulk delete multiple products  
✅ **Search Functionality** - Search by name, SKU, description  
✅ **Input Validation** - Comprehensive validation rules  
✅ **Error Handling** - Try-catch blocks for all operations  
✅ **Consistent Response Format** - Standardized JSON responses  
✅ **Proper HTTP Status Codes** - Standard REST conventions  
✅ **Database Constraints** - Unique slug and SKU  
✅ **Pagination Ready** - Can be enhanced with pagination  
✅ **Well Documented** - Code comments and documentation  

---

## How to Start

```bash
# Navigate to project
cd C:\Users\Admin\Desktop\Backendlaravel

# Start server
php artisan serve

# API Base URL
http://localhost:8000/api
```

---

## Files Modified/Created

1. **ProductController.php** - Full CRUD implementation
2. **api.php** - Route definitions
3. **CRUD_CONTROLLER_DOCUMENTATION.md** - Detailed API docs
4. **CRUD_QUICK_REFERENCE.md** - This file

---

## Testing the API

### Option 1: Using cURL
```bash
curl -X GET http://localhost:8000/api/products
```

### Option 2: Using Postman
- Import the endpoints into Postman
- Set Content-Type to application/json
- Use the examples from the documentation

### Option 3: Using PHP
```php
$response = Http::get('http://localhost:8000/api/products');
echo $response->json();
```

### Option 4: Using JavaScript/Fetch
```javascript
fetch('http://localhost:8000/api/products')
  .then(res => res.json())
  .then(data => console.log(data));
```

---

## Common Issues & Solutions

### Issue: "Product not found" (404)
**Solution:** Check if the product ID exists in the database

### Issue: Validation errors (422)
**Solution:** Check the errors object in the response for field-specific messages

### Issue: Invalid product ID (400)
**Solution:** Ensure the ID in the URL is a number

### Issue: Unique constraint violation
**Solution:** The slug or SKU already exists; use a different value

---

## Performance Tips

1. For large datasets, add pagination to the index method
2. Add caching for frequently accessed products
3. Use eager loading for related data
4. Add indexes on frequently searched fields (slug, sku)

---

## Security Recommendations

1. Add API authentication (Laravel Sanctum)
2. Add rate limiting
3. Add CORS configuration
4. Validate file uploads if needed
5. Add SQL injection protection (already in place with Laravel ORM)
