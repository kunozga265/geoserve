## Geseorve Engineering App

Geoserve Engineering Group is a company that is involved in various engineering work. The
work is centered on projects that are funded and have to be managed by assigned personnel.
The company is looking to automate their workflow to eliminate delay in approving requests,
failure to reconcile money spent and unorganized filing system.

### Project Scope
- Account Management
- Requests Management
- Projects Management
- Vehicles Management

### Process Flow
1. Creation of users
2. Creation of projects
3. Request generation
4. Automatically determining users responsible for approvals
5. Approved request sent to finance
6. Money is released
7. Request is reconciled

### Deployment

#### Set up database
```
php artisan migrate     //to create db structure 
php artisan db:seed     //to seed important data
```
Note: Edit UserTableSeeder.php with the right credentials for the Managing Director (as the superuser of the system) 

#### Set up mail service
Ensure your .env is set up and the mail server settings are configured. After a successful setup, run the queue worker:
```
php artisan queue:work                      //development
nohup php artisan queue:work --daemon &     //production (shared hosting)
```

