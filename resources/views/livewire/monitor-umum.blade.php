<div class="container" wire:poll.1s>
      <div class="queue-board">
        <div class="queue-card blue-theme">
          <h2 class="card-title">ANTRIAN UMUM</h2>
          <div class="current-queue">
            <span class="queue-label">Nomor Panggilan Saat Ini:</span>
            <span class="queue-number"> {{ $current->no_antrian ?? '-' }}</span>
          </div>
          <div class="remaining-queue">Sisa Antrian: <span>{{ $sisa }}</span> Pasien</div>

          <table class="queue-table">
            <thead>
              <tr>
                <th>No. Urut</th>
                <th>Nama</th>
                <th>Waktu</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
                    @forelse ($antrianUmum as $antrian)
                        <tr>
                            <td>{{ $antrian->no_antrian }}</td>
                            <td class="name-highlight">{{ $antrian->patient->nama_pasien ?? '-' }}</td>
                            <td>{{ $antrian->created_at->format('H:i') }}</td>
                            <td class="{{ $antrian->status == 'dipanggil' ? 'status-served' : '' }}">
                                {{ strtoupper($antrian->status) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada antrian Gilut hari ini</td>
                        </tr>
                    @endforelse
                </tbody>
          </table>
        </div>
      </div>
    </div>