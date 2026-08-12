steps to up environment

1 -> docker compose build
2 -> docker compose up or docker compose up -d

extra:
    docker compose build --no-cache
    docker compose down
    docker compose down -v or --volumes
    docker ps
    docker ps -a
    docker images
    docker images -a
    docker container ls

    docker exec -it phpmiro bash

    docker inspect <containerId>
    docker logs <containerId>

    docker --help
    docker inspect --help
    docker compose --help
    docker compose up --help

bash tip:
    ls -lahS -> Displays all files sorted by size and their permissions

docker-compose linter:

docker run -it --rm -v ${PWD}:/app \
    zavoloklom/dclint docker-compose.yml

docker run -it --rm -v ${PWD}:/app \
    zavoloklom/dclint docker-compose.yaml

docker run -it --rm -v ${PWD}:/app \
    zavoloklom/dclint compose.yml

docker run -it --rm -v ${PWD}:/app \
    zavoloklom/dclint docker-compose.yml --fix
