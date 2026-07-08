# 📦 Assetify - Integrated Library Inventory Management System

Live Deployment Target: http://assetify.eastasia.cloudapp.azure.com

---

## 📌 Project Overview

### Problem Statement
Conventional library asset management is typically reactive—strictly limiting its operations to logging incoming/outgoing books and standard logistical movements without any forward-looking projections. The lack of predictive visibility often triggers either *over-provisioning* (accumulation of dead stock) or *sudden scarcity* (unavailability of crucial assets due to sudden borrowing spikes). 

Operational and management teams struggle to map out the cumulative depreciation of asset values and precisely determine when optimal preventive maintenance cycles should be executed based on historical data dynamics.

### Proposed Solution
**Assetify** addresses these gaps as an intelligent library management ecosystem built on a modern full-stack monolithic framework. 

The platform breaks the limitations of traditional inventory systems by integrating a cutting-edge modeling module leveraging a **System Dynamics (Single Integrated Scenario)** approach. Assetify not only records real-time logistical transactions but also mathematically simulates stock turnover, wear-and-tear rates of consumable items, and predicts future procurement needs within a single, comprehensive analytical dashboard.

### Key Objectives
* **Real-time Data Transparency:** Provides transparent logging of circulation, borrowing activities, asset image tracking, and condition statuses.
* **System Dynamics Integration:** Features a robust, single integrated mathematical simulation scenario to project long-term asset stock behaviors.
* **Infrastructure Hardening:** Built on top of a resilient containerized foundation to ensure operational reliability, high portability, and secure database staging.

---

## 🔑 Demonstration Accounts

