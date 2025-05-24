<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Config\ContentSecurityPolicy;

class CspFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Nothing to do before controller
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $cspConfig = new ContentSecurityPolicy();

        $directives = [];

        // Helper function to format sources
        $formatSources = function ($sources) {
            if (is_null($sources)) return '';
            if (is_string($sources)) return $sources === 'self' ? "'self'" : $sources;
            if (is_array($sources)) {
                return implode(' ', array_map(function($src) {
                    return $src === 'self' ? "'self'" : $src;
                }, $sources));
            }
            return '';
        };

        if ($cspConfig->defaultSrc) {
            $directives[] = "default-src " . $formatSources($cspConfig->defaultSrc);
        }
        if ($cspConfig->scriptSrc) {
            $directives[] = "script-src " . $formatSources($cspConfig->scriptSrc);
        }
        if ($cspConfig->styleSrc) {
            $directives[] = "style-src " . $formatSources($cspConfig->styleSrc);
        }
        if ($cspConfig->imageSrc) {
            $directives[] = "img-src " . $formatSources($cspConfig->imageSrc);
        }
        if ($cspConfig->connectSrc) {
            $directives[] = "connect-src " . $formatSources($cspConfig->connectSrc);
        }
        if ($cspConfig->fontSrc) {
            $directives[] = "font-src " . $formatSources($cspConfig->fontSrc);
        }
        if ($cspConfig->objectSrc) {
            $directives[] = "object-src " . $formatSources($cspConfig->objectSrc);
        }
        if ($cspConfig->mediaSrc) {
            $directives[] = "media-src " . $formatSources($cspConfig->mediaSrc);
        }
        if ($cspConfig->frameSrc) {
            $directives[] = "frame-src " . $formatSources($cspConfig->frameSrc);
        }
        if ($cspConfig->frameAncestors) {
            $directives[] = "frame-ancestors " . $formatSources($cspConfig->frameAncestors);
        }
        if ($cspConfig->formAction) {
            $directives[] = "form-action " . $formatSources($cspConfig->formAction);
        }
        if ($cspConfig->childSrc) {
            $directives[] = "child-src " . $formatSources($cspConfig->childSrc);
        }
        if ($cspConfig->manifestSrc) {
            $directives[] = "manifest-src " . $formatSources($cspConfig->manifestSrc);
        }
        if ($cspConfig->pluginTypes) {
            $directives[] = "plugin-types " . $formatSources($cspConfig->pluginTypes);
        }
        if ($cspConfig->sandbox) {
            $directives[] = "sandbox " . $formatSources($cspConfig->sandbox);
        }

        // Construct the full policy
        $policy = implode('; ', array_filter($directives));

        if ($cspConfig->upgradeInsecureRequests) {
            $policy .= '; upgrade-insecure-requests';
        }

        if ($cspConfig->reportURI) {
            $policy .= '; report-uri ' . $cspConfig->reportURI;
        }

        // Choose header name based on reportOnly mode
        $headerName = $cspConfig->reportOnly ? 'Content-Security-Policy-Report-Only' : 'Content-Security-Policy';

        // Set the header
        $response->setHeader($headerName, $policy);
    }
}
