# Projekt Muna

##Prerequisites:
- Apache web server
- Postgre DB instance
- PHP 7.4
- Rename config.php.sample to config.php and fill in the required DB data

## Finished:
- Routing system (controller/action)
- Service which checks if a given string is valid
- Insert into / fetch records from database (PostgreSQL)
- String check method is accessible via HTTP POST request (testing done with Postman)

## To do:
- Implement caching layer (Redis)
- Implement other protocols (protobuf, jsonrpc) and transport routes (TCP, UDP)
- Implement "finished" state which resets on server restart