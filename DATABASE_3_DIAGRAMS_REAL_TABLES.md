# 3-Diagram+ (Aligned to Real Table Names)

Source of truth: `store_management_system_of_bubt.sql`

## Diagram 1 — Access Control + Core Master Data

```mermaid
erDiagram
    DEPARTMENTS ||--o{ USERS : contains
    ROLES ||--o{ MODEL_HAS_ROLES : assigned
    USERS ||--o{ MODEL_HAS_ROLES : receives
    ROLES ||--o{ ROLE_HAS_PERMISSIONS : grants
    PERMISSIONS ||--o{ ROLE_HAS_PERMISSIONS : includes

    PRODUCT_CATEGORIES ||--o{ SUBCATEGORIES : has
    SUBCATEGORIES ||--o{ PRODUCTS : classifies
    BRANDS ||--o{ PRODUCTS : brands
    SUPPLIERS ||--o{ PRODUCTS : optional_default_supplier
    SEMESTERS ||--o{ DAMAGE_PRODUCTS : tags

    USERS {
        bigint id PK
        string name
        string email
        bigint department_id FK
    }
    ROLES {
        bigint id PK
        string name
    }
    PERMISSIONS {
        bigint id PK
        string name
    }
    MODEL_HAS_ROLES {
        bigint role_id FK
        string model_type
        bigint model_id
    }
    ROLE_HAS_PERMISSIONS {
        bigint permission_id FK
        bigint role_id FK
    }
    DEPARTMENTS {
        bigint id PK
        string name
        string code
    }
    SEMESTERS {
        bigint id PK
        string name
        string code
    }
    PRODUCT_CATEGORIES {
        bigint id PK
        string category_name
    }
    SUBCATEGORIES {
        bigint id PK
        bigint category_id FK
        string subcategory_name
    }
    BRANDS {
        bigint id PK
        string name
    }
    SUPPLIERS {
        bigint id PK
        string name
        string phone
    }
    PRODUCTS {
        bigint id PK
        string name
        string sku
        bigint category_id
        bigint subcategory_id FK
        bigint brand_id
        bigint supplier_id
        int stock_alert
    }
```

## Diagram 2 — Procurement + Return + Quotation

```mermaid
erDiagram
    SUPPLIERS ||--o{ PURCHASES : supplies
    SEMESTERS ||--o{ PURCHASES : tags
    DEPARTMENTS ||--o{ PURCHASES : owned_by
    USERS ||--o{ PURCHASES : created_by
    PURCHASES ||--o{ PURCHASE_ITEMS : has
    PRODUCTS ||--o{ PURCHASE_ITEMS : appears_in

    SUPPLIERS ||--o{ RETURN_PURCHASES : receives_return
    SEMESTERS ||--o{ RETURN_PURCHASES : tags
    DEPARTMENTS ||--o{ RETURN_PURCHASES : owned_by
    RETURN_PURCHASES ||--o{ RETURN_PURCHASE_ITEMS : has
    PRODUCTS ||--o{ RETURN_PURCHASE_ITEMS : appears_in

    SUPPLIERS ||--o{ QUOTATIONS : quoted_by
    USERS ||--o{ QUOTATIONS : created_by
    QUOTATIONS ||--o{ QUOTATION_ITEMS : has
    PRODUCTS ||--o{ QUOTATION_ITEMS : appears_in

    PURCHASES {
        bigint id PK
        bigint supplier_id
        bigint user_id FK
        bigint semester_id FK
        bigint department_id FK
        date date
        decimal grand_total
    }
    PURCHASE_ITEMS {
        bigint id PK
        bigint purchase_id FK
        bigint product_id FK
        int quantity
        decimal net_unit_cost
        date expiry_date
    }
    RETURN_PURCHASES {
        bigint id PK
        bigint supplier_id
        bigint semester_id FK
        bigint department_id FK
        date date
        decimal grand_total
    }
    RETURN_PURCHASE_ITEMS {
        bigint id PK
        bigint return_purchase_id FK
        bigint product_id FK
        int quantity
        decimal net_unit_cost
    }
    QUOTATIONS {
        bigint id PK
        bigint supplier_id FK
        bigint created_by FK
        date quotation_date
        decimal grand_total
    }
    QUOTATION_ITEMS {
        bigint id PK
        bigint quotation_id FK
        bigint product_id FK
        int qty
        decimal price
    }
```

## Diagram 3 — Requisition + Issue + Returns + Damage

```mermaid
erDiagram
    DEPARTMENTS ||--o{ REQUISITIONS : owns
    SEMESTERS ||--o{ REQUISITIONS : tags
    USERS ||--o{ REQUISITIONS : requested_by
    REQUISITIONS ||--o{ REQUISITION_ITEMS : has
    PRODUCTS ||--o{ REQUISITION_ITEMS : appears_in

    REQUISITIONS ||--o{ ISSUES : fulfilled_by
    USERS ||--o{ ISSUES : requested_user
    USERS ||--o{ ISSUES : issued_by
    SEMESTERS ||--o{ ISSUES : tags
    DEPARTMENTS ||--o{ ISSUES : department
    ISSUES ||--o{ ISSUE_ITEMS : has
    PRODUCTS ||--o{ ISSUE_ITEMS : appears_in

    ISSUES ||--o{ ISSUE_RETURNS : has
    USERS ||--o{ ISSUE_RETURNS : returned_by
    USERS ||--o{ ISSUE_RETURNS : created_by
    SEMESTERS ||--o{ ISSUE_RETURNS : tags
    ISSUE_RETURNS ||--o{ ISSUE_RETURN_ITEMS : has
    PRODUCTS ||--o{ ISSUE_RETURN_ITEMS : appears_in

    DAMAGE_PRODUCTS ||--o{ DAMAGE_PRODUCT_ITEMS : has
    PRODUCTS ||--o{ DAMAGE_PRODUCT_ITEMS : appears_in

    REQUISITIONS {
        bigint id PK
        bigint user_id FK
        bigint semester_id FK
        bigint department_id FK
        string status
        date date
    }
    REQUISITION_ITEMS {
        bigint id PK
        bigint requisition_id FK
        bigint product_id FK
        int qty
    }
    ISSUES {
        bigint id PK
        bigint requisition_id FK
        bigint user_id FK
        bigint issued_by FK
        bigint semester_id FK
        bigint department_id FK
        date date
    }
    ISSUE_ITEMS {
        bigint id PK
        bigint issue_id FK
        bigint product_id FK
        int qty
    }
    ISSUE_RETURNS {
        bigint id PK
        bigint issue_id FK
        bigint user_id FK
        bigint created_by FK
        bigint semester_id FK
        date return_date
    }
    ISSUE_RETURN_ITEMS {
        bigint id PK
        bigint issue_return_id FK
        bigint product_id FK
        int qty
    }
    DAMAGE_PRODUCTS {
        bigint id PK
        bigint semester_id FK
        date date
    }
    DAMAGE_PRODUCT_ITEMS {
        bigint id PK
        bigint damage_product_id FK
        bigint product_id FK
        int qty
    }
```

## Alignment Notes (real names vs draft names)

- `CATEGORIES` → `product_categories`
- `USER_ROLES` → `model_has_roles` (polymorphic role assignment)
- `ROLE_PERMISSIONS` → `role_has_permissions`
- `PURCHASE_RETURNS` → `return_purchases`
- `PURCHASE_RETURN_ITEMS` → `return_purchase_items`
- `DAMAGES` → `damage_products` + `damage_product_items`
- `STOCK_LEDGER` table is not present in current schema
- No direct FK from `return_purchases` to `purchases` in current schema
