# RusPay Core — open‑source self‑host payment gateway for Russian acquirers

> **Keywords**: open source платежный шлюз, unified API YooKassa Tinkoff Pay SberPay, self‑host Stripe аналог, Docker эквайринг, Laravel payment microservice, Omnipay bridge

**RusPay Core** — это бесплатный MIT‑проект, который объединяет YooKassa, Tinkoff Pay и SberPay под единым REST. Вы разворачиваете шлюз у себя на сервере (`docker‑compose up`) и подключаете интернет‑магазин или SaaS‑сервис так же просто, как Stripe, но без санкционных рисков.

![CI](https://github.com/zxkill/ruspay-core/actions/workflows/ci.yml/badge.svg)

---

## 📌 Почему это важно

* SaaS‑компаниям в РФ приходится одновременно работать с 3‑4 банками — каждый со своим SDK, подписями и статусами.
* Не существовало self‑host open‑source агрегатора «из коробки» для локальных эквайрингов.
* **RusPay Core** закрывает пробел: единый API + плагинная архитектура + GUI + тестовый стенд.

---

## ✨ Ключевые фичи (MVP v0.1)

| ✔︎ | Возможность                                                                |
| - |----------------------------------------------------------------------------|
| ✅ | `POST /payments` создаёт платёж и отдаёт `checkout_url` (YooKassa sandbox) |
| ✅ | Таблица **payments** в PostgreSQL (UUID PK, enum‑статус, JSON payload)     |
| ✅ | Docker‑стек: nginx + php‑fpm 8.4 + Postgres 15 — старт за 1 минуту         |
| ✅ | Health‑роут `/health/db` для мониторинга                                   |
| ✅ | GitHub Actions: composer > migrate > PHPUnit — «build ✔︎» badge            |
| ⚙️ | Плагин‑слой Omnipay → драйверы Tinkoff Pay / Sber Pay готовы к подключению |

---

## 🚀 Quick‑Start (< 10 мин)

```bash
# 1. клон и переменные
$ git clone https://github.com/zxkill/ruspay-core.git
$ cd ruspay-core
$ cp .env.example .env   # укажите YOO_SHOP_ID / YOO_SECRET

# 2. запускаем весь стек
$ docker compose up --build
```

Проверьте:

```bash
# здоровье БД
$ curl http://localhost:8080/health/db
{"db":"ok"}

# платёж 100 ₽
$ curl -X POST http://localhost:8080/api/v1/payments \
       -H "Content-Type: application/json" \
       -d '{"amount":100}'
{"payment_id":"…uuid…","checkout_url":"https://checkout.test.yookassa.ru/…"}
```

---

## ⚙️ Технологический стек

| Слой         | Технология                               |
| ------------ | ---------------------------------------- |
| Framework    | **Laravel 11** (REST / GraphQL)          |
| Payments SDK | Omnipay 3 + YooKassa driver              |
| Database     | PostgreSQL 15                            |
| Runtime      | php:8.4‑fpm (pdo, pgsql, opcache)        |
| Proxy        | nginx\:alpine                            |
| CI           | GitHub Actions (lint, PHPUnit, coverage) |

---

## 🗄️ База данных (схема v0.1)

* `payments` — id UUID, provider, amount, currency, status (pending | succeeded | failed | canceled), raw\_payload JSON.
* `refunds`, `api_tokens` — подготовлены миграции для спринта 2.

---

## 🧪 Тесты и качество кода

* **PHPUnit** — фейковый YooKassa‑клиент обеспечивает детерминированные тесты.
* Покрытие базовых сценариев (create + webhook) > 70 % — планируется к концу спринта 2.
* PSR‑12 + PHP‑CS‑Fixer — проверяется в CI.

---

## 🛣️ Roadmap

| Спринт | Цель                                                            |
| ------ |-----------------------------------------------------------------|
| 2      | провайдеры **Tinkoff Pay** + **SberPay**, веб‑хуки, единый enum |
| 3      | AdminJS GUI, token‑auth, manual refund                          |
| 4      | Demo checkout, Swagger / GraphQL, CI coverage ≥ 70 %            |

---

## 🤝 Как помочь

* Сделать Omnipay‑адаптер **QIWI** / **CloudPayments**.
* Улучшить Admin Dashboard: фильтры, экспорт CSV.
* Перевести документацию на английский / испанский.
* Написать интеграционные тесты edge‑cases (duplicate webhook, partial refund).

---

## ⚖️ Лицензия

MIT — используйте свободно в коммерческих и open‑source проектах.

> **RusPay Core** — единый self‑host шлюз для YooKassa, Tinkoff и Сбер.
> Разворачивается за 1 клик, расширяется драйверами, покрыт тестами и не зависит от зарубежных платёжных сервисов.
