# Cinch Coding Assignment

## Overview
Simple e-commerce microservices:
- Catalog (Laravel) — product listing
- Checkout (Laravel) — place orders
- Email (Laravel) — send order summaries

Tech: PHP (Laravel), Vue.js (frontend), MySQL, Docker, AWS EC2, CloudFormation.

Frontend url: http://54.206.134.205/

API
Catalog: http://54.206.134.205:8000<br>
Checkout: http://54.206.134.205:8001<br>
Email: http://54.206.134.205:8002<br>


## Repo structure

cinch-coding-assignment/<br>
├─ README.md<br>
├─ infra/<br>
│  └─ cloudformation.yml<br>
├─ services/<br>
│  ├─ catalog/                   # Laravel app<br>
│  │  ├─ Dockerfile<br>
│  │  ├─ src/                    # Laravel app files<br>
│  │  └─ docker-compose.override.yml
│  ├─ checkout/                  # Laravel app<br>
│  │  ├─ Dockerfile<br>
│  │  └─ src/<br>
│  └─ email/                     # Laravel app<br>
│     ├─ Dockerfile<br>
│     └─ src/<br>
├─ docker-compose.yml<br>
├─ frontend/<br>
└─ scripts/<br>
   └─ ec2-user-data.sh           # optional: for EC2 user data to pull repo & run docker-compose<br>
<br>

   Cloud formation info:<br>
   https://github.com/lilcojje/cinch-ecommerce/blob/main/infra/cloudformation.yml<br>

