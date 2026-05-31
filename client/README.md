# client — Nuxt 4 Job Board Frontend

## Requirements
- Node.js v22+
- npm

## Setup

```bash
cd client

# 1. Install dependencies
npm install

# 2. Copy env
cp .env.example .env
# Set NUXT_PUBLIC_API_BASE to your Laravel API URL

# 3. Run dev server
npm run dev
# → http://localhost:3000
```

## Pages

| Route | Auth | Description |
|-------|------|-------------|
| `/login` | No | Sign in |
| `/register` | No | Register |
| `/` | Yes | Job listings with search & pagination |
| `/jobs/create` | Yes | Post a new job |
| `/jobs/[id]` | Yes | Job detail view |
| `/jobs/[id]/edit` | Yes | Edit a job |

## Key Structure

```
app/
├── pages/              # File-based routing
├── components/jobs/    # JobForm (shared create/edit)
├── composables/        # useApi, useJobs
├── stores/             # Pinia auth store
├── middleware/         # auth.ts route guard
└── layouts/            # default, guest
```
