# Store Management System of BUBT
## Complete System Documentation

---

## 1. System Architecture

### 1.1 Technology Stack

| Layer | Technology |
|-------|-------------|
| **Framework** | Laravel 12.0 |
| **PHP Version** | 8.2 |
| **Database** | MySQL |
| **Frontend** | Tailwind CSS 3.x, Alpine.js 3.x, Vite 6.x |
| **Authentication** | Laravel Breeze + Spatie Permission |
| **PDF Generation** | Barryvdh Laravel DomPDF |
| **Image Handling** | Intervention Image |
| **Real-time Chat** | Chatify (Munafio) with Pusher |

### 1.2 Architecture Diagram (Mermaid)

```mermaid
flowchart TB
    subgraph Client["Client Layer"]
        Browser[Web Browser]
    end

    subgraph Presentation["Presentation Layer"]
        Blade[Blade Templates]
        Tailwind[Tailwind CSS]
        Alpine[Alpine.js]
    end

    subgraph Application["Application Layer"]
        Controllers[Controllers]
        Middleware[Middleware]
        Services[Services]
    end

    subgraph Data["Data Layer"]
        Models[Eloquent Models]
        Migrations[Database Migrations]
    end

    subgraph External["External Services"]
        Pusher[Pusher / Chatify]
        DomPDF[DomPDF]
    end

    Browser --> Blade
    Blade --> Controllers
    Controllers --> Models
    Controllers --> Middleware
    Models --> Migrations
    Controllers --> Pusher
    Controllers --> DomPDF
```

### 1.3 Architecture Diagram (ASCII)

```
+---------------------------------------------------------------+
|                        CLIENT LAYER                          |
|                    [Web Browser]                             |
+------------------------------+-------------------------------+
                               |
                               v
+---------------------------------------------------------------+
|                    PRESENTATION LAYER                        |
|  +----------------+  +-------------+  +------------------+   |
|  | Blade Templates|  |Tailwind CSS |  |   Alpine.js     |   |
|  +----------------+  +-------------+  +------------------+   |
+------------------------------+-------------------------------+
                               |
                               v
+---------------------------------------------------------------+
|                    APPLICATION LAYER                          |
|  +----------------+  +-------------+  +------------------+   |
|  | Controllers    |  |  Middleware  |  |    Services      |   |
|  +----------------+  +-------------+  +------------------+   |
+------------------------------+-------------------------------+
                               |
                               v
+---------------------------------------------------------------+
|                       DATA LAYER                              |
|  +----------------+  +-------------+                          |
|  |Eloquent Models |  | Migrations   |                          |
|  +----------------+  +-------------+                          |
+------------------------------+-------------------------------+
                               |
                               v
+---------------------------------------------------------------+
|                   EXTERNAL SERVICES                          |
|  +----------------+  +-------------+                          |
|  | Pusher/Chatify |  |   DomPDF    |                          |
|  +----------------+  +-------------+                          |
+---------------------------------------------------------------+
```

### 1.4 Layer Description

1. **Client Layer**: End-users access the system through web browsers
2. **Presentation Layer**: Blade templates render UI with Tailwind CSS styling and Alpine.js interactivity
3. **Application Layer**: Controllers handle business logic, middleware manages authentication/authorization
4. **Data Layer**: Eloquent ORM models interact with MySQL database via migrations

---

## 2. Use Case Diagram

### 2.1 Use Case Diagram (Mermaid)

```mermaid
flowchart TB
    subgraph Actors["Actors"]
        Admin[Super Admin / Admin]
        User[Department User]
    end

    subgraph System["Store Management System"]
        subgraph Modules["Modules"]
            BM[Brand Management]
            SM[Supplier Management]
            PM[Product Management]
            PUM[Purchase Management]
            RM[Requisition Management]
            IM[Issue Management]
            DM[Damage Management]
            QM[Quotation Management]
            Rep[Reports]
            RPM[Role & Permission]
        end
    end

    Admin --> BM
    Admin --> SM
    Admin --> PM
    Admin --> PUM
    Admin --> RM
    Admin --> IM
    Admin --> DM
    Admin --> QM
    Admin --> Rep
    Admin --> RPM

    User --> RM
    User --> Rep
```

### 2.2 Use Case Diagram (ASCII)

```
+------------------------------------------------------------------+
|                         ACTORS                                    |
|  +---------------------+  +-----------------------+               |
|  |  Super Admin/Admin  |  |    Department User    |               |
|  +---------------------+  +-----------------------+               |
+-------------------------------+-----------------------------------+
                |                               |
                |       USE CASES                |
                v                               v
+------------------------------------------------------------------+
|                   STORE MANAGEMENT SYSTEM                        |
+------------------------------------------------------------------+
|                                                                  |
|  +-------------+ +-----------+ +-----------+ +-------------+    |
|  |Brand Mgmt  | |Supplier   | |Product    | | Purchase    |    |
|  |             | |Management | |Management | | Management |    |
|  +-------------+ +-----------+ +-----------+ +-------------+    |
|                                                                  |
|  +-------------+ +-----------+ +-----------+ +-------------+    |
|  |Requisition | | Issue     | | Damage    | | Quotation   |    |
|  | Management | | Management| |Product Mg| | Management |    |
|  +-------------+ +-----------+ +-----------+ +-------------+    |
|                                                                  |
|  +------------------------+ +--------------------------------+   |
|  |     Reports           | |    Role & Permission Management |   |
|  +------------------------+ +--------------------------------+   |
|                                                                  |
+------------------------------------------------------------------+
```

