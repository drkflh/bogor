echo "Connecting to DocumentDB"
#ssh -f -N -L  27019:127.0.0.1:27017 root@128.199.201.196 -p 22 -C
ssh -i "sapimoo.pem" -L 27030:sapimoo-db.cluster-c4cbm3zf3vwu.ap-southeast-1.docdb.amazonaws.com:27017 ubuntu@ec2-13-250-126-187.ap-southeast-1.compute.amazonaws.com -N
