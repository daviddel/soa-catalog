#!/bin/bash

read -p 'Ref : ' ref

curl -v -H "Accept: application/json" -H "Content-type: application/json" -XPOST -d '
{"property":{"key":"'$ref'","name":"Property","locale":"fr_FR"}}
' http://ecommerce.dev/app_dev.php/api/fr_FR/properties/create.json

curl -v -H "Accept: application/json" -H "Content-type: application/json" -XPOST -d '
{"product":{"reference":"'$ref'","name":"Product posted by API","description":"Product posted by API","locale":"fr_FR"}}
' http://ecommerce.dev/app_dev.php/api/fr_FR/products/create.json

curl -v -H "Accept: application/json" -H "Content-type: application/json" -XPOST -d '
{"variant":{}}
' http://ecommerce.dev/app_dev.php/api/fr_FR/products/$ref/variants/add.json

curl -v -H "Accept: application/json" -H "Content-type: application/json" -XPOST -d '
{"subscribed_property":{"property":{"key":"'$ref'"},"value":"PROP1 VALUE"}}
' http://ecommerce.dev/app_dev.php/api/fr_FR/products/$ref/properties/add.json