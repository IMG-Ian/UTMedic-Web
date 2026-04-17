<?php
$directory = new RecursiveDirectoryIterator('c:/xampp/htdocs/utmedic2.0/template/dist/frontend/');
$iterator = new RecursiveIteratorIterator($directory);
$regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

$subdirsToFix = ['user', 'medico', 'psicologo', 'nutricionista', 'shared', 'auth', 'admin'];

foreach ($regex as $file) {
    echo "Processing: " . $file[0] . "\n";
    $filePath = $file[0];
    
    // Check if file is inside one of the subdirectories (1 level deep from frontend)
    $relativePath = str_replace('c:/xampp/htdocs/utmedic2.0/template/dist/frontend/', '', str_replace('\\', '/', $filePath));
    $parts = explode('/', ltrim($relativePath, '/'));
    if (count($parts) > 1 && in_array($parts[0], $subdirsToFix)) {
        
        $content = file_get_contents($filePath);
        
        // Fix require_once '../backend to require_once '../../backend
        // Using negative lookbehind to avoid changing already correct '../../backend'
        $newContent = preg_replace("/(?<!\.\.\/)'\.\.\/backend/", "'../../backend", $content);
        
        // Also fix API_BASE if it was pointing to '../backend' (though it shouldn't be here)
        
        if ($newContent !== $content) {
            file_put_contents($filePath, $newContent);
            echo "- Fixed paths in $relativePath\n";
        }
    }
}
echo "Done.\n";
?>
