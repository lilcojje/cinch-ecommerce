# Cinch Coding Assignment

## Overview
Simple e-commerce microservices:
- Catalog (Laravel) — product listing
- Checkout (Laravel) — place orders
- Email (Laravel) — send order summaries

Tech: PHP (Laravel), Vue.js (frontend), MySQL, Docker, AWS EC2, CloudFormation, SES, SQS.

## Repo structure
cinch-coding-assignment/
├─ README.md
├─ infra/
│  └─ cloudformation.yml
├─ services/
│  ├─ catalog/                   # Laravel app
│  │  ├─ Dockerfile
│  │  ├─ src/ (Laravel app files)
│  │  └─ docker-compose.override.yml
│  ├─ checkout/                  # Laravel app
│  │  ├─ Dockerfile
│  │  └─ src/
│  └─ email/                     # Laravel app
│     ├─ Dockerfile
│     └─ src/
├─ docker-compose.local.yml
└─ scripts/
   └─ ec2-user-data.sh           # optional: for EC2 user data to pull repo & run docker-compose


## Prerequisites (local)
- Docker & docker-compose
- Git
- PHP 8+ (only needed if running locally without docker)

## Local development
1. `git clone https://github.com/YOUR_USER/cinch-coding-assignment.git`
2. `docker-compose -f docker-compose.local.yml up --build`
3. Run migrations:
   - `docker exec -it cinch_catalog php artisan migrate --seed`
   - `docker exec -it cinch_checkout php artisan migrate`
4. Use Postman to test endpoints.
5. Mail: check MailHog at http://localhost:8025

## Deploy to AWS (CloudFormation)
1. Edit `infra/cloudformation.yml` (set KeyName, DB password, etc).
2. Deploy:
   - `aws cloudformation create-stack --stack-name cinch --template-body file://infra/cloudformation.yml --parameters ParameterKey=KeyName,ParameterValue=your-key ParameterKey=DBPassword,ParameterValue=YourDBPass --capabilities CAPABILITY_IAM`
3. After stack created, SSH to EC2 (if needed), but user-data will attempt to pull repo and start services.

## How services talk
- Checkout writes orders to DB and publishes to SQS.
- Email worker polls SQS, fetches order data from DB, sends email through SES.

## Testing
- Unit tests: `php artisan test` in each service.
- Integration: Use Postman / curl to create orders and observe emails in MailHog (dev) or SES (prod).

## Notes & improvements
- Use Secrets Manager for DB credentials
- Consider ECS or EKS for container orchestration in production
- Use RDS snapshots / Multi-AZ for resilience
