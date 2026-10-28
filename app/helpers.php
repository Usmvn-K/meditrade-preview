<?php

if (!function_exists('mediaUrl')) {
    /**
     * Resolve any media path to a browser-safe URL.
     * Uses root-relative paths ('/uploads/...') so it works seamlessly
     * on localhost, live servers, HTTP, and HTTPS without Mixed-Content
     * or APP_URL domain mismatch errors.
     *
     * @param string|null $path
     * @param string $fallback
     * @return string
     */
    function mediaUrl(?string $path, string $fallback = ''): string
    {
        if (empty($path)) {
            return $fallback;
        }

        // External URL — return unchanged
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Clean any leading slash for consistent checks
        $cleanPath = ltrim($path, '/');

        // If path begins with "uploads/"
        if (str_starts_with($cleanPath, 'uploads/')) {
            return '/' . $cleanPath;
        }

        // If path begins with "storage/"
        if (str_starts_with($cleanPath, 'storage/')) {
            $subPath = substr($cleanPath, 8);
            return '/uploads/' . $subPath;
        }

        // If path begins with "images/"
        if (str_starts_with($cleanPath, 'images/')) {
            return '/' . $cleanPath;
        }

        // Relative path like "services/xyz.png", "settings/logo.png", "categories/abc.jpg"
        return '/uploads/' . $cleanPath;
    }
}
