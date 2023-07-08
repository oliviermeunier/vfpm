### Installation

1. Clone repository
2. Run `composer install` 
3. Create production database and test database with the migration file vfpm.sql
4. Create and configure .env.local and .env.test 

### Run tests

Run `vendor/bin/behat`

### Commands

php bin/fleet create <userId> 

php bin/fleet register-vehicle <fleetId> <vehiclePlateNumber>

php bin/fleet localize-vehicle <fleetId> <vehiclePlateNumber> lat lng [alt]