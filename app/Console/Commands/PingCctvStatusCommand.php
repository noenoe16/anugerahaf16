<?php

namespace App\Console\Commands;

use App\Models\Cctv;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class PingCctvStatusCommand extends Command
{
    protected $signature = 'cctv:ping-status';

    protected $description = 'Update CCTV statuses based on recent HLS segment activity';

    public function handle(): int
    {
        $thresholdSeconds = 10; // if playlist updated within 10s, consider online

        $cctvs = Cctv::all();
        $now = now();
        $countOnline = 0;
        $countOffline = 0;

        foreach ($cctvs as $cctv) {
            $ip = $cctv->ip_address;
            if (! $ip) {
                continue;
            }
            $host = parse_url($ip, PHP_URL_HOST) ?? $ip;
            $safe = Str::of($host)->replace(['.', ':', '@'], '_');
            $playlist = public_path('live/'.$safe.'.m3u8');

            $status = 'offline';
            if (is_file($playlist)) {
                $mtime = filemtime($playlist);
                if ($mtime !== false && ($now->getTimestamp() - $mtime) <= $thresholdSeconds) {
                    $status = 'online';
                }
            }

            if ($cctv->status !== $status) {
                $cctv->status = $status;
                $cctv->save();
            }

            $status === 'online' ? $countOnline++ : $countOffline++;
        }

        $this->info("CCTV status updated. Online: {$countOnline}, Offline: {$countOffline}");

        return self::SUCCESS;
    }
}
