# phpmiro

Micro-framework em PHP para estudar arquitetura em camadas (Model + Entity),
testando um meio-termo entre Active Record e Data Mapper.

## Ambiente (Docker)

### Subir o ambiente
```bash
docker compose build
docker compose up -d
```

### Comandos úteis
```bash
docker compose down          # para o ambiente
docker compose down -v       # para e remove volumes
docker ps                    # containers rodando
docker ps -a                 # todos os containers
docker exec -it phpmiro bash # entra no container
``` 

### Debug
``` bash
docker logs <containerId>
docker inspect <containerId>
```
## Notas
<!-- aqui você explica o porquê de cada escolha, os problemas que já enfrentou, o que ainda falta -->