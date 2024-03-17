# MTLAGA

Is a web application for consulting schedule of trains and buses in Switzerland

## Pre-requisites

- Docker
- Docker-compose

## Usage

### Development

Run the following command to start the development environment:

```bash
docker-compose up
```

The application will be available at `http://localhost:80`

### Production

A CI/CD pipeline is already set up for this project. It will automatically create 3 Docker images and push them to the Github Container Registry. The images are:

- `php-fpm`
- `nginx`
- `mysql`

To deploy the application, you can create your own `docker-compose.yml` file and use the images from the Github Container Registry.
