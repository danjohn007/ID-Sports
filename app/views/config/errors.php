<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">🐞 Log de Errores</h2>
        <form method="POST" action="<?= BASE_URL ?>config/clearErrors" onsubmit="return confirm('¿Limpiar errores?')">
            <button type="submit" class="text-red-500 text-sm hover:underline">Limpiar todo</button>
        </form>
    </div>

    <div class="space-y-3">
        <?php if (empty($errors)): ?>
        <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">Sin errores registrados 🎉</div>
        <?php else: ?>
        <?php foreach ($errors as $err): ?>
        <div class="bg-white border border-red-100 rounded-2xl p-4">
            <div class="flex items-start justify-between gap-2">
                <p class="text-sm font-medium text-red-700"><?= htmlspecialchars($err['message'] ?? '') ?></p>
                <span class="text-xs text-gray-400 whitespace-nowrap"><?= date('d/m/Y H:i', strtotime($err['created_at'])) ?></span>
            </div>
            <?php if (!empty($err['file'])): ?>
            <p class="text-xs text-gray-500 mt-1 font-mono"><?= htmlspecialchars($err['file']) ?><?= !empty($err['line']) ? ':' . $err['line'] : '' ?></p>
            <?php endif; ?>
            <?php if (!empty($err['trace'])): ?>
            <details class="mt-2">
                <summary class="text-xs text-gray-400 cursor-pointer hover:text-gray-600">Ver stack trace</summary>
                <pre class="text-xs text-gray-500 mt-2 bg-gray-50 rounded-lg p-3 overflow-x-auto whitespace-pre-wrap"><?= htmlspecialchars($err['trace']) ?></pre>
            </details>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
