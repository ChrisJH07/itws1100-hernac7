# Quiz 3 — Soccer Trivia Quiz
**hernac7 | ITWS 1100**

## Live URL
http://hernac7rpi.eastus.cloudapp.azure.com/iit/quiz3/index.php

## File Structure
```
quiz3/
├── index.php         # Main quiz page (HTML + jQuery)
├── questions.php     # AJAX endpoint — returns 8 random questions as JSON
├── save-score.php    # AJAX endpoint — POSTs final score to DB
├── db.php            # Database connection (credentials here)
├── setup.sql         # CREATE TABLE statements + seed data
├── .htaccess         # Password protection for this folder
├── prompt-log.md     # D2 — AI prompt history
├── break-it.md       # D4 — SQL injection and XSS exercise
└── README.md         # This file
```

## Setup Instructions
1. Run `setup.sql` against your MySQL database
2. Update credentials in `db.php`
3. Create `.htpasswd` file: `htpasswd -c /etc/apache2/.htpasswd_quiz3 hernac7`
4. Make sure `AllowOverride All` is set in your Apache VirtualHost config
