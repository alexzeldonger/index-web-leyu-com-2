<?php

/**
 * Site metadata container with description generation.
 */
class SiteMeta
{
    private array $meta = [];

    /**
     * Create a new SiteMeta instance.
     *
     * @param array $data Initial metadata.
     */
    public function __construct(array $data = [])
    {
        $this->meta = $data;
    }

    /**
     * Set a metadata value.
     *
     * @param string $key   The key.
     * @param mixed  $value The value.
     */
    public function set(string $key, $value): void
    {
        $this->meta[$key] = $value;
    }

    /**
     * Get a metadata value.
     *
     * @param string $key     The key.
     * @param mixed  $default Default value.
     *
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        return $this->meta[$key] ?? $default;
    }

    /**
     * Generate a short descriptive text from the metadata.
     *
     * @return string
     */
    public function generateDescription(): string
    {
        $title = $this->get('title', 'Untitled');
        $tagline = $this->get('tagline', '');
        $keywords = $this->get('keywords', []);
        $url = $this->get('url', '');

        $desc = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        if (!empty($tagline)) {
            $desc .= ' – ' . htmlspecialchars($tagline, ENT_QUOTES, 'UTF-8');
        }

        if (!empty($keywords) && is_array($keywords)) {
            $kwStr = implode(', ', array_map(function ($kw) {
                return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
            }, $keywords));
            $desc .= ' [Keywords: ' . $kwStr . ']';
        }

        if (!empty($url)) {
            $desc .= ' | ' . htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
        }

        return $desc;
    }

    /**
     * Return all metadata as an associative array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->meta;
    }
}

// -------------------------------------------------------------------------
// Example usage with sample site metadata.
// -------------------------------------------------------------------------

$sampleData = [
    'title'    => 'Leyu Index',
    'tagline'  => 'Explore the web with leyu',
    'keywords' => ['leyu', 'web', 'index', 'directory'],
    'url'      => 'https://index-web-leyu.com',
];

$site = new SiteMeta($sampleData);

// Optionally add extra info.
$site->set('author', 'Leyu Team');

echo $site->generateDescription() . "\n";