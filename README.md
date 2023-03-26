## Installation
- Copy the sample environment variables file to the `.env` one
```
cp .env.example .env
```
- Start the docker
```
docker-compose up -d
```


## Process
- Start to put the docker stuffs to `dev-docker`, the reason to use `dev-docker` name is to easily delete development stuffs with needed by using `rm -rf dev-*`
- Reorganize Laravel app using DDD (similar to this article https://bitloops.com/docs/bitloops-language/learning/domain-driven-design)
- Create the migration rule for Admin and Customer and create a console command to create the Admin user
