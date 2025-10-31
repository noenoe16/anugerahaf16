# Monitoring CCTV RU VI Balongan (Laravel 12 + Livewire 3 + Flux)

This project implements a full-stack CCTV monitoring system with roles (Admin/User), HLS streaming from RTSP via FFmpeg, Leaflet maps, realtime notifications/messages (DB-backed), and XLSX exports.

## Requirements
- PHP 8.2+
- Composer
- Node.js (for Vite assets if you modify frontend)
- FFmpeg installed and added to PATH (required for streaming)

## Quick Start
1. Copy env and key
```
cp .env.example .env
php artisan key:generate
```
2. Database (SQLite default): already configured in `config/database.php`.
3. Migrate & seed
```
php artisan migrate --seed
```
4. Storage link
```
php artisan storage:link
```
5. Serve app
```
php artisan serve
```

## FFmpeg Streaming
- Place FFmpeg on PATH (Windows: install ffmpeg from gyan.dev or scoop/choco).
- Start streaming all configured CCTVs to public HLS:
```
php artisan cctv:stream
```
Output segments are written to `public/live/*.m3u8`. The UI will build the correct URL automatically.

## Roles & Auth
- Roles: `admin`, `user` (`users.role`).
- Admin navigation includes Users, Buildings, Rooms, CCTVs, Contacts, Maps, Notifications, Messages.
- User navigation includes Dashboard, Maps, Locations, Contacts, Notifications, Messages.

## Maps
- Leaflet with OSM and Satellite toggle.
- Status filters: Online (green), Offline (red), Maintenance (yellow).
- Clicking Live opens an HLS player modal.

## Messaging & Notifications
- Messages stored in `messages` table.
- Notifications use database channel and are polled at `/api/notifications`.
- Login triggers a Login notification.

## Exports (XLSX)
- Exports are available on Admin Dashboard as XLSX using OpenSpout.
- Endpoints:
  - `admin/export/buildings`
  - `admin/export/rooms`
  - `admin/export/cctvs`

## Production Readiness (Windows)
### Queue Worker
- Queue driver: database (default). Start a worker:
```
php artisan queue:work --tries=3
```
- (Optional) Register as a Scheduled Task to run on logon:
```
pwsh -NoProfile -File .\scripts\register-queue-worker.ps1
```

### Scheduler
- Run every minute:
```
pwsh -NoProfile -File .\scripts\register-scheduler.ps1
```
This registers a Windows Task that runs:
```
pwsh -NoProfile -File .\scripts\run-schedule.ps1
```

### Streaming on Startup (optional)
- Register a startup task:
```
pwsh -NoProfile -File .\scripts\register-streaming.ps1
```

## Mail (Gmail SMTP)
Set in `.env`:
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=youraddress@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=youraddress@gmail.com
MAIL_FROM_NAME="KILANG PERTAMINA INTERNASIONAL"
```
Use a Gmail App Password (2FA required), not your main password.

## Commands
- Stream all CCTVs: `php artisan cctv:stream`
- Run queue worker: `php artisan queue:work --tries=3`
- Run scheduler once: `php artisan schedule:run`

## Notes
- Seed includes 18 buildings and sample rooms/CCTVs.
- Theme toggle in header/sidebar and settings/appearance.
- All admin CRUD pages are stubbed with simple forms and tables.