### 2.3 Use Case Descriptions

| Module | Actor | Description |
|--------|-------|-------------|
| Brand Management | Admin | Create, edit, delete product brands |
| Supplier Management | Admin | Manage vendor/supplier information |
| Product Management | Admin | Manage products, categories, subcategories, stock |
| Purchase Management | Admin | Create purchase orders from suppliers |
| Requisition Management | User/Admin | Request products, approve requests |
| Issue Management | Admin | Issue products to users/departments |
| Damage Management | Admin | Report and track damaged products |
| Quotation Management | Admin | Create and manage supplier quotations |
| Reports | Admin | Generate various reports |
| Role & Permission | Admin | Manage roles and permissions |

---

## 3. System Flow Chart

### 3.1 Main Process Flow (Mermaid)

```mermaid
flowchart TD
    Start([Start]) --> Login{Login?}
    Login -->|Yes| Auth{Authenticated?}
    Auth -->|Yes| Dashboard
    Auth -->|No| Login
    Dashboard --> Choice{Choose Action}
    
    Choice -->|Purchase| PO[Create Purchase Order]
    PO --> SU[Select Supplier]
    SU --> PI[Add Products/Items]
    PI --> StockUpdate[Update Stock]
    StockUpdate --> Complete[Complete]
    
    Choice -->|Requisition| Req[Create Requisition]
    Req --> App{Approved?}
    App -->|Yes| Issue[Issue Products]
    App -->|No| Req
    Issue --> StockDeduct[Stock Deduction]
    StockDeduct --> Complete
    
    Choice -->|Report| SelectReport[Select Report Type]
    SelectReport --> Generate[Generate Report]
    Generate --> View[View/Download PDF]
    View --> Complete

    Complete --> Choice
```

### 3.2 System Flow Chart (ASCII)

```
                                    +------------------+
                                    |      START       |
                                    +--------+---------+
                                             |
                                             v
                                    +------------------+
                                    |      LOGIN       |
                                    +--------+---------+
                                             |
                                    +--------v---------+
                                    | AUTHENTICATED?   |
                                    +--------+---------+
                                       /           \
                                     NO           YES
                                     /              \
                               +----v----+    +------------+
                               |  LOGIN  |    |  DASHBOARD |
                               +---------+    +-----+------+
                                                    |
                              +---------------------+---------------------+
                              |                     |                     |
                              v                     v                     v
                     +----------------+    +----------------+    +----------------+
                     |   PURCHASE     |    | REQUISITION    |    |    REPORTS     |
                     |    FLOW        |    |    FLOW        |    |     FLOW       |
                     +--------+-------+    +--------+-------+    +--------+-------+
                              |                     |                     |
                              v                     v                     v
                     +----------------+    +----------------+    +----------------+
                     |Create Purchase |    |Create Request |    | Select Report |
                     |     Order      |    +-------+-------+    +-------+-------+
                              |                     |                     |
                              v                     v                     v
                     +----------------+    +----------------+    +----------------+
                     | Select Supplier|    |   Approved?    |    |Generate Report |
                     +-------+--------+    +-------+-------+    +-------+-------+
                              |                     |                     |
                              v           YES       v                     v
                     +----------------+ <------ +-------+        +--------------+
                     | Add Items      |         |  ISSUE |        |View/Download |
                     +-------+--------+         +---+---+        +-------+------+
                              |                     |                     |
                              v                     v                     v
                     +----------------+    +----------------+    +----------------+
                     |Update Stock    |    |Stock Deduction|    |    COMPLETE    |
                     +-------+--------+    +-------+--------+    +-------+-------+
                              |                     |                     |
                              +---------------------+---------------------+
                                              |
                                              v
                                    +------------------+
                                    |     COMPLETE     |
                                    +------------------+
```

### 3.3 Detailed Flow Descriptions

#### Purchase Flow
1. Admin creates purchase order
2. Select supplier from list
3. Add products and quantities
4. System calculates totals
5. Stock is updated upon completion

#### Requisition Flow
1. User creates requisition request
2. Admin reviews and approves/rejects
3. If approved, products are issued
4. Stock is deducted
5. User receives products

#### Issue Flow
1. Admin selects requisition or creates new issue
2. Select products and quantities
3. Assign to user or department
4. Stock is deducted
5. Issue record is created

---

## 4. Data Flow Diagram (DFD)

### 4.1 Context Diagram (Level 0) - Mermaid

```mermaid
flowchart LR
    subgraph System["Store Management System"]
        SMS[Store Management System]
    end

    subgraph External["External Entities"]
        Users[Department Users]
        Admins[Admins]
        Suppliers[Suppliers]
        Departments[Departments]
    end

    Users -->|Requests/Issues| SMS
    Admins -->|Management| SMS
    Suppliers -->|Quotes/Orders| SMS
    Departments -->|Users Info| SMS
    SMS -->|Reports| Users
    SMS -->|Reports| Admins
    SMS -->|Orders| Suppliers
```

