#How to use Backup plugin

####Active this plugin
Go through to **Admin Dashboard** --> **Plugins** --> Enable and install this plugin.

####Before start:
- I use **mysqldump** command to backup the database. Your host need to support this function.
If you cannot create database backup, maybe you need to setup your dump path.
Open your **.env**:

Here is an example for AMPPS:
```
DB_DUMP_PATH=/Applications/AMPPS/mysql/bin/
```