For evaluation and testing purposes, the database seeder registers pre-configured testing accounts with specific roles:

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin1@gmail.com` | `admin123` |
| **Staff** | `staff@gmail.com` | `staff123` |
| **Manager** | `manager@gmail.com` | `manager123` |

*Note: You can also use the registration form on the welcome page, where you can directly assign roles to new testing users.*

---

## 🛠️ Testing, Quality Assurance, and Deployment Pipelines

Assetify implements a modern software engineering workflow that tightly couples local verification gates (Git Hooks) with serverless cloud orchestrators (CI/CD) to enforce continuous integration standards.

### A. Quality Assurance & Static Analysis (Local Environment)
* **Husky:** A Git hooks orchestrator configured to intercept local developer workflow events. It actively intercepts the `git commit` command sequence on the local workstation to run verification suites before files are sent to remote storage branches.
* **lint-staged:** Optimizes runtime efficiency during static analysis execution gates by restricting programmatic formatting checks exclusively to JavaScript source modules that have been actively staged in the Git index.
* **ESLint & Prettier:** Enforces programmatic code standardization guidelines (indentation matrix, syntax structures, and semicolon consistency parameters) while identifying architectural antipatterns or latent logic bugs within frontend component layers.
* **Laravel Pint (PHP):** An opinionated PHP code style framework that automatically scans and refactors backend architecture modules to comply with the standard PSR-12 specification guidelines.

### B. Automated Testing Suites (Unit & Feature Validations)
* **Jest (JavaScript):** Used to perform unit regression testing routines on modular UI assets and logic boundaries.
* **PHPUnit (PHP/Laravel):** Conducts a comprehensive suite of **60 distinct test cases** at the API and feature layers. The automated test coverage asserts the following behaviors:
  * RBAC Matrix validation across user access tokens (Admin vs. Staff vs. Manager).
  * Transaction-triggered mathematical database hooks for automatic inventory deduction and stock restoration loops.
  * System event dispatches and transactional REST API state mutations.

### C. Cloud Infrastructure & Deployment Orchestration
* **GitHub Actions (CI/CD):** An automated pipeline triggered upon a code delivery event to the `main` branch. The cloud pipeline invokes code style checks via Laravel Pint, builds optimized production assets using the Vite bundler (`npm run build`), and executes automated deployments to the Azure Linux Virtual Machine using encrypted SSH pipelines.
* **Docker & Docker Compose:** Encapsulates the runtime stack into two distinct, isolated environment layers:
  * `inlife_web`: Hosts the core application engine executing PHP-FPM and high-availability Nginx proxy servers.
  * `inlife_db`: Runs a closed relational MySQL server instance, isolated from the public network configuration to strengthen security parameters.
* **deploy.sh Script:** A automated custom shell script located on the Azure host machine that automates pull requests, container orchestration rebuild chains, schema migrations, and virtual media storage directory linking processes.

---

## 📦 Core Product Feature Modules

Assetify satisfies all required functionality criteria alongside value-added operational bonuses, designed to provide high-fidelity enterprise inventory governance:

### 1. Role-Based Access Control & Multi-Role Authentication
* **Laravel Breeze Authentication Pipeline:** Secure account registrations, session authentications, sign-out actions, and cryptographic password restoration paths (Forgot Password).
* **Granular Three-Tier Authorization System:**
  * **Admin:** Retains absolute system permissions, including master data mutations (CRUD), asset categorization configurations, global transaction interventions, and analytical report downloads.
  * **Staff:** Oversees standard warehouse operations, physical asset mutations, inputting borrowing claims, and processing incoming item returns.
  * **Manager:** Authoritative controller over workflow operations (Approve/Reject requests) with specialized read access to security audit timelines and visual forecasting graphs.

### 2. Physical Inventory & Master Data Management
* **Comprehensive Product & Category Mutations (CRUD):** Granular control over naming indexes, unique alphanumeric codes, precise physical storage coordinates, and categorical tagging structures.
* **Binary Object Upload Engine:** Supports physical media attachments to render asset tracking photographs directly inside user browser views.
* **Advanced Query Searching & Filtering Data Matrix:** Instantly resolves rows based on code structures, names, or storage coordinates, with strict filters for categories and physical condition metrics (*Good, Lightly Damaged, Severely Damaged*).
* **Data Pagination Layer:** Streamlines API responses and DOM element weights by splitting lists cleanly into 10 items per page.

### 3. Circulation Lifecycle & Automated Stock Controls
* **Multi-Item Borrowing Actions:** Allows a single request form to bundle different item models with varying quantities, powered by a dynamic Alpine.js frontend handler.
* **Persistent Stock Mitigation & Recovery Closures:**
  * Deducts available items immediately when a transaction enters a **Pending** verification status.
  * Instantly restores quantities to the ledger if a transaction is marked **Rejected** by a Manager.
  * Safely increments available units back into the warehouse upon a verified **Returned** status by Staff.
* **Overdue Cancellation Interventions:** Features a custom manual revocation button that restores stock balances while enforcing the entry of an explanation log recorded in English.

### 4. Interactive Monitoring & Data Analytics Dashboard
* **KPI Metric Cards:** High-level operational summaries reflecting Total Unique Products, Units Available, Active Borrowing Loans, and Defective Units Requiring Maintenance.
* **Advanced Charting Data Models (Chart.js Integration):**
  * **Line Chart:** Measures historical monthly borrowing trajectories to calculate operational usage trends.
  * **Donut Chart:** Visualizes percentage allocations across categories within the storage facilities.
  * **Horizontal Bar Chart:** Pinpoints the Top 5 high-demand assets based on transaction volumes.
* **Low Stock Alert Infrastructure:** An automated flagging mechanism that warns administrators when consumable supplies fall below a defined minimum boundary (< 5 units).
* **Overdue Return Tracker:** Pins late returns to the dashboard view alongside a native trigger button to send internal notifications to responsible team members.
* **Real-Time Operational Audit Log:** An active feed tracking system events, capturing timestamps for product creations and circulation status changes.

### 5. Document Exports & Advanced Bonus Features
* **Export Excel (CSV Matrix):** Converts database circulation records into standard tabular layouts for ingestion into analytical processors like Excel or Google Sheets.
* **Export PDF Layouts:** Embedded print layouts configured via CSS print rules to output structured document printouts directly through web browser engines.
* **Stateful Dark Mode Interface Toggle:** Interactive interface option featuring system color scheme storage cached within the client's `localStorage` profile.
* **REST API Gateway Integration:** Programmatic API endpoints mapped for third-party application consumers and future integration extensions.

## 🛠️ Technical Architecture & Infrastructure

The application is engineered using the **Laravel Monolith Architecture**, modernly packaged into a **Docker Container** ecosystem. Component isolation is strictly enforced at the runtime environment layer via a virtual bridge network driver.

### System Topology Diagram

```text
[ Browser / Client UI ] 
         │
         ▼ (Port 8081 / HTTP Inbound Cloud Traffic)
