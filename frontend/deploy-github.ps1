# ========================================
# Script de Déploiement GitHub
# ========================================
# Ce script automatise la préparation et le push sur GitHub

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Déploiement GitHub - Sondage Bénin" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Vérifier si Git est installé
Write-Host "Vérification de Git..." -ForegroundColor Yellow
try {
    $gitVersion = git --version
    Write-Host "✓ Git installé : $gitVersion" -ForegroundColor Green
} catch {
    Write-Host "✗ Git n'est pas installé !" -ForegroundColor Red
    Write-Host "Téléchargez Git : https://git-scm.com/download/win" -ForegroundColor Yellow
    exit 1
}

Write-Host ""

# Vérifier si on est dans le bon dossier
if (-not (Test-Path "package.json")) {
    Write-Host "✗ Erreur : Ce script doit être exécuté depuis le dossier frontend/" -ForegroundColor Red
    exit 1
}

Write-Host "✓ Dossier correct détecté" -ForegroundColor Green
Write-Host ""

# Demander l'URL du repository GitHub
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Configuration GitHub" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Avez-vous déjà créé un repository sur GitHub ?" -ForegroundColor Yellow
Write-Host "Si non, allez sur : https://github.com/new" -ForegroundColor Yellow
Write-Host ""
$repoUrl = Read-Host "Entrez l'URL de votre repository GitHub (ex: https://github.com/username/sondage-benin.git)"

if ([string]::IsNullOrWhiteSpace($repoUrl)) {
    Write-Host "✗ URL invalide !" -ForegroundColor Red
    exit 1
}

Write-Host ""

# Initialiser Git si nécessaire
if (-not (Test-Path ".git")) {
    Write-Host "Initialisation de Git..." -ForegroundColor Yellow
    git init
    Write-Host "✓ Git initialisé" -ForegroundColor Green
} else {
    Write-Host "✓ Git déjà initialisé" -ForegroundColor Green
}

Write-Host ""

# Vérifier si .env existe
if (-not (Test-Path ".env")) {
    Write-Host "⚠ Attention : Le fichier .env n'existe pas !" -ForegroundColor Yellow
    Write-Host "Créez-le avec votre URL backend InfinityFree :" -ForegroundColor Yellow
    Write-Host "VITE_API_URL=https://votre-site.infinityfreeapp.com/backend" -ForegroundColor Cyan
    Write-Host ""
    $createEnv = Read-Host "Voulez-vous créer .env maintenant ? (o/n)"
    
    if ($createEnv -eq "o" -or $createEnv -eq "O") {
        $apiUrl = Read-Host "Entrez votre URL backend InfinityFree"
        "VITE_API_URL=$apiUrl" | Out-File -FilePath ".env" -Encoding UTF8
        Write-Host "✓ Fichier .env créé" -ForegroundColor Green
    }
}

Write-Host ""

# Ajouter tous les fichiers
Write-Host "Ajout des fichiers..." -ForegroundColor Yellow
git add .
Write-Host "✓ Fichiers ajoutés" -ForegroundColor Green

Write-Host ""

# Créer le commit
Write-Host "Création du commit..." -ForegroundColor Yellow
$commitMessage = Read-Host "Message de commit (appuyez sur Entrée pour le message par défaut)"
if ([string]::IsNullOrWhiteSpace($commitMessage)) {
    $commitMessage = "Initial commit - Ready for Vercel deployment"
}

git commit -m "$commitMessage"
Write-Host "✓ Commit créé" -ForegroundColor Green

Write-Host ""

# Ajouter le remote
Write-Host "Configuration du remote GitHub..." -ForegroundColor Yellow
try {
    git remote add origin $repoUrl 2>$null
    Write-Host "✓ Remote ajouté" -ForegroundColor Green
} catch {
    Write-Host "⚠ Remote déjà existant, mise à jour..." -ForegroundColor Yellow
    git remote set-url origin $repoUrl
    Write-Host "✓ Remote mis à jour" -ForegroundColor Green
}

Write-Host ""

# Renommer la branche en main
Write-Host "Configuration de la branche..." -ForegroundColor Yellow
git branch -M main
Write-Host "✓ Branche renommée en 'main'" -ForegroundColor Green

Write-Host ""

# Push sur GitHub
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Push sur GitHub" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Prêt à pousser sur GitHub..." -ForegroundColor Yellow
Write-Host "Si demandé, entrez vos identifiants GitHub" -ForegroundColor Yellow
Write-Host "⚠ Utilisez un Personal Access Token comme mot de passe" -ForegroundColor Yellow
Write-Host "Créez-en un sur : https://github.com/settings/tokens" -ForegroundColor Cyan
Write-Host ""
Read-Host "Appuyez sur Entrée pour continuer"

git push -u origin main

if ($LASTEXITCODE -eq 0) {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "✓ SUCCÈS !" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    Write-Host ""
    Write-Host "Votre code est maintenant sur GitHub !" -ForegroundColor Green
    Write-Host ""
    Write-Host "Prochaines étapes :" -ForegroundColor Cyan
    Write-Host "1. Allez sur https://vercel.com" -ForegroundColor White
    Write-Host "2. Cliquez sur 'Add New Project'" -ForegroundColor White
    Write-Host "3. Importez votre repository GitHub" -ForegroundColor White
    Write-Host "4. Configurez :" -ForegroundColor White
    Write-Host "   - Root Directory: frontend" -ForegroundColor Yellow
    Write-Host "   - Framework: Vite" -ForegroundColor Yellow
    Write-Host "   - Variable d'environnement: VITE_API_URL" -ForegroundColor Yellow
    Write-Host "5. Cliquez 'Deploy' !" -ForegroundColor White
    Write-Host ""
} else {
    Write-Host ""
    Write-Host "✗ Erreur lors du push" -ForegroundColor Red
    Write-Host "Vérifiez vos identifiants GitHub" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Appuyez sur une touche pour fermer..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
