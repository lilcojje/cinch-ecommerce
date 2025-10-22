#!/bin/bash
# =============================================
# Cinch E-Commerce EC2 Initialization Script
# Installs Docker, Docker Compose, clones project,
# and starts all microservices containers.
# =============================================

# Update system packages
apt-get update -y
apt-get upgrade -y

# Install dependencies
apt-get install -y apt-transport-https ca-certificates curl software-properties-common git

# Install Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh

# Enable and start Docker
systemctl enable docker
systemctl start docker

# Install Docker Compose (latest stable version)
curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# Verify installations
docker --version
docker-compose --version

# Switch to the ubuntu user’s home directory
cd /home/ubuntu

# Clone your GitHub repository (replace with your own)
git clone https://github.com/YOUR_GITHUB_USERNAME/cinch-ecommerce.git
cd cinch-ecommerce

# Optional: create a .env file for shared environment variables
cat <<EOT > .env
DB_CONNECTION=mysql
DB_HOST=${RDS_ENDPOINT:-mysql}
DB_PORT=3306
DB_DATABASE=cinch_db
DB_USERNAME=cinch_user
DB_PASSWORD=cinch_pass
APP_ENV=production
APP_DEBUG=false
EOT

# Build and start containers
docker-compose up -d --build

# Ensure containers auto-start on reboot
cat <<'EOF' > /etc/systemd/system/docker-compose-app.service
[Unit]
Description=Docker Compose Application Service
Requires=docker.service
After=docker.service

[Service]
Type=oneshot
RemainAfterExit=yes
WorkingDirectory=/home/ubuntu/cinch-ecommerce
ExecStart=/usr/local/bin/docker-compose up -d
ExecStop=/usr/local/bin/docker-compose down

[Install]
WantedBy=multi-user.target
EOF

systemctl enable docker-compose-app.service

echo "Cinch E-Commerce microservices are now running!"