┌──────────────── Azure Linux VM (Ubuntu Server) ────────────────┐
│                                                                │
│  ┌─────────────── Docker Compose Network ───────────────────┐  │
│  │                                                          │  │
│  │   [ Container: inlife_web ]                              │  │
│  │   (Laravel Engine / PHP-FPM Web Service)                 │  │
│  │         │                                                │  │
│  │         ▼ (Port 3306 Internal Bridge)                    │  │
│  │   [ Container: inlife_db ]                               │  │
│  │   (Isolated MySQL Engine Container)                      │  │
│  │         │                                                │  │
│  │         ▼ (Volume Hardening Bridge)                      │  │
│  │   [ Host Azure Directory: ./storage ] ◄──(Persist Data)  │  │
│  │                                                          │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                │
│  [ Native Host Application: phpMyAdmin ]                       │
│  (Connected via 127.0.0.1:8080 Local Loopback Bypass)          │
│                                                                │
└────────────────────────────────────────────────────────────────┘
```

### Technology Stack Components

| Component | Technology | Target Version | Deployment Role / Purpose |
|---|---|---|---|
| **Core Framework** | Laravel | ^12.0 | Full-stack monolithic enterprise application engine. |
| **Database Server** | MySQL | 8.0 | Relational Database Management System (RDBMS). |
| **Container Engine**| Docker | Latest | OCI-compliant virtualization wrapper for micro-environments. |
| **Orchestrator** | Docker Compose | Latest | Multi-container runtime setup and network configuration. |
| **DBMS Interface** | phpMyAdmin | Latest | Native host environment visual DB manager via local loopback. |
| **Cloud Provider** | Microsoft Azure | Ubuntu VM | High-availability hosting server architecture infrastructure. |

### 📂 Project Directory Structure
```plaintext
inventory-app/
├── app/
│   ├── Http/
│   │   └── Controllers/     # Core inventory & user authentication controllers
│   ├── Models/              # Database entities mappings
│   └── Services/            # System Dynamics forecasting mathematics logic 💻
├── config/                  # Global system definition components
├── database/
│   ├── migrations/          # Declarative schema build blueprints
│   └── seeders/             # Initial master data insertion files
├── docker-compose.yml       # Production environment Docker orchestrator definition 🔑
├── Dockerfile               # Web infrastructure base deployment build recipe
├── .env.example             # Global pipeline distribution settings template
├── .gitignore               # Strict version control restrictions directory rules
├── public/
│   └── storage ──► symlink  # Virtual link channel pointing directly to app storage
└── storage/
    └── app/
        └── public/          # Physical directory capturing permanent media uploads
```

---

## 🔒 Configuration & Operational Data Hardening

### 1. Docker Volume Hardening (Anti-Ephemeral Pattern)
By default, container engines are ephemeral (all internal data is destroyed if the container is restarted or redeployed). To prevent losing asset media/image files uploaded by users, Assetify implements a Volume Mounting Hardening technique within the `docker-compose.yml` manifest:

```yaml
  web:
    container_name: inlife_web
    volumes:
      - ./:/var/www/html
      - ./storage:/var/www/html/storage  # Data Hardening Anchor
