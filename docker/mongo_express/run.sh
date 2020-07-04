#!/bin/bash
set -e

docker run -it --rm \
	--link web_db_1:mongo \
	--name mongo-express-docker \
	-p 8081:8081 \
	mongo-express-docker "$@"
