# Anpa Stiftung - Website scaffold

This repository contains a lightweight PHP scaffold for a foundation website. It's designed to run on shared hosting (e.g., IONOS) and includes basic PDF generation and email integration using `mpdf` and `PHPMailer` (installed via Composer).

Quick setup

1. Set your webserver document root to the `public/` folder.
2. Run `composer install` in the project root to install dependencies.
3. Edit `config.php` to set `FROM_EMAIL` and `ADMIN_EMAIL`.
4. Ensure `storage/pdfs` is writable by the webserver.

Files added

- `public/` - public pages (index, contact, request forms)
- `templates/` - header/footer
- `src/helpers.php` - helpers for loading data, sending mail and generating PDFs
- `data/` - JSON files for team and projects
- `storage/` - generated PDFs (gitkeep present)
- `composer.json` - dependencies

Notes

- On some shared hosts you must configure SMTP in `src/helpers.php` (PHPMailer) or rely on `mail()`.
- Replace placeholder images in `public/assets/img/` with your real photos and logo.