### 4.2 Context Diagram (Level 0) - ASCII

```
+=========================================================================+
|                                                                         |
|   +----------------+         +-------------------------+         +--------+ |
|   |   Department   |         |    STORE MANAGEMENT    |         |Supplier| |
|   |    Users      |         |        SYSTEM           |         |        | |
|   +-------+-------+         +------------+------------+         +---+----+ |
|           |                         |                          |        |
|           |                         |                          |        |
|           |    +--------------------v---------------------+    |        |
|           +--->|                                    |<-----+        |
|                |  User Requests, Issues, Profile   |               |
|                |  Admin Management, Reports         |               |
|                |  Supplier Orders, Quotations       |               |
|                |  Department User Info              |               |
|                +------------------------------------+               |
|           |                         |                          |        |
|           |                         |                          |        |
|           |    +--------------------v---------------------+    |        |
|           <---|  Reports, Confirmations, Products    |--->         |
|                +------------------------------------+               |
|                                                                         |
+=========================================================================+
```

### 4.3 Level 1 DFD - Mermaid

```mermaid
flowchart TB
    subgraph External["External Entities"]
        Users
        Admins
        Suppliers
    end

    subgraph Processes["Processes"]
        PM[Product Mgmt]
        Pur[Purchase]
        Req[Requisition]
        Iss[Issue]
        Rep[Reports]
    end

    subgraph DataStores["Data Stores"]
        DS1[Products]
        DS2[Purchases]
        DS3[Requisitions]
        DS4[Issues]
        DS5[Users]
    end

    Users --> Req
    Users --> Iss
    Admins --> PM
    Admins --> Pur
    Admins --> Rep
    Suppliers --> Pur

    PM --> DS1
    Pur --> DS2
    Req --> DS3
    Iss --> DS4

    DS1 --> PM
    DS2 --> Pur
    DS3 --> Req
    DS4 --> Iss
```

### 4.4 Level 1 DFD - ASCII

```
+=========================================================================+
|                         EXTERNAL ENTITIES                               |
|    +----------+   +----------+   +----------+                         |
|    |  Users   |   |  Admins  |   |Suppliers |                         |
|    +-----+----+   +-----+----+   +-----+----+                         |
|          |             |             |                                 |
+----------|-------------|-------------|---------------------------------+
           |             |             |
           v             v             v
+------------------------------------------------+-------------------+
|                     PROCESSES                   |    DATA STORES    |
|                                                 |                   |
|    +-------------+    +-------------+          |  +----------+     |
|    |   Product   |    |  Purchase   |    +----->  | Products |     |
|    |  Management |    |   Process  |    |        +----------+     |
|    +------+------+    +------+------+    |                       |
|           |                  |            |  +----------+     |
|           |                  |            +--> Purchases  |     |
|           |                  |               | +----------+     |
|           |                  |               |                   |
|    +------+------+    +------+------+    |  +----------+     |
|    |Requisition |    |   Issue   |    +---->Requisitions|    |
|    |  Process  |    |  Process  |    |   | +----------+     |
|    +------+------+    +------+------+    |                   |
|           |                  |            |  +----------+     |
|           |                  |            +-->  Issues  |     |
|           |                  |                +----------+     |
|           |                  |                                   |
|    +------+------+    +------+------+    |  +----------+     |
|    |   Reports   |    |  Auth &  |    +---->  Users   |     |
|    |  Generation |    |   Perm   |        | +----------+     |
|    +-------------+    +----------+                                   |
|                                                 |                   |
+------------------------------------------------+-------------------+
```

---

## 5. Entity Relationship (ER) Diagram

### 5.1 ER Diagram (Mermaid)

