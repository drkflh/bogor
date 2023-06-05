# Sapimoo

## Guides

### Mongo connection
Inside project directory, download AWS public key for documentDB:
```
wget https://s3.amazonaws.com/rds-downloads/rds-combined-ca-bundle.pem
```

Get ec2 private key for tunelling `sapimoo.pem` and run:
```
chmod 400 sapimoo.pem
```

Create SSH tunnel on local machine through ec2 instance given:
```
ssh -i "sapimoo.pem" -L 27017:sapimoo-db.cluster-c4cbm3zf3vwu.ap-southeast-1.docdb.amazonaws.com:27017 ubuntu@ec2-13-250-126-187.ap-southeast-1.compute.amazonaws.com -N 
```

Connect using mongo client:
```
mongo --sslAllowInvalidHostnames --ssl --sslCAFile rds-combined-ca-bundle.pem --username <username> --password <password>
```

Using connection string:
```
"mongodb://<user>:<password>!@<host>:<port>/?retryWrites=false&sslAllowInvalidHostnames=true&ssl=true&ssl_ca_certs=/path/to/rds-combined-ca-bundle.pem"
```

Change `sslAllowInvalidHostnames` to `tlsAllowInvalidCertificates` if unsopported.

### Persisting SSH Tunnel
Use session manager like [screen](https://www.gnu.org/software/screen/manual/screen.html) or [tmux](https://tmuxguide.readthedocs.io/en/latest/tmux/tmux.html)

Create new tmux session:
```
tmux new -s tunnel
```

Run ssh tunneling command like above.
```
ssh -i "sapimoo.pem" -L 27017:sapimoo-db.cluster-c4cbm3zf3vwu.ap-southeast-1.docdb.amazonaws.com:27017 ubuntu@ec2-13-250-126-187.ap-southeast-1.compute.amazonaws.com -N 
```

Detach session:
```
Ctrl+b and then d
```

List All Tmux Session :
```
tmux ls
```

Login Back to Tmux Session:
```
tmux attach -t [name session]
```

### Application Setup

Clone from repo , the change to app root directory

set permission for directories : ``storage`` & ``bootstrap/cache`` to be readable by application and web server

note: depending on your security concerns, this might be 775 or 777
```
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```
copy env from ``seed`` directory to app root
```
cp seeds/sapimoo_env .env
```
Install Laravel dependency using composer

note : .env harus ada sebelum melakukan composer install
```
php composer install
```
Install javascript dependency using npm
```
npm install
```
Compile app.js bundle for front end
```
npm run prod
```

### Environment & Dependency

- install nginx
- install node.js ( & npm )
- install composer ( getcomposer.com )
- install php 7.4
- install php mongodb driver ( menggunakan PECL )
    ```
    pecl install mongodb
    ```
