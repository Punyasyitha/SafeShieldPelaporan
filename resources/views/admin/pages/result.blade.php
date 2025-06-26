
<div class="container">
    <h2>Data Status Pengaduan</h2>

    {{-- Tampilkan pesan error jika ada --}}
    @if (isset($data['error']))
        <div class="alert alert-danger">
            <strong>{{ $data['error'] }}</strong><br>
            {!! nl2br(e($data['message'] ?? '')) !!}
        </div>
    @else
        {{-- Tampilkan data jika ada --}}
        @if (!empty($data) && is_array($data))
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Kategori</th>
                        <th>Nama Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $row)
                        <tr>
                            <td>{{ $row['IDKATEGORI'] ?? '-' }}</td>
                            <td>{{ $row['NAMA_KATEGORI'] ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Tidak ada data ditemukan.</p>
        @endif
    @endif
</div>

