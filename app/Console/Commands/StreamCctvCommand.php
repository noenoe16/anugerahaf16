<?php

namespace App\Console\Commands;

use App\Models\Cctv;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StreamCctvCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cctv:stream';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start FFmpeg processes to stream all RTSP CCTV to HLS in public/live';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $liveDir = public_path('live');
        if (! is_dir($liveDir)) {
            File::makeDirectory($liveDir, 0755, true);
        }

        $this->info('Starting streams...');
        $cctvs = Cctv::all();
        foreach ($cctvs as $cctv) {
            $ip = $cctv->ip_address;
            if (empty($ip)) {
                continue;
            }

            $host = parse_url($ip, PHP_URL_HOST) ?? $ip;
            $safe = Str::of($host)->replace(['.', ':', '@'], '_');
            $output = public_path('live/'.$safe.'.m3u8');

            $cmd = "ffmpeg -rtsp_transport tcp -i \"{$ip}\" -c:v libx264 -preset ultrafast -tune zerolatency -f hls -hls_time 1 -hls_list_size 3 -hls_flags delete_segments \"{$output}\" > NUL 2>&1 &";

            if (PHP_OS_FAMILY === 'Windows') {
                pclose(popen('start /B '.$cmd, 'r'));
            } else {
                exec($cmd.' > /dev/null 2>&1 &');
            }

            $this->line("Started: {$ip} -> {$output}");
        }

        $this->info('All streams started.');

        return self::SUCCESS;
    }
}
