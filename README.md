<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Treść zadania

Pochwal się swoimi umiejętnościami!

Wykonując poniższe zadanie:

- użyj frameworka Laravel lub Symfony.
- nie masz limitu czasowego na wykonie zdania.
- ważna jest architektura wybranego rozwiązania.
- rozwiązanie zadania służy jedynie do celów rekrutacyjnych, nie zostanie wykorzystane w przyszłości.

## Zadanie

1. Zaimplementuj API dla prostego systemu do zapisywania kursu walut (EUR, USD, GBP).
2. Zadanie rekrutacyjne powinno zostać umieszczone na gitlab/github jako publiczny projekt.
3. Po ukończeniu zadania wyślij do nas wiadomość z linkiem do repozytorium.

## Założenia biznesowe

- Kurs walut zapisywany jest raz dziennie
- Odpytywanie endpoitów powinno być zabezpieczone autoryzacją i rolą dla API

### Wymagane endpointy

- (POST) Autoryzacja
- (POST) Dodanie kursu walut
- (GET) Lista kursów walut z danego dnia

  [
  {"currency":"EUR", "date":"2023-14-13","amount": 4.66},
  {"currency":"USD", "date":"2023-14-13","amount": 4.86},
  {"currency":"GBP", "date":"2023-14-13","amount": 6.66}
  ]

- (GET) Pobranie kursu dla wybranej waluty

# Dokumentacja

## Autoryzacja

- rejestracja:
    - /api/user/register
    - name (wymagane)
    - email (wymagane)
    - password (wymagane)
    - rola (uprawnienia | domyślnie 0)
        - 0 (GET)
        - 1 (POST)
- logowanie:
    - /api/user/login
- wylogowanie:
    - /api/user/logout

## Endpointy API

- lista kursów z danego dnia (GET):
    - /api/currency/{date}
- lista kursów dla wybranej waluty z danego dnia (GET):
    - /api/currency/{date}/{currency}
- dodawanie kursu waluty (POST):
    - /api/currency
        - przyjmuje tablicę:
        - [
          {
          "currency": "EUR",
          "amount": 6.78
          },
          {
          "currency": "GBP",
          "amount": 7.78
          }, {
          "currency": "USD",
          "amount": 0.78
          }
          ]

## Postman.

Plik w głównym katalogu projektu. Jego nazwa: KR_Group.postman_collection.json

## Repozytorium

[Marski-GIT](https://github.com/Marski-GIT/KR_G)

[Kontakt](kontakt@marski.pl)
