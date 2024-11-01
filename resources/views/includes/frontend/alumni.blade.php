<section id="bagian-job">
    <h2>Alumni</h2>
    <div class="alumni-list">
        @foreach ($alumni as $item)
            <div class='alumni-item'>
                <img src="{{ asset('http://127.0.0.1:10/' . $item['foto']) }}" alt="gambar alumni" style="width: 248px; height: 160px;">
                <h3 style="margin-top: 40px">{{ $item['nama_alumni'] }}</h3>
                <p>{{ $item['nim'] }}</p>
            </div>
        @endforeach
    </div>
</section>
