# 🤖 AI E-Commerce Platform

An AI-powered e-commerce platform built with Laravel, Bagisto, MySQL, and AI integration.

## 🚀 Features

- **Modern E-Commerce UI** - Tailwind CSS with gradient design and smooth animations
- **Product Management** - Full CRUD with categories, attributes, and inventory
- **Shopping Cart** - Persistent cart with quantity management
- **Wishlist** - Save products for later
- **Checkout** - One-page checkout flow
- **AI Product Recommendation** - Personalized recommendations based on user behavior
- **AI Shopping Assistant** - Natural language chatbot for product discovery
- **Smart Search** - Intent extraction from natural language queries
- **AI Analytics Dashboard** - Sales forecasts, product trends, and conversion insights
- **Customer Personalization** - Behavior-based product suggestions

## 🛠️ Tech Stack

- **Backend**: Laravel 12, Bagisto 2.4.x
- **Frontend**: Vue 3, Tailwind CSS, Vite
- **Database**: MySQL
- **AI**: Laravel AI SDK, MagicAI package
- **Caching**: Redis, File Cache
- **Search**: Database, ElasticSearch (configurable)

## 📦 Installation

### Prerequisites

- PHP 8.3+
- Composer
- Node.js 18+
- MySQL 8+
- Redis (optional)

### Setup

```bash
# Clone the repository
git clone https://github.com/yourusername/ai-ecommerce-platform.git
cd ai-ecommerce-platform

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Install Bagisto
php artisan bagisto:install

# Run migrations and seeders
php artisan migrate --seed

# Build frontend assets
cd packages/Webkul/Shop && npm install && npm run build

# Start development server
php artisan serve
```

### Access Points

- **Storefront**: http://127.0.0.1:8000
- **Admin Panel**: http://127.0.0.1:8000/admin
- **AI Chatbot**: Click the floating 🤖 button on any page

## 🏗️ Architecture

```
AI E-Commerce Platform
│
├── Storefront (Vue 3 + Tailwind CSS)
│   ├── Modern UI with gradient design
│   ├── Product Listing & Details
│   ├── Cart & Checkout
│   ├── AI Chatbot (floating button)
│   └── Smart Search
│
├── AI Layer (Laravel AI SDK)
│   ├── Recommendation Engine
│   ├── Chatbot Service
│   ├── Smart Search Service
│   └── Insight Service
│
├── Bagisto Core
│   ├── Product System
│   ├── Order System
│   ├── Customer System
│   └── Admin Dashboard
│
├── Database (MySQL)
│   ├── Bagisto tables
│   └── AI tables (product_views, search_history, user_interactions, recommendations)
│
└── AI Services
    ├── OpenAI / Anthropic / Gemini / etc.
    └── MagicAI configuration
```

## 🔌 API Endpoints

### AI Chat
`POST /api/ai/chat` - Send message to AI assistant

### Smart Search
`POST /api/ai/smart-search` - Natural language product search

### Recommendations
`GET /api/ai/recommendations` - Get personalized product recommendations

### Related Products
`GET /api/ai/related/{id}` - Get related products for a product

### Insights (Admin)
`GET /api/ai/insights` - Get AI-powered analytics

## 🔐 Security

- API keys stored in environment variables only
- CSRF protection on all forms
- Input validation on all endpoints
- Rate limiting on AI endpoints
- SQL injection prevention via Eloquent ORM
- XSS protection via Blade escaping
- Prompt injection prevention via system prompts

## 📊 Performance

- Database indexing on frequently queried columns
- Caching for recommendations and catalog summaries
- Queue support for background jobs
- Pagination on all list endpoints
- Lazy loading for images
- API response caching for catalog data

## 🧪 Testing

```bash
# Run Pest tests
composer test

# Run Playwright E2E tests
cd packages/Webkul/Admin && npm run test:e2e
```

## 🚀 Deployment

### Production Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up HTTPS
- [ ] Configure queue worker
- [ ] Set up cache driver (Redis recommended)
- [ ] Configure AI API keys in environment
- [ ] Run `php artisan optimize`
- [ ] Build production assets

### Environment Variables

```env
# AI Configuration
AI_API_KEY=your_openai_api_key
AI_MODEL=gpt-4o

# Application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=your_database
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password
```

## 📁 Project Structure

```
ai-ecommerce-platform/
├── bagisto/                    # Bagisto core
│   ├── app/
│   ├── packages/
│   │   ├── Webkul/             # Bagisto packages
│   │   └── AI/                 # Custom AI package
│   │       ├── src/
│   │       │   ├── Models/     # AI models
│   │       │   ├── Services/   # AI services
│   │       │   ├── Http/       # Controllers & routes
│   │       │   └── Resources/  # Views & lang
│   │       └── composer.json
│   ├── resources/
│   │   └── themes/             # Custom themes
│   │       └── ai-ecommerce/   # AI E-Commerce theme
│   │           ├── assets/     # CSS & JS
│   │           └── views/      # Blade templates
│   └── ...
├── README.md
├── composer.json
└── package.json
```

## 🎯 Portfolio Highlights

This project demonstrates:

1. **Full-stack e-commerce** with Laravel, Bagisto, Vue 3, and Tailwind CSS
2. **AI integration** using Laravel AI SDK with multiple providers
3. **Recommendation engine** with both rule-based and AI-powered approaches
4. **Natural language processing** for smart search and chatbot
5. **Data analytics** with sales forecasting and customer segmentation
6. **Modern UI/UX** with responsive design and smooth animations
7. **Security best practices** including API key protection and prompt injection prevention
8. **Performance optimization** with caching, indexing, and lazy loading

## 📞 Contact

For questions or support, please open an issue on GitHub.

---

**Built with ❤️ using Laravel and AI**