```
This structural binding instructs Docker to store media assets safely outside the container's temporary lifecycle, anchoring them permanently within the physical file system of the Azure Cloud VM host.

### 2. Isolated Database Schema Migration & CLI Injection
Initial database schema state integrity is cleanly injected via a Command Line Interface (CLI) Direct Bypass Pipeline straight into the heart of the isolated database container (`inlife_db`) using the following execution path:

```bash
sudo docker exec -i inlife_db mysql -u sinta -ppassword123 db_inventory_telkomsel < database_backup.sql
```
This operational mechanism prevents exposing active database ports to the public internet on the Azure Network Security Group, strengthening the platform's security boundaries.

---

## 🚀 Deployment & Installation Guide

### Prerequisites
* Docker & Docker Compose natively installed on your local workstation/cloud server.
* Active SSH communication access (Port 22 open on Azure Security Groups configuration).

### Step-by-Step Installation

1. **Clone this repository into your server deployment directory:**
   ```bash
   cd /var/www/assetify
   git clone https://github.com/sintadewi21/Assetify.git
   cd Assetify/inventory-app
   ```

2. **Configure Global Environment Variables:**
   Duplicate the provided configuration boilerplate, instantiate a new `.env` file, and adjust your Docker database internal configurations alongside your settings:
   ```bash
   cp .env.example .env
   nano .env
   ```

3. **Execute Docker Compose Orchestration:**
   Build, instantiate, and spin up the multi-container isolated micro-ecosystem in the background (detached mode):
   ```bash
   sudo docker compose up -d
   ```

4. **Initialize App Storage Symlink:**
   Bridge the internal storage framework paths to the public directory so that uploaded image assets can be processed and rendered seamlessly by public client browsers:
   ```bash
   sudo docker compose exec web php artisan storage:link
   ```

5. **Run Database Migrations & Seeders (For clean setup):**
   ```bash
   sudo docker compose exec web php artisan migrate --seed
   ```

6. **Access Live Platform Environments:**
   Fire up your browser engine and route your web requests to the designated target addresses:
   * **Main Application Platform:** [http://assetify.eastasia.cloudapp.azure.com:8081](http://assetify.eastasia.cloudapp.azure.com:8081)
   * **Database Admin Interface:** `http://20.212.249.9:8080` (Proxied securely via local loopback `127.0.0.1`)

---

## 🧪 Automated Testing

The project includes **60 automated test cases (Feature & Unit Tests)** validating authentication, authorization, CRUD master data, and transaction logs.
To run the local test suite inside the Docker container:
```bash
sudo docker compose exec web php artisan test
```

---

## 🌐 REST API Documentation

The REST API endpoints are served under the `/api` prefix, returning standardized JSON formats.

### 1. Products API
* **GET `/api/products`**: Fetch all products. Supports search (e.g., `?search=Lenovo`).
* **GET `/api/products/{id}`**: Fetch product details.
* **POST `/api/products`**: Create a new product.
  * Fields: `category_id` (int), `code` (string, unique), `name` (string), `stock` (int), `location` (string), `condition` (Bagus/Rusak Ringan/Rusak Berat), `image` (file).
* **PUT `/api/products/{id}`**: Update product details.
* **DELETE `/api/products/{id}`**: Delete a product.

### 2. Categories API
* **GET `/api/categories`**: Fetch all categories.

### 3. Loans API
* **GET `/api/loans`**: Fetch all borrowing logs.
* **POST `/api/loans`**: Create a new multi-item loan request.
  * JSON Body Example:
    ```json
    {
      "user_id": 2,
      "borrower_name": "Andi Wijaya (IT Support)",
      "borrow_date": "2026-07-04",
      "products": [
        { "product_id": 1, "qty": 2 },
        { "product_id": 2, "qty": 1 }
      ]
    }
    ```

---

## 🤝 Conclusion
Assetify successfully bridges the gap between conventional log recording systems and predictive inventory planning. Supported by a rock-solid Docker containerization infrastructure on Microsoft Azure, the platform guarantees high performance, isolated persistent data management, and reliable System Dynamics execution to support long-term institutional asset governance.

Sinta Dewi Rahmawati - Goes to be intern with InLife
