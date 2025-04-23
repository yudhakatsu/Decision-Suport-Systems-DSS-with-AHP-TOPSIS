@extends('layouts.app')

@section('title', 'Dashboard Vendor')

@section('content')
<style>
    .ranking {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .chart-ranking {
        background-color: #fff;
        width: 900px;
        padding: 15px;
        border: 1px solid #000; 
    }

    .table-ranking {
        width: 350px;
        height: 600px;
    }

    table {
        width: 100%;
    }

    table, th, tr, td {
        border: 1px solid #000;
        padding: 10px
    }
</style>

<div class="container mt-4">
    <h2 class="mb-4">Dashboard Vendor</h2>
    <div class="ranking">
        <div class="chart-ranking">
            <div class="row">
                <div class="col-md-8 mx-auto d-flex justify-content-center">
                    <div id="piechart" style="min-width: 800px; height: 500px;padding-left: 100px;"></div>
                </div>
            </div>

            <div class="text-center mt-1">
                <button class="btn btn-success" id="viewRank">Lihat Peringkat Anda</button>
            </div>
        </div>
        <div class="table-ranking">
            <table>
                <thead>
                    <tr>
                        <th>Nama Vendor</th>
                        <th style="text-align: center;">Peringkat</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->username }}</td>
                        <td style="text-align: center;">{{ $vendor->kategori }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    
    
</div>

<!-- Bootstrap Modal -->
<div class="modal fade" id="rankModal" tabindex="-1" aria-labelledby="rankModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rankModalLabel">Peringkat Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="rankText"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    // Ambil data dari Laravel
    let vendors = @json($vendors);
    let labels = vendors.map(v => v.username);
    let percentages = vendors.map(v => v.nilai_akhir);

    // Render Chart.js
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Kategori', 'Jumlah Vendor'],
            ['A',  {{ $jumlahKategori['A'] }}],
            ['B',  {{ $jumlahKategori['B'] }}],
            ['C',  {{ $jumlahKategori['C'] }}]
        ]);

        var options = {
            title: 'Distribusi Peringkat Vendor',
            pieSliceText: 'label',
            legend: { position: 'right' },
            colors: ['#28a745', '#ffc107', '#dc3545']
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }

    // Event klik tombol "Lihat Peringkat Anda"
    document.getElementById('viewRank').addEventListener('click', function () {
        let myVendor = @json(session('vendor')?->username ?? '');
        let index = vendors.findIndex(v => v.username === myVendor);

        if (index !== -1) {
            let nilai = vendors[index].percentage;
            let kategori = '';

            if (nilai >= 85) {
                kategori = 'A';
            } else if (nilai >= 70) {
                kategori = 'B';
            } else {
                kategori = 'C';
            }

            let message = `${myVendor} ada di peringkat ${kategori} dengan nilai akhir ${percentages[index]}`;
            document.getElementById('rankText').innerText = message;
        } else {
            document.getElementById('rankText').innerText = 'Vendor tidak ditemukan.';
        }

        let rankModal = new bootstrap.Modal(document.getElementById('rankModal'));
        rankModal.show();
    });
</script>
@endsection
