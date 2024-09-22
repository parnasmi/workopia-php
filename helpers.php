<?php

/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */

function basePath(string $path = '') {
    return __DIR__ . '/' . $path;
}


/**
 * Load view
 * @param string $name
 */

function loadView(string $name, array $data = []) {
    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View {$name} not found";
    }
}

/**
 * Load Partial
 * @param string $name
 */

function loadPartial(string $name, $data = []) {
    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        extract($data);
        require $partialPath;
    } else {
        echo "Partial {$name} not found";
    }
}


/**
 * Inspect values (like js console.log)
 * @param mixed $value
 * @return void;
 */

function inspect(mixed $value) {

    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

/**
 * Inspect values and kill script (like js console.log)
 * @param mixed $value
 * @return void;
 */

function inspectAndDie(mixed $value) {

    echo '<pre>';
    die(var_dump($value));
    echo '</pre>';
}


function formatSalary(string $salary): string {
    return '$' . number_format(floatval($salary));
}

/**
 * sanitize
 *
 * @param string $dirty
 * @return string
 */
function sanitize(string $dirty): string {
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * redirect
 *
 * @param string $url
 * @return void
 */
function redirect(string $url): void {
    header("Location: {$url}");
}