```mermaid
erDiagram
    USER ||--o{ REQUISITION : "creates"
    USER ||--o{ ISSUE : "receives"
    USER ||--o{ ISSUE : "issues"
    USER }|--|| DEPARTMENT : "belongs_to"
    USER ||--o{ QUOTATION : "creates"

    DEPARTMENT ||--o{ ISSUE : "receives"
    DEPARTMENT ||--o{ REQUISITION : "creates"
    DEPARTMENT ||--o{ PURCHASE : "created_by"
    DEPARTMENT ||--o{ RETURN_PURCHASE : "created_by"

    SUPPLIER ||--o{ PURCHASE : "supplies"
    SUPPLIER ||--o{ RETURN_PURCHASE : "returns_to"
    SUPPLIER ||--o{ QUOTATION : "provides"

    PRODUCT ||--o{ PURCHASE_ITEM : "included_in"
    PRODUCT ||--o{ RETURN_PURCHASE_ITEM : "returned"
    PRODUCT ||--o{ REQUISITION_ITEM : "requested"
    PRODUCT ||--o{ ISSUE_ITEM : "issued"
    PRODUCT ||--o{ ISSUE_RETURN_ITEM : "returned"
    PRODUCT ||--o{ DAMAGE_PRODUCT_ITEM : "damaged"
    PRODUCT ||--o{ QUOTATION_ITEM : "quoted"
    PRODUCT ||--o{ PRODUCT_IMAGE : "has"
    PRODUCT }|--|| BRAND : "has"
    PRODUCT }|--|| PRODUCT_CATEGORY : "belongs_to"
    PRODUCT }|--|| SUBCATEGORY : "belongs_to"

    PURCHASE ||--o{ PURCHASE_ITEM : "contains"
    PURCHASE }|--|| SUPPLIER : "from"
    PURCHASE }|--|| SEMESTER : "belongs_to"
    PURCHASE }|--|| USER : "created_by"

    RETURN_PURCHASE ||--o{ RETURN_PURCHASE_ITEM : "contains"
    RETURN_PURCHASE }|--|| SUPPLIER : "to"
    RETURN_PURCHASE }|--|| SEMESTER : "belongs_to"

    REQUISITION ||--o{ REQUISITION_ITEM : "contains"
    REQUISITION }|--|| USER : "requested_by"
    REQUISITION }|--|| SEMESTER : "belongs_to"
    REQUISITION }|--|| DEPARTMENT : "belongs_to"
    REQUISITION ||--o{ ISSUE : "fulfilled_by"

    ISSUE ||--o{ ISSUE_ITEM : "contains"
    ISSUE }|--|| REQUISITION : "fulfills"
    ISSUE }|--|| USER : "receiver"
    ISSUE }|--|| USER : "issued_by"
    ISSUE }|--|| SEMESTER : "belongs_to"
    ISSUE }|--|| DEPARTMENT : "belongs_to"

    ISSUE_RETURN ||--o{ ISSUE_RETURN_ITEM : "contains"
    ISSUE_RETURN }|--|| ISSUE : "returns"
    ISSUE_RETURN }|--|| USER : "returned_by"
    ISSUE_RETURN }|--|| SEMESTER : "belongs_to"

    DAMAGE_PRODUCT ||--o{ DAMAGE_PRODUCT_ITEM : "contains"
    DAMAGE_PRODUCT }|--|| SEMESTER : "belongs_to"

    QUOTATION ||--o{ QUOTATION_ITEM : "contains"
    QUOTATION }|--|| SUPPLIER : "from"
    QUOTATION }|--|| USER : "created_by"

    PRODUCT_CATEGORY ||--o{ SUBCATEGORY : "has"

    SEMESTER ||--o{ PURCHASE : "has"
    SEMESTER ||--o{ RETURN_PURCHASE : "has"
    SEMESTER ||--o{ REQUISITION : "has"
    SEMESTER ||--o{ ISSUE : "has"
    SEMESTER ||--o{ ISSUE_RETURN : "has"
    SEMESTER ||--o{ DAMAGE_PRODUCT : "has"

    BRAND ||--o{ PRODUCT : "has"
```

### 5.2 ER Diagram (ASCII)

```
+=========================================================================+
|                          ENTITY RELATIONSHIPS                           |
+=========================================================================+

    +----------+                         +----------+
    |   USER   |                         |  BRAND   |
    +----+-----+                         +----+-----+
         |                                    |
         | 1,N                               | 1,N
         |<---------------------------------->|
         |                                    |
    +----v-----+         +-----------+  +----v-----+
    |  DEPT    |         |  PRODUCT  |  |   PROD   |
    +----+-----+         +-----+-----+  |  CATEGORY|
         |                     |          +-----+-----+
         | 1,N                 | 1,N            |
         |<--------------------|--------------> |
         |                     |          1,N   |
    +----v-----+         +----v-----+    +-----v-----+
    | REQUISIT |         | SUBCATE- |    |  SUPPLIER|
    |   ION   |         |   GORY   |    +-----+-----+
    +----+-----+         +-----+-----+          |
         |                     |            1,N  |
         | 1,N                 |            <---+
         |<--------------------|                |
         |                     |          +----v-----+
    +----v-----+         +-----+-----+    |  PURCHASE|
    |  ISSUE  |         |  SEMESTER|    +-----+-----+
    +----+-----+         +-----+-----+          |
         |                     |            1,N  |
         | 1,N                 |            <---+
         |<--------------------|                |
         |                     |          +----v-----+
    +----v-----+         +-----+-----+    | QUOTATION|
    | ISSUE    |         |         |    +-----+-----+
    | RETURN   |                         |          |
    +----+-----+                    1,N   |          |
         |                            <---+          |
         | 1,N                     +----v-----+      |
         |<------------------------|  PURCHASE|      |
         |                        |   ITEM   |      |
         |                        +-----+-----+      |
         |                              |            |
         |                        +----v-----+      |
         |                        |  DAMAGE  |      |
         |                        | PRODUCT  |      |
         |                        +-----+-----+      |
         |                              |            |
         +-----------------------------+------------+
                                      | 1,N
                                 +----v-----+
                                 |  REQUIS  |
                                 |   ITION  |
                                 |   ITEM   |
                                 +----------+

+=========================================================================+
|                         RELATIONSHIP LEGEND                             |
+=========================================================================+
|  1,N = One-to-Many    |    1,1 = One-to-One    |    N,N = Many-to-Many |
+=========================================================================+
```

---

## 6. Context Diagram

### 6.1 Context Diagram (Mermaid)

