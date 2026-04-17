<?php
$directory = new RecursiveDirectoryIterator('c:/xampp/htdocs/utmedic2.0/template/dist/frontend/');
$iterator = new RecursiveIteratorIterator($directory);
$regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$subdirsToFix = ['user', 'medico', 'psicologo', 'nutricionista', 'shared', 'auth', 'admin'];

foreach ($regex as $file) {
    $filePath = $file[0];
    $relativePath = str_replace('c:/xampp/htdocs/utmedic2.0/template/dist/frontend/', '', str_replace('\\', '/', $filePath));
    $parts = explode('/', ltrim($relativePath, '/'));
    if (count($parts) > 1 && in_array($parts[0], $subdirsToFix)) {
        
        $content = file_get_contents($filePath);
        
        // This regex finds require/fetch related to backend paths safely
        // It patches __DIR__ . '/../backend' -> __DIR__ . '/../../backend'
        $newContent = preg_replace("/'\/\.\.\/backend/", "'/../../backend", $content);
        $newContent = preg_replace("/\"\/\.\.\/backend/", "\"/../../backend", $newContent);
        
        // Let's also patch any missed '../backend' without a leading slash
        $newContent = preg_replace("/(?<!\.\.\/)'\.\.\/backend/", "'../../backend", $newContent);
        $newContent = preg_replace("/(?<!\.\.\/)\"\.\.\/backend/", "\"../../backend", $newContent);

        if ($newContent !== $content) {
            file_put_contents($filePath, $newContent);
            echo "Fixed: $relativePath\n";
        }
    }
}
echo "Done Phase 2.\n";
?>
