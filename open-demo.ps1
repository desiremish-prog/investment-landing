# Скрипт для открытия демо версии лендинга

Write-Host "🚀 Запуск демо-версии лендинга..." -ForegroundColor Green
Write-Host ""

# Получаем путь к файлу
$htmlPath = Join-Path $PSScriptRoot "index.html"

# Проверяем существование файла
if (Test-Path $htmlPath) {
    Write-Host "✓ Файл найден: $htmlPath" -ForegroundColor Green
    Write-Host ""
    Write-Host "📝 Информация о проекте:" -ForegroundColor Cyan
    Write-Host "   - Статическая HTML версия"
    Write-Host "   - Для полной функциональности используйте WordPress версию"
    Write-Host "   - Форма в HTML версии сохраняет данные в localStorage"
    Write-Host ""
    Write-Host "🌐 Открываю в браузере..." -ForegroundColor Yellow
    
    # Открываем в браузере по умолчанию
    Start-Process $htmlPath
    
    Write-Host ""
    Write-Host "✅ Готово! Лендинг открыт в браузере." -ForegroundColor Green
    Write-Host ""
    Write-Host "📚 Для установки WordPress версии см. INSTALL.md" -ForegroundColor Cyan
    Write-Host "📖 Полная документация в README.md" -ForegroundColor Cyan
} else {
    Write-Host "❌ Ошибка: Файл index.html не найден!" -ForegroundColor Red
    Write-Host "   Путь: $htmlPath" -ForegroundColor Red
}

Write-Host ""
Write-Host "Нажмите любую клавишу для выхода..."
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
