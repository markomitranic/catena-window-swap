# Catena Windowswap

## Setting Up
Deployment to production is done by simply running `./deploy.sh` script. But, before we do that, it does make some assumptions:
1. The script will source environment, `.env` file as well as `.env.local` if present. In that order.
2. You would be advised to update `UPLOADS_DIR` variable with a real location where uploads will be stored, outside the project.
3. The script will assume that you have updated the `EXTERNAL_SSL_CERT_DIR` variable with a location of a folder with the certificates. The cert must be named `cert.cer` and `cert.key` respectively.
 
### Development Setup
In essence, its even easier. No certs, no uploads. Just run `./deploy_dev.sh`.

## Useful snippets:
1. `docker exec -ti windowswap_server bin/console fixtures:populate` - Creates 10 random videos in the database.
