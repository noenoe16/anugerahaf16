<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Cctv;
use App\Models\Room;
use App\Models\User;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Options as XlsxOptions;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function buildings(): StreamedResponse
    {
        $filename = 'buildings.xlsx';

        return $this->xlsxDownload($filename, ['id', 'name', 'code', 'latitude', 'longitude', 'address'], function (Writer $writer) {
            Building::chunk(1000, function ($rows) use ($writer) {
                foreach ($rows as $b) {
                    $writer->addRow(Row::fromValues([$b->id, $b->name, $b->code, $b->latitude, $b->longitude, $b->address]));
                }
            });
        });
    }

    public function rooms(): StreamedResponse
    {
        $filename = 'rooms.xlsx';

        return $this->xlsxDownload($filename, ['id', 'building_id', 'name', 'code', 'latitude', 'longitude'], function (Writer $writer) {
            Room::chunk(1000, function ($rows) use ($writer) {
                foreach ($rows as $r) {
                    $writer->addRow(Row::fromValues([$r->id, $r->building_id, $r->name, $r->code, $r->latitude, $r->longitude]));
                }
            });
        });
    }

    public function cctvs(): StreamedResponse
    {
        $filename = 'cctvs.xlsx';

        return $this->xlsxDownload($filename, ['id', 'building_id', 'room_id', 'name', 'ip_address', 'status', 'location_note'], function (Writer $writer) {
            Cctv::chunk(1000, function ($rows) use ($writer) {
                foreach ($rows as $c) {
                    $writer->addRow(Row::fromValues([$c->id, $c->building_id, $c->room_id, $c->name, $c->ip_address, $c->status, $c->location_note]));
                }
            });
        });
    }

    public function users(): StreamedResponse
    {
        $filename = 'users.xlsx';

        return $this->xlsxDownload($filename, ['id', 'name', 'email', 'role', 'last_seen_at'], function (Writer $writer) {
            User::chunk(1000, function ($rows) use ($writer) {
                foreach ($rows as $u) {
                    $writer->addRow(Row::fromValues([$u->id, $u->name, $u->email, $u->role, optional($u->last_seen_at)?->toDateTimeString()]));
                }
            });
        });
    }

    public function usersOnline(): StreamedResponse
    {
        $filename = 'users-online.xlsx';
        $threshold = now()->subMinutes(5);

        return $this->xlsxDownload($filename, ['id', 'name', 'email', 'role', 'last_seen_at'], function (Writer $writer) use ($threshold) {
            User::whereNotNull('last_seen_at')
                ->where('last_seen_at', '>=', $threshold)
                ->chunk(1000, function ($rows) use ($writer) {
                    foreach ($rows as $u) {
                        $writer->addRow(Row::fromValues([$u->id, $u->name, $u->email, $u->role, optional($u->last_seen_at)?->toDateTimeString()]));
                    }
                });
        });
    }

    public function usersOffline(): StreamedResponse
    {
        $filename = 'users-offline.xlsx';
        $threshold = now()->subMinutes(5);

        return $this->xlsxDownload($filename, ['id', 'name', 'email', 'role', 'last_seen_at'], function (Writer $writer) use ($threshold) {
            User::where(function ($q) use ($threshold) {
                $q->whereNull('last_seen_at')
                    ->orWhere('last_seen_at', '<', $threshold);
            })->chunk(1000, function ($rows) use ($writer) {
                foreach ($rows as $u) {
                    $writer->addRow(Row::fromValues([$u->id, $u->name, $u->email, $u->role, optional($u->last_seen_at)?->toDateTimeString()]));
                }
            });
        });
    }

    private function xlsxDownload(string $filename, array $headers, \Closure $writeRows): StreamedResponse
    {
        return response()->stream(function () use ($headers, $writeRows) {
            $options = new XlsxOptions;
            $writer = new Writer($options);
            $writer->openToFile('php://output');
            $writer->addRow(Row::fromValues($headers));
            $writeRows($writer);
            $writer->close();
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
        ]);
    }
}
