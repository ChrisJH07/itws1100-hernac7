# Lab 10 - Production Deployment, SSL & Auto-Deploy

**ITWS 1100 - Intro to IT & Web Science**

## Overview

This lab deploys the site to production with HTTPS, per-folder password protection, and automatic deployment via GitHub webhooks.

## Live Site

- FQDN: `https://hernac7rpi.eastus.cloudapp.azure.com`
- GitHub Repo: https://github.com/ChrisJH07/ITWS1100-hernac7

## What Was Done

- **Part 1**: Created PHP redirect at web root so `https://hernac7rpi.eastus.cloudapp.azure.com` goes straight to the homepage
- **Part 2**: Per-folder `.htaccess` protection on Lab 1 and Lab 9; lock icons on projects page
- **Part 3**: SSL/HTTPS via Let's Encrypt (Certbot)
- **Part 4**: GitHub webhook auto-deploy handler (`deploy.php`)
