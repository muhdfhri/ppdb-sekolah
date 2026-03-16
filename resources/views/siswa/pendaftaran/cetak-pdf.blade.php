<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
            color: #1e293b;
            background: white;
            padding: 0;
        }

        /* ── Header ────────────────────────────────────── */
        .header {
            background-color: #018B3E;
            color: white;
            padding: 20px 28px;
            position: relative;
            overflow: hidden;
        }

        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .school-name {
            font-size: 15pt;
            font-weight: 900;
            letter-spacing: -0.3px;
        }

        .school-sub {
            font-size: 8pt;
            opacity: 0.75;
            margin-top: 2px;
        }

        .nomor-badge {
            font-size: 18pt;
            font-weight: 900;
            letter-spacing: 1px;
            margin-top: 10px;
            color: #F6CB04;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 8pt;
            font-weight: 700;
            text-align: center;
        }

        .tgl-daftar {
            font-size: 8pt;
            opacity: 0.6;
            margin-top: 5px;
            text-align: right;
        }

        /* ── Banner diterima ───────────────────────────── */
        .banner-diterima {
            background-color: #F6CB04;
            color: #0f2318;
            padding: 10px 28px;
            font-size: 10pt;
            font-weight: 800;
        }

        /* ── Body ──────────────────────────────────────── */
        .body {
            padding: 20px 28px;
        }

        /* ── Section title ─────────────────────────────── */
        .section-title {
            font-size: 7.5pt;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #018B3E;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1.5px solid rgba(1, 139, 62, 0.2);
        }

        /* ── Data grid ─────────────────────────────────── */
        .data-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .data-grid td {
            padding: 6px 10px;
            font-size: 9.5pt;
            vertical-align: top;
        }

        .data-grid tr:nth-child(odd) td {
            background-color: #f8fafc;
        }

        .data-grid .lbl {
            color: #64748b;
            font-size: 8pt;
            font-weight: 600;
            width: 35%;
        }

        .data-grid .val {
            font-weight: 600;
            color: #0f172a;
        }

        /* ── Two column layout ─────────────────────────── */
        .two-col {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }

        .two-col>tbody>tr>td {
            vertical-align: top;
            width: 50%;
            padding-right: 12px;
        }

        .two-col>tbody>tr>td:last-child {
            padding-right: 0;
        }

        /* ── Jurusan box ───────────────────────────────── */
        .jurusan-box {
            background-color: rgba(1, 139, 62, 0.07);
            border: 1px solid rgba(1, 139, 62, 0.2);
            border-radius: 6px;
            padding: 10px 12px;
            margin-bottom: 6px;
        }

        .jurusan-label {
            font-size: 7.5pt;
            color: #018B3E;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        .jurusan-name {
            font-size: 11pt;
            font-weight: 900;
            color: #0f2318;
            margin-top: 2px;
        }

        .kode-badge {
            display: inline-block;
            background-color: #018B3E;
            color: white;
            font-size: 7.5pt;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 10px;
            margin-top: 4px;
        }

        /* ── Dokumen checklist ─────────────────────────── */
        .dok-grid {
            width: 100%;
            border-collapse: collapse;
        }

        .dok-grid td {
            padding: 4px 8px;
            font-size: 9pt;
            width: 33.33%;
        }

        .dok-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .dok-check {
            font-weight: 700;
            font-size: 10pt;
        }

        .dok-check.ok {
            color: #018B3E;
        }

        .dok-check.no {
            color: #94a3b8;
        }

        .dok-name {
            font-size: 8.5pt;
        }

        .dok-name.ok {
            color: #015f2a;
            font-weight: 600;
        }

        .dok-name.no {
            color: #94a3b8;
        }

        /* ── Divider ────────────────────────────────────── */
        .divider {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 14px 0;
        }

        /* ── Footer ─────────────────────────────────────── */
        .footer {
            border-top: 1.5px dashed #e2e8f0;
            margin: 16px 0 0;
            padding: 12px 0 0;
        }

        .footer-text {
            font-size: 7.5pt;
            color: #94a3b8;
            line-height: 1.6;
        }

        /* ── QR placeholder / stamp area ───────────────── */
        .stamp-area {
            float: right;
            text-align: center;
            width: 110px;
        }

        .stamp-box {
            border: 1.5px dashed #018B3E;
            width: 90px;
            height: 90px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            background-color: rgba(1, 139, 62, 0.04);
        }

        .stamp-lbl {
            font-size: 7pt;
            color: #018B3E;
            margin-top: 4px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    @php
        $siswa = $pendaftaran->siswa;
        $sekolah = $pendaftaran->sekolahAsal;
        $jurusan = $pendaftaran->jurusan;
        $jurusan2 = $pendaftaran->jurusanPilihan2;

        $statusMap = [
            'draft' => ['label' => 'Draft', 'bg' => '#e2e8f0', 'color' => '#475569'],
            'menunggu_pembayaran' => ['label' => 'Menunggu Pembayaran', 'bg' => '#fef3c7', 'color' => '#92400e'],
            'menunggu_verifikasi' => ['label' => 'Menunggu Verifikasi', 'bg' => '#fef9c3', 'color' => '#854d0e'],
            'terverifikasi' => ['label' => 'Terverifikasi', 'bg' => '#dcfce7', 'color' => '#166534'],
            'diterima' => ['label' => 'DITERIMA', 'bg' => '#F6CB04', 'color' => '#0f2318'],
            'cadangan' => ['label' => 'Cadangan', 'bg' => '#ede9fe', 'color' => '#5b21b6'],
            'ditolak' => ['label' => 'Tidak Diterima', 'bg' => '#fee2e2', 'color' => '#991b1b'],
        ];
        $sc = $statusMap[$pendaftaran->status] ?? $statusMap['draft'];
        $isDiterima = $pendaftaran->status === 'diterima';

        $dokumenList = [
            'ijazah' => 'Ijazah / SKL',
            'kartu_keluarga' => 'Kartu Keluarga',
            'akte_kelahiran' => 'Akta Kelahiran',
            'pas_foto' => 'Pas Foto',
            'bukti_pembayaran' => 'Bukti Pembayaran',
            'kip' => 'KIP / KPS / PKH',
        ];
        $uploadedMap = $pendaftaran->dokumen->keyBy('jenis_dokumen');
    @endphp

    {{-- ── HEADER ──────────────────────────────────────────── --}}
    <div class="header">
        <div class="header-inner">
            <div>
                <div class="school-name">SMK NU II Medan</div>
                <div class="school-sub">Bukti Pendaftaran PPDB
                    {{ $periodeInfo['tahun_ajaran'] ?? now()->year . '/' . (now()->year + 1) }}
                </div>
                <div class="nomor-badge">{{ $pendaftaran->nomor_pendaftaran }}</div>
            </div>
            <div style="text-align:right;">
                <div class="status-badge" style="background-color:{{ $sc['bg'] }}; color:{{ $sc['color'] }};">
                    {{ $sc['label'] }}
                </div>
                <div class="tgl-daftar">
                    Terdaftar: {{ $pendaftaran->tanggal_daftar->translatedFormat('d M Y') }}
                </div>
            </div>
        </div>
    </div>

    {{-- ── BANNER DITERIMA ─────────────────────────────────── --}}
    @if($isDiterima)
        <div class="banner-diterima">
            🎉 Selamat! Anda dinyatakan DITERIMA di SMK NU II Medan. Harap lakukan daftar ulang sesuai jadwal.
        </div>
    @endif

    {{-- ── BODY ────────────────────────────────────────────── --}}
    <div class="body">

        {{-- Stamp area --}}
        <div class="stamp-area">
            <div class="stamp-box">
                <div style="font-size:7.5pt; color:#018B3E; text-align:center; line-height:1.4;">
                    Tanda Tangan<br>& Cap<br>Panitia
                </div>
            </div>
            <div class="stamp-lbl">Tanda Tangan Resmi</div>
        </div>

        {{-- ── DATA PRIBADI ────────────────────────────────── --}}
        <div class="section-title">Data Pribadi Pendaftar</div>
        <table class="data-grid">
            <tr>
                <td class="lbl">Nama Lengkap</td>
                <td class="val">{{ $siswa?->nama_lengkap ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">NIK</td>
                <td class="val">{{ $siswa?->nik ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">Tempat, Tgl Lahir</td>
                <td class="val">{{ ($siswa?->tempat_lahir ?? '—') }},
                    {{ $siswa?->tanggal_lahir?->translatedFormat('d M Y') ?? '—' }}
                </td>
            </tr>
            <tr>
                <td class="lbl">Jenis Kelamin</td>
                <td class="val">{{ $siswa?->jenis_kelamin ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">Agama</td>
                <td class="val">{{ $siswa?->agama ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">No. Telepon</td>
                <td class="val">{{ $siswa?->no_telepon ?? '—' }}</td>
            </tr>
            <tr>
                <td class="lbl">Alamat Lengkap</td>
                <td class="val">{{ $siswa?->alamat_lengkap ?? '—' }}</td>
            </tr>
        </table>

        <hr class="divider">

        {{-- ── SEKOLAH & JURUSAN ───────────────────────────── --}}
        <table class="two-col">
            <tr>
                <td>
                    <div class="section-title">Sekolah Asal</div>
                    <table class="data-grid">
                        <tr>
                            <td class="lbl">Nama Sekolah</td>
                            <td class="val">{{ $sekolah?->nama_sekolah ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">NISN</td>
                            <td class="val">{{ $sekolah?->nisn ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Tahun Lulus</td>
                            <td class="val">{{ $sekolah?->tahun_lulus ?? '—' }}</td>
                        </tr>
                        <tr>
                            <td class="lbl">Nilai Rata-rata</td>
                            <td class="val">
                                {{ $sekolah?->nilai_rata_rata ? number_format($sekolah->nilai_rata_rata, 2) : '—' }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <div class="section-title">Pilihan Jurusan</div>
                    <div class="jurusan-box">
                        <div class="jurusan-label">Pilihan 1</div>
                        <div class="jurusan-name">{{ $jurusan?->nama_jurusan ?? '—' }}</div>
                        @if($jurusan?->kode_jurusan)
                            <span class="kode-badge">{{ $jurusan->kode_jurusan }}</span>
                        @endif
                    </div>
                    @if($jurusan2)
                        <table class="data-grid">
                            <tr>
                                <td class="lbl">Pilihan 2</td>
                                <td class="val">{{ $jurusan2->nama_jurusan }} <span
                                        style="font-size:7.5pt; color:#64748b;">({{ $jurusan2->kode_jurusan }})</span></td>
                            </tr>
                        </table>
                    @endif
                </td>
            </tr>
        </table>

        <hr class="divider">

        {{-- ── STATUS DOKUMEN ──────────────────────────────── --}}
        <div class="section-title">Status Kelengkapan Dokumen</div>
        <table class="dok-grid">
            @php $cols = array_chunk(array_keys($dokumenList), 3); @endphp
            @foreach(array_chunk(array_keys($dokumenList), 3) as $row)
                <tr>
                    @foreach($row as $key)
                        @php
                            $isOk = $uploadedMap->has($key);
                            $lbl = $dokumenList[$key];
                        @endphp
                        <td>
                            <div class="dok-item">
                                <span class="dok-check {{ $isOk ? 'ok' : 'no' }}">{{ $isOk ? '✓' : '○' }}</span>
                                <span class="dok-name {{ $isOk ? 'ok' : 'no' }}">{{ $lbl }}</span>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>

        {{-- ── FOOTER ──────────────────────────────────────── --}}
        <div class="footer">
            <div style="display:flex; justify-content:space-between; align-items:flex-end;">
                <div class="footer-text">
                    <strong style="color:#018B3E;">SMK Swasta Nahdatul Ulama II Medan</strong><br>
                    Jl. Gaperta Ujung No.2, Tj. Gusta, Kec. Medan Helvetia, Kota Medan, Sumatera Utara 20125<br>
                    Telp: 0812-6685-7686 &nbsp;|&nbsp; Email: smknu2medan22@gmail.com<br>
                    <br>
                    <em>Dokumen ini adalah bukti pendaftaran resmi yang sah. Harap simpan dan tunjukkan saat proses
                        verifikasi.</em><br>
                    Dicetak: {{ now()->translatedFormat('d F Y, H:i') }} WIB
                </div>
                <div style="text-align:right; font-size:7.5pt; color:#94a3b8;">
                    Halaman 1/1<br>
                    {{ $pendaftaran->nomor_pendaftaran }}
                </div>
            </div>
        </div>

    </div>
</body>

</html>