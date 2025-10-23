# Cinch Coding Assignment

## Overview
Simple e-commerce microservices:
- Catalog (Laravel) — product listing
- Checkout (Laravel) — place orders
- Email (Laravel) — send order summaries

Tech: PHP (Laravel), Vue.js (frontend), MySQL, Docker, AWS EC2, CloudFormation.

Frontend url: http://54.206.134.205/

API
Catalog: http://54.206.134.205:8000
Checkout: http://54.206.134.205:8001
Email: http://54.206.134.205:8002


## Repo structure

cinch-coding-assignment/
├─ README.md
├─ infra/
│  └─ cloudformation.yml
├─ services/
│  ├─ catalog/                   # Laravel app
│  │  ├─ Dockerfile
│  │  ├─ src/                    # Laravel app files
│  │  └─ docker-compose.override.yml
│  ├─ checkout/                  # Laravel app
│  │  ├─ Dockerfile
│  │  └─ src/
│  └─ email/                     # Laravel app
│     ├─ Dockerfile
│     └─ src/
├─ docker-compose.yml
├─ frontend/
└─ scripts/
   └─ ec2-user-data.sh           # optional: for EC2 user data to pull repo & run docker-compose


   Cloud formation info:
   https://github.com/lilcojje/cinch-ecommerce/blob/main/infra/cloudformation.yml

