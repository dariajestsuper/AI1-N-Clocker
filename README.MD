## BACKEND:
- `docker-compose up -d`
- `docker exec -it clocker_web bash`
- `composer install`
- `vendor/bin/doctrine orm:schema-tool:update --force`

## FRONTEND:
- `exit`(if in docker container)
- `cd client`
- `npm install`
- `npm run start`