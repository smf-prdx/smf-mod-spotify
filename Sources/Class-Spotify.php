<?php

/**
 * Class-Spotify.php
 *
 * @package prdx:spotify
 * @link https://cientoseis.es
 * @author prdx (https://www.simplemachines.org/community/index.php?action=profile;u=674744)
 * @copyright 2025, prdx
 * @license https://opensource.org/licenses/BSD-3-Clause BSD
 *
 */

if (!defined('SMF'))
    die('No direct access...');

final class Spotify
{
    public function hooks(): void
    {
        add_integration_function('integrate_bbc_codes', __CLASS__ . '::bbcCodes#', false, __FILE__);
        add_integration_function('integrate_bbc_buttons', __CLASS__ . '::bbcButtons#', false, __FILE__);
    }

    public function bbcCodes(array &$codes): void
    {
        global $txt;

        loadLanguage('Spotify/');

        $codes[] = [
            'tag' => 'spotify',
            'type' => 'unparsed_content',
            'block_level' => true,
            'validate' => function (&$tag, $data) {
                global $txt;

                if (strpos($data, 'open.spotify.com') !== false || strpos($data, 'spotify.link') !== false) {
                    $tag['content'] = self::getSpotifyEmbed($data);
                } else {
                    $tag['content'] = '<div class="errorbox">' . $txt['spotify_link_error'] . '</div>';
                }
            }
        ];
    }

    public function bbcButtons(array &$buttons): void
    {
        global $txt;

        loadLanguage('Spotify/');

        $buttons[count($buttons) - 1][] = [
            'image'       => 'spotify',
            'code'        => 'spotify',
            'before'      => '[spotify]',
            'after'       => '[/spotify]',
            'description' => $txt['spotify_bbc'],
        ];
    }

    public static function getSpotifyEmbed(string $url): ?string
    {
        global $txt;

        loadLanguage('Spotify/');

        $maxRetries = 5; // Maximum number of retries
        $retryDelay = 200000; // Delay in microseconds (200ms)
        $timeout = 5; // Timeout in seconds
        $ttl = 86400; // Cache TTL in seconds (1 day)

        // Sanitize URL to use as cache key
        $cache_key = 'spotify_' . md5($url);

        // Try to get from cache first
        $cached = cache_get_data($cache_key, $ttl);
        if (!empty($cached)) {
            return $cached;
        }

        // Define the API endpoint for Spotify's oEmbed service
        $apiUrl = 'https://open.spotify.com/oembed?url=' . urlencode($url);

        // Try to fetch the API response, retrying once if it fails
        $response = false;
        for ($i = 0; $i < $maxRetries; $i++) {
            $response = @file_get_contents($apiUrl, false, stream_context_create([
                'http' => [
                    'timeout' => $timeout,
                    'header' => "Accept: application/json+oembed\r\n"
                ]
            ]));
            if ($response !== false) {
                break;
            }
            usleep($retryDelay);
        }

        if ($response) {
            $json = json_decode($response, true);

            if (!empty($json['html'])) {
                cache_put_data($cache_key, $json['html'], 86400);
                return $json['html'];
            }
        }
        return '<div class="errorbox">'. $txt['spotify_cant_load_url'] .'</div>';;
    }
}
