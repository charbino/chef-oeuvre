# Projet chef d'oeuvre

Le projet Chef d'Oeuvre est un projet qui me permet d'experimenter toutes les technologies afin de faire de le veille.

Ce projet repose sur un socle Symfony 6.1 et VueJs 3 et utilise docker pour toutes les briques externes (elasticsearch, mysql, redis ...)

Pour le front, j'utilise le framework css [bulma](https://bulma.io/).
### Technologies :
- PHP 8.1
- Symfony 6.2
- VueJs 3


Installation
------------
```bash
composer install
npm install
```


Usage
-----
### Serveur symfony : 
```bash
cd my_project/
symfony serve:start -d
```

### Docker : 
```bash
docker-composer up -d
```

### Ports externes utilisés
- Adminer : 8089
- ElasticSearch : 9209
- Kibana : 5601
- Rabbitmq (15673)
- N8n (5678)
- Maildev (1180)
- Minio (9002)

TODO
-----
- [x] Where is ISS
- [ ] Recherche en Elastica
- [ ] Mercure
- [ ] Symfony workflow
- [ ] Php Unit + Panther
- [ ] Tester CI/CD
- [x] Redis
- [ ] Matomo 
- [x] Mailhog / Mail Dev 
- [x] N8n  
- [ ] Logs dans KIBANA
- [ ] Charts JS
- 
  symfony open:local:rabbitmq

#### Fonctionnalitées: 
- [x] Afficher le contour d'une commune, d'un départements et du cadastre


#### Data
- [Cadastre](https://api.gouv.fr/documentation/api_carto_cadastre)
- [Public Apis](https://github.com/public-apis/public-apis)
- [Basket](https://www.balldontlie.io/#get-all-players)


