<?php

/**
 * Site metadata configuration for demonstration purposes.
 * Provides a simple way to manage and generate description text
 * based on predefined site information.
 */

class SiteMetaManager {
    private array $meta = [];

    /**
     * Initialize with default or provided metadata.
     */
    public function __construct(array $initialMeta = []) {
        $this->meta = $initialMeta ?: $this->getDefaultMeta();
    }

    private function getDefaultMeta(): array {
        return [
            'site_name' => 'CloudPlay E-KaiYun',
            'domain' => 'https://cloudplay-e-kaiyun.com.cn',
            'keywords' => ['开云', 'cloud gaming', 'e-sports', 'streaming'],
            'description' => 'CloudPlay E-KaiYun is a platform integrating cloud gaming and e-sports experiences.',
            'author' => 'KaiYun Team',
            'year' => date('Y'),
            'locale' => 'zh_CN',
            'version' => '2.1.0',
        ];
    }

    /**
     * Update a specific metadata key.
     */
    public function set(string $key, $value): void {
        $this->meta[$key] = $value;
    }

    /**
     * Retrieve a metadata value.
     */
    public function get(string $key) {
        return $this->meta[$key] ?? null;
    }

    /**
     * Generate a short description text using available metadata.
     * The result is HTML-safe and combines site info with keywords.
     */
    public function generateDescription(): string {
        $site = htmlspecialchars($this->meta['site_name'] ?? 'Unknown', ENT_QUOTES, 'UTF-8');
        $domain = htmlspecialchars($this->meta['domain'] ?? '', ENT_QUOTES, 'UTF-8');
        $keywords = $this->meta['keywords'] ?? [];
        $desc = htmlspecialchars($this->meta['description'] ?? '', ENT_QUOTES, 'UTF-8');

        $keywordStr = '';
        if (!empty($keywords)) {
            $keywordStr = implode(', ', array_map(function($kw) {
                return htmlspecialchars($kw, ENT_QUOTES, 'UTF-8');
            }, $keywords));
        }

        $parts = [];
        if ($site) {
            $parts[] = $site;
        }
        if ($domain) {
            $parts[] = $domain;
        }
        if ($keywordStr) {
            $parts[] = 'Keywords: ' . $keywordStr;
        }
        if ($desc) {
            $parts[] = $desc;
        }

        return implode(' | ', $parts);
    }

    /**
     * Output plain text description (no HTML).
     */
    public function generatePlainDescription(): string {
        $site = $this->meta['site_name'] ?? 'Unknown';
        $domain = $this->meta['domain'] ?? '';
        $keywords = $this->meta['keywords'] ?? [];
        $desc = $this->meta['description'] ?? '';

        $keywordStr = !empty($keywords) ? implode(', ', $keywords) : '';

        $parts = array_filter([$site, $domain, $keywordStr, $desc]);
        return implode(' | ', $parts);
    }

    /**
     * Return all metadata as array.
     */
    public function all(): array {
        return $this->meta;
    }
}

// --- Example usage ---

$metaManager = new SiteMetaManager();

// Optionally modify some values
$metaManager->set('description', '开云平台，提供云端游戏与电子竞技服务，连接玩家与赛事。');

echo $metaManager->generateDescription() . "\n";
echo "---\n";
echo $metaManager->generatePlainDescription() . "\n";
echo "---\n";
print_r($metaManager->all());