```mermaid
flowchart TB
    subgraph System["Store Management System of BUBT"]
        SMS[" "]
    end

    subgraph External_Entities
        Users["Department Users"]
        Admins["Admin Users"]
        Suppliers["Suppliers"]
        Depts["Departments"]
        Auth["Authentication System"]
    end

    subgraph Data_Flows
        Req["Product Requests"]
        Issue["Product Issues"]
        Orders["Purchase Orders"]
        Reports["Reports"]
        AuthFlow["Login/Auth"]
        Perms["Permissions"]
    end

    Users -->|Req| SMS
    Users -->|AuthFlow| Auth
    Users <--|Reports| SMS

    Admins -->|Orders| SMS
    Admins -->|Issue| SMS
    Admins -->|Reports| SMS
    Admins -->|Perms| SMS
    Admins -->|AuthFlow| Auth

    Suppliers -->|Quotes| SMS
    Suppliers <--|Orders| SMS

    Depts -->|User Info| SMS

    Auth -->|User Data| SMS
```

### 6.2 Context Diagram (ASCII)

```
+======================================================================+
|                                                                  |
|                        CONTEXT DIAGRAM                             |
|                 Store Management System of BUBT                   |
+======================================================================+

                      +-------------------+
                      |    DEPARTMENT     |
                      |    USERS          |
                      +--------+----------+
                               |
              +----------------|----------------+
              |                |                |
              |     +-----------v-----------+   |
              |     |  PRODUCT REQUESTS    |   |
              |     +-----------+-----------+   |
              |                 |               |
              +-----------------|---------------+
                                |
              +-----------------+----------------+
              |                                 |
              |     +---------------+           |
              |     |     STORE     |           |
              |     |  MANAGEMENT   |           |
              |     |    SYSTEM     |           |
              |     |     OF        |           |
              |     |     BUBT      |           |
              |     +-------+-------+           |
              |         |                       |
     +--------+---------+---------+--------+----+--------+
     |        |         |         |        |              |
     |        |         |         |        |              |
     v        v         v         v        v              v
+----------+ +----------+ +----------+ +----------+ +----------+
|ADMIN USERS| |SUPPLIERS | | DEPART- | |REPORTS  | | AUTH    |
|          | |          | |  MENTS  | |         | |SYSTEM   |
+---+------+ +---+------+ +----+-----+ +----+----+ +----+----+
    |            |            |         |         |         |
    |            |            |         |         |         |
    |   +--------v-------+    |         |         |         |
    |   |  PERMISSIONS   |    |         |         |         |
    |   +--------+-------+    |         |         |         |
    |            |            |         |         |         |
    +------------+------------+---------+---------+---------+
                                |
                       +--------v----------+
                       |   PRODUCT ISSUES |
                       |  PURCHASE ORDERS |
                       |    QUOTATIONS    |
                       +------------------+

+======================================================================+
|                        DATA FLOWS                                    |
+======================================================================+
|  - Product Requests: Department users request products             |
|  - Product Issues: Admin issues products to users                  |
|  - Purchase Orders: Admin creates orders from suppliers             |
|  - Quotations: Suppliers provide price quotes                      |
|  - Reports: System generates various reports                       |
|  - Auth: Login/Authentication flow                                  |
|  - Permissions: Role-based access control                          |
+======================================================================+
```

---

## 7. Database Schema Diagram

### Part 1: Core Entities (Users, Products, Categories, Brands, Suppliers)

