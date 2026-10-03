@isset($themeCssVariables)
<style id="theme-css-variables">@php
$emitThemeCssBlock = static function (string $selector, array $variables): string {
    $parts = [];
    foreach ($variables as $property => $hex) {
        $normalized = \App\Support\ThemeColors::normalizeHex((string) $hex);
        if ($normalized === null) {
            continue;
        }
        $parts[] = $property.':'.$normalized;
    }

    if ($parts === []) {
        return '';
    }

    return $selector.'{'.implode(';', $parts).'}';
};

echo $emitThemeCssBlock('html', $themeCssVariables['light'] ?? []);
echo $emitThemeCssBlock('html.dark', $themeCssVariables['dark'] ?? []);
@endphp</style>
@endisset
