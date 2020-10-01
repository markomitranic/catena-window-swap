# Catena Windowswap

## Setting Up
Deployment to production is done by simply running `./deploy.sh` script. But, before we do that, it does make some assumptions:
1. The script will source environment, `.env` file as well as `.env.local` if present. In that order.
2. You would be advised to update `UPLOADS_DIR` variable with a real location where uploads will be stored, outside the project.
3. The script will assume that you have updated the `EXTERNAL_SSL_CERT_DIR` variable with a location of a folder with the certificates. The cert must be named `cert.cer` and `cert.key` respectively.
 
### Development Setup
In essence, its even easier. No certs, no uploads. Just run `./deploy_dev.sh`.

### Useful snippets:
1. `docker exec -ti windowswap_server bin/console fixtures:populate` - Creates 10 random videos in the database.


# API Docs
- **[GET]** /api/videos/random - Returns a random (confirmed) video from the DB. 
- **[GET]** /api/videos/submit - Displays a list of videos that are pending confirmation.
- **[POST]** /api/videos/submit - Attempt to submit a video for confirmation. Params: `name`, `location`, `video`

# Future prospects

## Ansible Log
Since i didnt have enough time to ansible it, here is the log from prod server setup:
```
#!/bin/bash

apt-get update
apt-get remove docker docker-engine docker.io containerd runc

apt-get install -y \
ufw \
git \
nano \
gnupg \
curl \
wget \
apt-transport-https \
ca-certificates \
software-properties-common \
gnupg-agent

curl -fsSL https://download.docker.com/linux/debian/gpg | sudo apt-key add -
apt-key fingerprint 0EBFCD88
add-apt-repository \
"deb [arch=amd64] https://download.docker.com/linux/debian \
$(lsb_release -cs) \
stable"

apt-get update
apt-get install docker-ce docker-ce-cli containerd.io
curl -L "https://github.com/docker/compose/releases/download/1.27.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

ufw default deny incoming
ufw default allow outgoing
ufw allow ssh
ufw allow 80
ufw allow 443
ufw enable

# Make a deploy key
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"
eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_rsa
```
