# Cipher Challenge

Cipher Challenge är en interaktiv webbplats där användare löser olika typer av chiffer och kryptografiska utmaningar för att samla poäng och klättra på leaderboarden.

Projektet är byggt med HTML, CSS, JavaScript och PHP, med en databas för att lagra användare, poäng och leaderboard-data.

## Funktioner

- Slumpmässigt genererade enkla förskjutningschiffer
- Mellansvåra chiffer med slumpmässigt genererade nycklar
- Dolda ledtrådar och nycklar i exempelvis:
  - URL:er
  - Inspect Element
  - Sidans kod
- Poängsystem baserat på svårighetsgrad
- Global leaderboard
- Dynamiska utmaningar för hög replayability


## Teknologier

- HTML
- CSS
- JavaScript
- PHP
- MySQL

---

## Installation

### 1. Klona projektet

```bash
git clone https://github.com/bobi8877/slutprojekt
```

### 2. Placera projektet i din webbserver

Exempel med XAMPP:

```bash
htdocs/cipher-challenge
```

### 3. Importera databasen

1. Öppna phpMyAdmin
2. Skapa en ny databas
3. Importera den medföljande `cipher.sql`-filen

---

## Konfiguration

Uppdatera databasanslutningen i PHP-filen:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "cipher_challenge";
```

---

## Hur man spelar

1. Registrera eller logga in
2. Välj en svårighetsgrad
3. Lös chiffret
4. Hitta gömda nycklar och ledtrådar
5. Samla poäng och klättra på leaderboarden

---

## Chiffertyper

### Enkel nivå
- Caesar/Förskjutningschiffer

### Mellansvår nivå
- Nyckelbaserade chiffer
- Dolda nycklar och ledtrådar

### Svår nivå
- Handskapade problem
- Kräver kreativitet och kunskap

---

## Leaderboard

Spelare får poäng beroende på hur svår utmaningen är. Leaderboarden uppdateras automatiskt för att visa ranking och totalpoäng.

---

## Framtida förbättringar

- Fler typer av chiffer
- Tidsbaserade utmaningar
- Achievement-system
- Multiplayer/events
- Responsiv mobilversion
- Förbättrad säkerhet
---