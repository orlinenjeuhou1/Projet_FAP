# Pipeline CI/CD Complet - Travel Paradise

## 🎯 Pipeline avancé avec tous les tests


### ✅ **Tests unitaires et d'intégration**
- **PHPUnit** pour les endpoints API Symfony
- **Jest** pour les composants React Native
- **Tests des services et contrôleurs**

### ✅ **Tests de performance**
- **K6** pour les tests de charge
- **Validation des seuils de performance**
- **Tests de montée en charge**

### ✅ **Tests fonctionnels**
- **Behat** pour les endpoints API
- **Validation des réponses JSON**
- **Tests d'authentification**

### ✅ **Tests E2E**
- **Cypress** pour l'interface d'administration
- **Tests de navigation**
- **Tests de formulaires**

### ✅ **Tests d'intégration**
- **Flux utilisateurs complets**
- **Frontend vers backend**
- **Tests de base de données**

### ✅ **Revue de code**
- **PHP_CodeSniffer** pour les standards PSR12
- **PHPStan** pour l'analyse statique
- **ESLint** pour le code JavaScript
- **Prettier** pour le formatage

### ✅ **Intégration continue**
- **GitHub Actions** automatisé
- **Tests à chaque push**
- **Déploiement automatique**

## 📁 Structure des fichiers créés

```
.github/workflows/ci-cd-complete.yml    # Pipeline principal
k6-tests/load-test.js                   # Tests de performance
admin_web/behat.yml                     # Configuration Behat
admin_web/features/api.feature          # Tests fonctionnels API
admin_web/features/FeatureContext.php   # Contexte Behat
travelparadise_guide - essai/src/__tests__/App.test.js  # Tests Jest
cypress/e2e/admin.cy.js                 # Tests E2E Cypress
```

## 🚀 Workflow du pipeline

### **1. Tests unitaires PHP (PHPUnit)**
```yaml
- Installation des dépendances
- Configuration base de données de test
- Exécution des migrations
- Tests PHPUnit avec couverture
- Upload des métriques de couverture
```

### **2. Tests fonctionnels (Behat)**
```yaml
- Installation de Behat
- Tests des endpoints API
- Validation des réponses JSON
- Tests d'authentification
```

### **3. Tests de performance (K6)**
```yaml
- Tests de montée en charge (20 utilisateurs)
- Validation des seuils de performance
- Tests des endpoints critiques
```

### **4. Tests React Native (Jest)**
```yaml
- Tests des composants
- Tests de navigation
- Tests d'intégration API
- Couverture de code
```

### **5. Tests E2E (Cypress)**
```yaml
- Tests de l'interface d'administration
- Tests de navigation
- Tests de formulaires
```

### **6. Qualité du code**
```yaml
- PHP_CodeSniffer (PSR12)
- PHPStan (analyse statique)
- ESLint (JavaScript)
- Prettier (formatage)
```

### **7. Build et déploiement**
```yaml
- Construction des images Docker
- Tests des images
- Déploiement staging/production
```

## ⚙️ Configuration requise

### **Variables d'environnement GitHub**
```bash
# Pour les déploiements
STAGING_SSH_KEY=your_private_key
STAGING_USER=your_user
STAGING_HOST=your_staging_server
PRODUCTION_SSH_KEY=your_private_key
PRODUCTION_USER=your_user
PRODUCTION_HOST=your_production_server
```

### **Dépendances à installer**
```bash
# Backend Symfony
composer require --dev phpunit/phpunit
composer require --dev behat/behat behat/mink
composer require --dev squizlabs/php_codesniffer
composer require --dev phpstan/phpstan

# Frontend React Native
npm install --save-dev jest @testing-library/react-native
npm install --save-dev eslint prettier
npm install --save-dev cypress

# Tests de performance
# K6 est installé automatiquement par GitHub Actions
```

## 🎯 Utilisation

### **Déclenchement automatique**
```bash
git add .
git commit -m "Nouvelle fonctionnalité avec tests"
git push origin main
```

### **Résultats attendus**
- ✅ Tous les tests unitaires passent
- ✅ Tests fonctionnels validés
- ✅ Performance dans les seuils
- ✅ Qualité du code conforme
- ✅ Déploiement automatique

## 📊 Métriques et rapports

### **Couverture de code**
- PHP : Affichée dans Codecov
- JavaScript : Affichée dans Codecov

### **Performance**
- Temps de réponse < 500ms (95%)
- Taux d'échec < 10%

### **Qualité**
- Standards PSR12 respectés
- Analyse statique sans erreurs
- Code formaté automatiquement

## 🔧 Personnalisation

### **Ajouter de nouveaux tests**
1. **Tests unitaires** : Ajoutez dans `admin_web/tests/`
2. **Tests fonctionnels** : Ajoutez dans `admin_web/features/`
3. **Tests React Native** : Ajoutez dans `src/__tests__/`
4. **Tests E2E** : Ajoutez dans `cypress/e2e/`

### **Modifier les seuils de performance**
```javascript
// Dans k6-tests/load-test.js
thresholds: {
  http_req_duration: ['p(95)<300'], // Plus strict
  http_req_failed: ['rate<0.05'],   // Moins d'échecs
}
```

## 🎉 Avantages de ce pipeline complet

- **Qualité garantie** : Tous les types de tests
- **Performance validée** : Tests de charge automatisés
- **Déploiement sécurisé** : Tests avant déploiement
- **Feedback rapide** : Résultats en quelques minutes
- **Standards respectés** : Code conforme aux bonnes pratiques

