# Projet chef d'oeuvre

Le projet Chef d'Oeuvre est un projet qui me permet d'experimenter toutes les technologies que je souhaite.

Ce projet repose sur un socle Symfony 5 et VueJs 3 et utilise docker pour toutes les briques exteners (elasticsearch, mysql, redis ...)

###Technologies :
- PHP 8
- Symfony 5
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
symfony serve
```

### Docker : 
```bash
docker-composer up
```

### Ports externes utilisés
- Adminer : 8089
- ElasticSearch : 9209
- Kibana : 5601

TODO
-----
- [x] Where is ISS
- [ ] Recherche en Elastica
- [ ] Mercure
- [ ] Symfony workflow
- [ ] Php Unit + Panther
- [ ] Tester CI/CD
- [ ] Redis
- [ ] Matomo 
- [ ] Mailhog / Mail Dev 
- [ ] N8n ? 
- [ ] Logs dans KIBANA
Fonctionnalité: 
- [ ] Afficher le contour d'une commune (avec les coordonnées GPS)




