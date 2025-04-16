# 💰 Laravel - Gestor de Comptes Corrents

Aquest projecte és una aplicació Laravel que permet gestionar **comptes corrents** amb funcionalitats com:

- ✅ Creació de comptes amb saldo inicial zero
- ➕ Ingressos amb validacions de límits i precisió decimal
- ➖ Retirades amb control de saldo, límits i decimals
- 🔁 Transferències entre comptes amb límit diari i validacions

---

## 🚀 Funcionalitats detallades

### ✅ Creació de compte
- Sempre comença amb saldo 0.

### ➕ Ingressos
- No es poden ingressar valors negatius ni amb més de 2 decimals.
- L'import màxim d'ingrés és de **6000.00**.

### ➖ Retirades
- No es pot retirar més del saldo disponible.
- No es poden retirar quantitats negatives ni amb més de 2 decimals.
- L'import màxim de retirada és de **6000.00**.

### 🔁 Transferències
- No es poden transferir quantitats negatives.
- El límit total de transferències per dia des d’un compte és de **3000.00**.

---

## ⚙️ Stack Tecnològic

- Laravel 10
- PHPUnit (tests unitaris i funcionals)
- SQLite (base de dades per defecte a testing)
- GitHub Actions (CI)

---

## 🧪 Executar Tests

Per executar els tests localment:

```bash
php artisan test
