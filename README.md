# 📦 Assetify - Integrated Library Inventory Management System

Course Assignment / Capstone Project: **ES234632 Systems Development and Operations**  
Department of Information Systems, **Institut Teknologi Sepuluh Nopember (ITS)**  
Live Deployment Target: [http://assetify.eastasia.cloudapp.azure.com](http://assetify.eastasia.cloudapp.azure.com)

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