#### 7.1.1 Part 1 - Mermaid ER Diagram

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email UK
        timestamp email_verified_at
        string password
        string photo
        string phone
        string address
        string role
        bigint department_id FK
        string status
        timestamp remember_token
        timestamp timestamps
    }

    departments {
        bigint id PK
        string name
        string code
        string head_of_department
        string head_of_department_email
        string head_of_department_phone
        string status
        timestamp timestamps
    }

    semesters {
        bigint id PK
        string name
        string slug
        string code
        string status
        timestamp timestamps
    }

    brands {
        bigint id PK
        string name
        string image
        timestamp timestamps
    }

    product_categories {
        bigint id PK
        string category_name
        string category_slug
        timestamp timestamps
    }

    subcategories {
        bigint id PK
        bigint category_id FK
        string subcategory_name
        string subcategory_slug
        timestamp timestamps
    }

    suppliers {
        bigint id PK
        string name
        string email UK
        string phone
        string address
        timestamp timestamps
    }

    products {
        bigint id PK
        string name
        string code
        json image
        bigint category_id FK
        bigint brand_id FK
        bigint supplier_id FK
        decimal price
        int stock_alert
        text note
        int product_qty
        decimal discount
        string status
        tinyint active
        timestamp timestamps
    }

    product_images {
        bigint id PK
        bigint product_id FK
        string image
        timestamp timestamps
    }

    users ||--o{ departments : "department_id"
    brands ||--o{ products : "brand_id"
    product_categories ||--o{ subcategories : "category_id"
    product_categories ||--o{ products : "category_id"
    subcategories ||--o{ products : "subcategory_id"
    suppliers ||--o{ products : "supplier_id"
    products ||--o{ product_images : "product_id"
```

#### 7.1.2 Part 1 - ASCII Schema

```
+=========================================================================+
|                  PART 1: CORE ENTITIES                                  |
|            Users, Products, Categories, Brands, Suppliers             |
+=========================================================================+

+-------------------------+        +-------------------------+
|         USERS           |        |       DEPARTMENTS       |
+-------------------------+        +-------------------------+
| id (PK)                 |<------>| id (PK)                |
| name                    |  N:1   | name                    |
| email (UK)              |        | code                    |
| password                |        | head_of_department      |
| photo                   |        | head_of_department_email|
| phone                   |        | head_of_department_phone|
| address                 |        | status                   |
| role                    |        +-------------------------+
| department_id (FK) ------+              ^
| status                  |              |
+-------------------------+              1:N
                                      |
+-------------------------+        +-------------------------+
|        SEMESTERS         |        |         BRANDS          |
+-------------------------+        +-------------------------+
| id (PK)                 |        | id (PK)                 |
| name                    |        | name                    |
| slug                    |        | image                   |
| code                    |        +-------------------------+
| status                  |              ^
+-------------------------+              1:N
                                      |
+-------------------------+        +-------------------------+
|   PRODUCT CATEGORIES     |        |        PRODUCTS        |
+-------------------------+        +-------------------------+
| id (PK)                 |<------>| id (PK)                |
| category_name           |  1:N   | name                    |
| category_slug           |        | code                   |
+-------------------------+        | image (JSON)            |
                                 | category_id (FK) --------+
              1:N                | brand_id (FK) --------+
              |                   | supplier_id (FK) ------+
+-------------------------+        | price                  |
|      SUBCATEGORIES      |        | stock_alert            |
+-------------------------+        | note                   |
| id (PK)                 |        | product_qty            |
| category_id (FK) -------|-------->| discount               |
| subcategory_name        |        | status                 |
| subcategory_slug        |        | active                 |
+-------------------------+        +-------------------------+
                                      ^
                                      | 1:N
+-------------------------+        +-------------------------+
|        SUPPLIERS        |        |    PRODUCT IMAGES      |
+-------------------------+        +-------------------------+
| id (PK)                 |<------ | id (PK)                |
| name                    |  1:N   | product_id (FK) -------+
| email (UK)              |        | image                  |
| phone                   |        +-------------------------+
| address                 |
+-------------------------+
```

---

### Part 2: Purchase & Inventory Management

#### 7.2.1 Part 2 - Mermaid ER Diagram

```mermaid
erDiagram
    purchases {
        bigint id PK
        date date
        bigint supplier_id FK
        decimal discount
        decimal shipping
        string status
        text note
        decimal grand_total
        string tracking_no
        string note_no
        string file_upload
        bigint semester_id FK
        bigint department_id FK
        bigint user_id FK
        timestamp timestamps
    }

    purchase_items {
        bigint id PK
        bigint purchase_id FK
        bigint product_id FK
        decimal net_unit_cost
        int stock
        int quantity
        decimal discount
        decimal subtotal
        date expiry_date
        timestamp timestamps
    }

    return_purchases {
        bigint id PK
        date date
        bigint supplier_id FK
        decimal discount
        decimal shipping
        string status
        text note
        decimal grand_total
        string tracking_no
        bigint semester_id FK
        bigint department_id FK
        timestamp timestamps
    }

    return_purchase_items {
        bigint id PK
        bigint return_purchase_id FK
        bigint product_id FK
        decimal net_unit_cost
        int stock
        int quantity
        decimal discount
        decimal subtotal
        timestamp timestamps
    }

    products {
        bigint id PK
        string name
    }

    semesters {
        bigint id PK
        string name
    }

    departments {
        bigint id PK
        string name
    }

    users {
        bigint id PK
        string name
    }

    suppliers {
        bigint id PK
        string name
    }

    semesters ||--o{ purchases : "semester_id"
    semesters ||--o{ return_purchases : "semester_id"
    departments ||--o{ purchases : "department_id"
    departments ||--o{ return_purchases : "department_id"
    users ||--o{ purchases : "user_id"
    suppliers ||--o{ purchases : "supplier_id"
    suppliers ||--o{ return_purchases : "supplier_id"
    products ||--o{ purchase_items : "product_id"
    products ||--o{ return_purchase_items : "product_id"
    purchases ||--o{ purchase_items : "purchase_id"
    return_purchases ||--o{ return_purchase_items : "return_purchase_id"
```

#### 7.2.2 Part 2 - ASCII Schema

```
+=========================================================================+
|               PART 2: PURCHASE & INVENTORY MANAGEMENT                   |
+=========================================================================+

+-------------------------+        +-------------------------+
|        PURCHASES        |        |     PURCHASE ITEMS     |
+-------------------------+        +-------------------------+
| id (PK)                 |<------| id (PK)                |
| date                    |  1:N  | purchase_id (FK) ------+
| supplier_id (FK) ------->        | product_id (FK) ------+
| discount                |        | net_unit_cost         |
| shipping                |        | stock                 |
| status                  |        | quantity              |
| note                    |        | discount              |
| grand_total             |        | subtotal              |
| tracking_no             |        | expiry_date           |
| note_no                 |        +-------------------------+
| file_upload             |
| semester_id (FK) ------>|
| department_id (FK) ---->|
| user_id (FK) ---------->|
+-------------------------+

              1,N                              1,N
              |                                |
              |      +---------------+         |
              +----->|    PRODUCTS   |<--------+
                     +---------------+
                              ^
                              | 1,N
+-------------------------+        +-------------------------+
|    RETURN PURCHASES     |        |  RETURN PURCHASE ITEMS |
+-------------------------+        +-------------------------+
| id (PK)                 |<------| id (PK)                |
| date                    |  1:N  | return_purchase_id(FK)--+
| supplier_id (FK) ------->        | product_id (FK) ------+
| discount                |        | net_unit_cost         |
| shipping                |        | stock                 |
| status                  |        | quantity              |
| note                    |        | discount              |
| grand_total             |        | subtotal              |
| tracking_no             |        +-------------------------+
| semester_id (FK) ------>|
| department_id (FK) ---->|
+-------------------------+

+-------------------------+        +-------------------------+
|        SEMESTERS        |        |       DEPARTMENTS       |
+-------------------------+        +-------------------------+
| id (PK)                 |   1:N   | id (PK)                 |
| name                    |        | name                    |
+-------------------------+        +-------------------------+

+-------------------------+        +-------------------------+
|          USERS          |        |       SUPPLIERS         |
+-------------------------+        +-------------------------+
| id (PK)                 |   1:N  | id (PK)                 |
| name                    |        | name                    |
+-------------------------+        +-------------------------+
```

---

### Part 3: Requisition, Issue, Damage & Quotation

#### 7.3.1 Part 3 - Mermaid ER Diagram

```mermaid
erDiagram
    requisitions {
        bigint id PK
        date date
        bigint user_id FK
        bigint semester_id FK
        bigint department_id FK
        text notes
        string status
        timestamp timestamps
    }

    requisition_items {
        bigint id PK
        bigint requisition_id FK
        bigint product_id FK
        int qty
        timestamp timestamps
    }

    issues {
        bigint id PK
        date date
        bigint requisition_id FK
        bigint user_id FK
        bigint issued_by FK
        bigint semester_id FK
        bigint department_id FK
        text notes
        timestamp timestamps
    }

    issue_items {
        bigint id PK
        bigint issue_id FK
        bigint product_id FK
        int qty
        timestamp timestamps
    }

    issue_returns {
        bigint id PK
        bigint issue_id FK
        bigint user_id FK
        bigint created_by FK
        date return_date
        text notes
        timestamp timestamps
    }

    issue_return_items {
        bigint id PK
        bigint issue_return_id FK
        bigint product_id FK
        int qty
        string condition
        bigint semester_id FK
        timestamp timestamps
    }

    damage_products {
        bigint id PK
        date date
        string tracking_no
        string note_no
        bigint semester_id FK
        text notes
        timestamp timestamps
    }

    damage_product_items {
        bigint id PK
        bigint damage_product_id FK
        bigint product_id FK
        int qty
        timestamp timestamps
    }

    quotations {
        bigint id PK
        string quotation_no UK
        string tracking_no
        bigint supplier_id FK
        date quotation_date
        decimal subtotal
        decimal discount
        decimal grand_total
        text notes
        bigint created_by FK
        timestamp timestamps
    }

    quotation_items {
        bigint id PK
        bigint quotation_id FK
        bigint product_id FK
        string product_name
        string product_code
        int qty
        decimal price
        decimal total
        timestamp timestamps
    }

    products {
        bigint id PK
        string name
    }

    semesters {
        bigint id PK
        string name
    }

    departments {
        bigint id PK
        string name
    }

    users {
        bigint id PK
        string name
    }

    suppliers {
        bigint id PK
        string name
    }

    users ||--o{ requisitions : "user_id"
    users ||--o{ issues : "user_id"
    users ||--o{ issues : "issued_by"
    users ||--o{ issue_returns : "user_id"
    users ||--o{ issue_returns : "created_by"
    users ||--o{ quotations : "created_by"

    departments ||--o{ requisitions : "department_id"
    departments ||--o{ issues : "department_id"

    semesters ||--o{ requisitions : "semester_id"
    semesters ||--o{ issues : "semester_id"
    semesters ||--o{ issue_returns : "semester_id"
    semesters ||--o{ damage_products : "semester_id"
    semesters ||--o{ issue_return_items : "semester_id"

    products ||--o{ requisition_items : "product_id"
    products ||--o{ issue_items : "product_id"
    products ||--o{ issue_return_items : "product_id"
    products ||--o{ damage_product_items : "product_id"
    products ||--o{ quotation_items : "product_id"

    requisitions ||--o{ requisition_items : "requisition_id"
    requisitions ||--o{ issues : "requisition_id"
    issues ||--o{ issue_items : "issue_id"
    issue_returns ||--o{ issue_return_items : "issue_return_id"
    issue_returns ||--o{ issues : "issue_id"
    damage_products ||--o{ damage_product_items : "damage_product_id"
    quotations ||--o{ quotation_items : "quotation_id"

    suppliers ||--o{ quotations : "supplier_id"
```

#### 7.3.2 Part 3 - ASCII Schema

```
+=========================================================================+
|            PART 3: REQUISITION, ISSUE, DAMAGE & QUOTATION              |
+=========================================================================+

+-------------------------+        +-------------------------+
|      REQUISITIONS       |        |    REQUISITION ITEMS   |
+-------------------------+        +-------------------------+
| id (PK)                 |<------| id (PK)                |
| date                    |  1:N  | requisition_id (FK) ----+
| user_id (FK) ---------->|        | product_id (FK) ------+
| semester_id (FK) ------>        | qty                   |
| department_id (FK) ---->        +-------------------------+
| notes                   |
| status                  |
+-------------------------+

              |                                          |
              | 1,N                     1,N               |
              |                                     +----v-----+
              +-----> +---------------+ <------------|PRODUCTS |
                      |    ISSUES     |              +---------+
                      +-------+-------+                    ^
              |                 |                      |
              | 1,N             | 1,N                    |
              |                 |                      |
+-------------------------+        +-------------------------+
|          ISSUES         |        |       ISSUE ITEMS       |
+-------------------------+        +-------------------------+
| id (PK)                 |<------| id (PK)                |
| date                    |  1:N  | issue_id (FK) ---------+
| requisition_id (FK) --->        | product_id (FK) ------+
| user_id (FK) ---------->        | qty                   |
| issued_by (FK) -------->        +-------------------------+
| semester_id (FK) ------>|
| department_id (FK) ---->|
| notes                   |
+-------------------------+

+-------------------------+        +-------------------------+
|      ISSUE RETURNS      |        |   ISSUE RETURN ITEMS   |
+-------------------------+        +-------------------------+
| id (PK)                 |<------| id (PK)                |
| issue_id (FK) --------->|  1:N  | issue_return_id (FK)--+
| user_id (FK) ---------->        | product_id (FK) ------+
| created_by (FK) -------->       | qty                   |
| return_date              |        | condition             |
| notes                    |        | semester_id (FK) ---->|
+-------------------------+        +-------------------------+

+-------------------------+        +-------------------------+
|    DAMAGE PRODUCTS      |        |  DAMAGE PRODUCT ITEMS  |
+-------------------------+        +-------------------------+
| id (PK)                 |<------| id (PK)                |
| date                    |  1:N  | damage_product_id(FK)--+
| tracking_no             |        | product_id (FK) ------+
| note_no                 |        | qty                   |
| semester_id (FK) ------>        +-------------------------+
| notes                   |
+-------------------------+

+-------------------------+        +-------------------------+
|       QUOTATIONS        |        |     QUOTATION ITEMS    |
+-------------------------+        +-------------------------+
| id (PK)                 |<------| id (PK)                |
| quotation_no (UK)       |  1:N  | quotation_id (FK) -----+
| tracking_no             |        | product_id (FK) ------+
| supplier_id (FK) ------->        | product_name          |
| quotation_date          |        | product_code          |
| subtotal                |        | qty                   |
| discount                |        | price                 |
| grand_total             |        | total                 |
| notes                   |        +-------------------------+
| created_by (FK) -------->|
+-------------------------+

+-------------------------+        +-------------------------+
|        SEMESTERS        |        |       DEPARTMENTS       |
+-------------------------+        +-------------------------+
| id (PK)                 |   1:N  | id (PK)                 |
| name                    |        | name                    |
+-------------------------+        +-------------------------+

+-------------------------+
|          USERS          |
+-------------------------+
| id (PK)                 |
| name                    |
+-------------------------+

+=========================================================================+
|                    SPATIE PERMISSION TABLES                             |
+=========================================================================+
|  permissions | roles | model_has_permissions | model_has_roles |        |
|  role_has_permissions                                              |
+=========================================================================+
```

---

## 8. Summary

### 8.1 System Overview

The **Store Management System of BUBT** is a comprehensive Laravel-based inventory management application designed for institutional use at Bangladesh University of Business and Technology.

### 8.2 Key Features Summary

| Category | Features |
|----------|----------|
| Product Management | Categories, Subcategories, Brands, SKU generation, Stock tracking |
| Purchase Management | Purchase orders, Returns to suppliers |
| Requisition System | User requests, Admin approval, Issue fulfillment |
| Issue Management | Product distribution, Returns tracking |
| Damage Management | Damaged product reporting |
| Reporting | Purchase, Stock, Damage, Fixed Asset, Product TRX, Lifetime reports |
| Access Control | Role-based permissions (Super Admin, Admin, Custom roles) |
| Communication | Real-time chat via Chatify |

### 8.3 Database Statistics

- **Total Tables**: 23 core tables + 5 Spatie permission tables
- **Total Models**: 30+ Eloquent models
- **Total Controllers**: 20+ controllers
- **Total Routes**: 100+ routes

### 8.4 Technology Stack Summary

- **Backend**: Laravel 12.0, PHP 8.2
- **Database**: MySQL
- **Frontend**: Tailwind CSS 3.x, Alpine.js 3.x, Vite 6.x
- **Authentication**: Laravel Breeze + Spatie Permission
- **Additional**: Chatify, DomPDF, Intervention Image

---

*Document generated for Store Management System of BUBT*
*Project: D:\Capstone Project\Store Management System of BUBT*
