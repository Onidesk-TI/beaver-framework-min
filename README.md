## Beaver Min — WSL Installation Manual
This guide covers installing Beaver Min on Windows Subsystem for Linux (WSL 2), from requirements to first server run.

1. Requirements
Requirement	Minimum	Recommended
Windows	Windows 10 (build 19041+) or Windows 11	Windows 11
WSL	WSL 2	WSL 2 with systemd enabled
Linux distro	Ubuntu 22.04 LTS	Ubuntu 24.04 LTS
PHP	8.3+	8.3+ with opcache
PHP extensions	sqlite3, mbstring, xml, curl, zip	+ opcache
Composer	2.x	2.x (latest)
Database	SQLite (included in PHP)	SQLite or MySQL
Git	To clone the repository	Git
Note: Beaver Min is designed to run on Linux. WSL 2 gives you a real Linux environment inside Windows, without WSL 1's slowness and without Windows path differences.

2. Install WSL 2 and Ubuntu
Open PowerShell as Administrator and run:

powershell
wsl --install
This installs WSL 2 and the default Ubuntu distribution. Restart your computer when prompted.

After restart, Ubuntu asks you to create a username and password. Save them.

Confirm you're on WSL 2:

bash
wsl --list --verbose
It should show VERSION 2 next to Ubuntu. If it shows 1, convert it:

powershell
wsl --set-version Ubuntu 2
(Optional) Enable systemd
If you want to use systemctl (for services like Nginx or PHP-FPM):

bash
sudo nano /etc/wsl.conf
Add:

ini
[boot]
systemd=true
Save, close WSL, and restart it in PowerShell:

powershell
wsl --shutdown
3. Install PHP 8.3 and Extensions
Inside WSL (Ubuntu terminal), run:

bash
# 1. Update the system
sudo apt update && sudo apt upgrade -y

# 2. Add the Ondřej Surý PPA (up-to-date PHP)
sudo apt install -y software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update

# 3. Install PHP 8.3 + required extensions
sudo apt install -y php8.3-cli php8.3-fpm php8.3-sqlite3 php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip php8.3-opcache
Why the Ondřej PPA? Ubuntu's official repositories may not have the latest 8.3 version. The PPA gives you access to updated, maintained versions.

Verify the installation:

bash
php -v
It should show PHP 8.3.x. Confirm the extensions:

bash
php -m | grep -E "sqlite3|mbstring|xml|curl|zip|opcache"
All should appear in the list.

4. Install Composer
bash
# 1. Download the installer
curl -sS https://getcomposer.org/installer | php

# 2. Move to global PATH
sudo mv composer.phar /usr/local/bin/composer
sudo chmod +x /usr/local/bin/composer

# 3. Verify
composer --version
It should show Composer version 2.x.x.

5. Install SQLite (if needed)
PHP already includes the SQLite driver (php8.3-sqlite3), but if you need the SQLite CLI to inspect the database:

bash
sudo apt install -y sqlite3
Verify:

bash
sqlite3 --version
6. Clone Beaver Min
bash
# 1. Go to your WSL home (DO NOT use /mnt/c/ — it's slow)
cd ~

# 2. Create a projects folder
mkdir -p ~/projects
cd ~/projects

# 3. Clone the repository
git clone https://github.com/Onidesk-TI/beaver-framework-min.git
cd beaver-framework-min
Important: keep project files on the Linux filesystem (/home/youruser/), not on /mnt/c/. Composer and file watchers are much faster on native Linux.

7. Configure the Environment
bash
# 1. Copy the environment template
cp .env.example .env

# 2. Edit .env
nano .env
Minimum settings in .env:

env
APP_NAME="Beaver Min"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:9000

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Generate the key with: php beaver key:generate
APP_KEY=
Save (Ctrl+O, Enter, Ctrl+X).

Generate the APP_KEY
bash
php beaver key:generate
If the command doesn't exist, generate a key manually:

bash
php -r "echo 'base64:'.base64_encode(random_bytes(32));"
Copy the result and paste it into .env at APP_KEY=.

8. Install Dependencies (if applicable)
If the project uses Composer for external dependencies:

bash
composer install
If there are no external dependencies (minimalist project), you can skip this step.

9. Create the SQLite Database
bash
# Create the database file (if it doesn't exist)
touch database/database.sqlite

# (Optional) Run migrations, if any
php beaver migrate
10. Start the Development Server
Beaver Min uses PHP's built-in server with a custom router:

bash
php -S localhost:9000 -t public router.php
Or, if the project has a serve command:

bash
php beaver serve
Expected output:

text
PHP 8.3.x Development Server (http://localhost:9000) started
Open your browser (on Windows) and go to:

http://localhost:9000

You should see the Beaver Min homepage.

11. Verify Performance
To confirm everything is fast:

bash
# 10 consecutive requests
for i in {1..10}; do
  curl -s -o /dev/null -w "Request $i: %{time_total}s\n" http://localhost:9000
done
Expected output (with opcache enabled): ~4–8 ms per request.

12. Troubleshooting
Error: php: command not found
PHP isn't in PATH or wasn't installed correctly. Check:

bash
which php
php -v
If nothing appears, reinstall PHP (sudo apt install php8.3-cli).

Error: Class "PDO" not found
The SQLite extension is missing. Install:

bash
sudo apt install php8.3-sqlite3
sudo systemctl restart php8.3-fpm  # if using FPM
Error: Composer could not find a composer.json
You're in the wrong folder. Confirm you're in ~/projects/beaver-framework-min.

Error: Permission denied when creating database.sqlite
Check the database/ folder permissions:

bash
ls -la database/
chmod 755 database/
Slow server on WSL
Do not put the project in /mnt/c/ (Windows filesystem). Use ~/projects/.

Enable opcache in php.ini:

bash
php --ini
# Edit the indicated file and add:
# opcache.enable=1
# opcache.memory_consumption=128
Port 9000 already in use
Change the port:

bash
php -S localhost:9001 -t public router.php
Git authentication error (if you cloned via HTTPS)
Use SSH instead of HTTPS:

bash
git remote set-url origin git@github.com:Onidesk-TI/beaver-framework-min.git
And configure the SSH key on GitHub [see previous manual].

13. Folder Structure (reference)
text
beaver-framework-min/
├── app/                 # Controllers, Models, Views
├── config/              # Configuration
├── database/            # SQLite (ignored in Git)
├── public/              # Web root
│   ├── index.php        # Entry point
│   └── router.php       # Dev server router
├── routes/
│   └── web.php          # Routes
├── src/                 # Framework core
├── storage/             # Logs, cache, sessions
├── .env                 # Environment (DO NOT version)
├── .env.example         # Template
├── composer.json
└── README.md
Quick Summary (TL;DR)
bash
# 1. WSL
wsl --install

# 2. PHP + Composer
sudo apt update
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.3-cli php8.3-sqlite3 php8.3-mbstring php8.3-xml php8.3-curl php8.3-zip
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# 3. Project
cd ~/projects
git clone https://github.com/Onidesk-TI/beaver-framework-min.git
cd beaver-framework-min
cp .env.example .env
touch database/database.sqlite

# 4. Start
php -S localhost:9000 -t public router.php
Access at: http://localhost:9000

Let me know if any step fails — paste the exact error and I'll adjust the manual.