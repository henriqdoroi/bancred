<?php
/**
 * Página dinâmica de pagamento PIX
 * 
 * Esta página carrega os dados do PIX via API baseado no transactionId
 * Substitui as páginas estáticas como 33580228.html
 */

// Obter transactionId da URL
$transactionId = isset($_GET['id']) ? trim($_GET['id']) : '';

if (empty($transactionId)) {
    // Se não tiver ID, redirecionar para checkout
    header('Location: ../../checkout.html');
    exit;
}

// Carregar template HTML
$html = file_get_contents(__DIR__ . '/template.html');

// Substituir placeholders
$html = str_replace('{{TRANSACTION_ID}}', htmlspecialchars($transactionId), $html);

echo $html;



