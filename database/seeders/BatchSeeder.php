<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class BatchSeeder extends Seeder
{
    protected array $batches = [];

    protected array $posts = [];

    public function run(): void
    {
        $this->addBatch(
            name: 'Algoritma dan Struktur Data',
            price: 0,
            duration: 180,
            posts: [
                $this->post(title: 'Pengenalan Algoritma', description: '<p>Materi ini membahas pengertian algoritma, karakteristik, serta pentingnya dalam pengembangan perangkat lunak.</p>', min_score: 0),
                $this->post(title: 'Struktur Data Dasar', description: '<p>Membahas array, linked list, dan cara penggunaannya dalam berbagai kasus.</p>', min_score: 0),
                $this->post(title: 'Latihan Implementasi Array dan Linked List', description: '<p>Tugas ini meminta peserta mengimplementasikan array dan linked list untuk menyelesaikan permasalahan sederhana.</p>', min_score: 70),
                $this->post(title: 'Stack dan Queue', description: '<p>Menjelaskan konsep stack dan queue serta penerapannya dalam pemrograman.</p>', min_score: 0),
                $this->post(title: 'Penerapan Stack dan Queue', description: '<p>Latihan ini menantang peserta membuat program yang memanfaatkan stack dan queue untuk simulasi antrian.</p>', min_score: 75),
                $this->post(title: 'Pengenalan Rekursi', description: '<p>Materi ini menguraikan prinsip dasar rekursi dan contohnya pada perhitungan faktorial serta deret Fibonacci.</p>', min_score: 0),
                $this->post(title: 'Tugas Rekursi', description: '<p>Peserta diminta menyelesaikan beberapa masalah matematika sederhana dengan menggunakan rekursi.</p>', min_score: 70),
                $this->post(title: 'Sorting dan Searching', description: '<p>Menjelaskan berbagai algoritma pengurutan dan pencarian seperti bubble sort, quicksort, dan binary search.</p>', min_score: 0),
                $this->post(title: 'Tugas Pengurutan dan Pencarian', description: '<p>Tugas ini berisi soal pemrograman untuk menguji pemahaman algoritma sorting dan searching.</p>', min_score: 75)
            ]
        );

        $this->addBatch(
            name: 'Pengantar Basis Data',
            price: 0,
            duration: 150,
            posts: [
                $this->post(title: 'Konsep Dasar Basis Data', description: '<p>Materi ini memperkenalkan definisi, tujuan, dan manfaat penggunaan basis data.</p>', min_score: 0),
                $this->post(title: 'Model Data dan ERD', description: '<p>Membahas model data dan bagaimana membuat Entity Relationship Diagram (ERD) sebagai perancangan awal database.</p>', min_score: 0),
                $this->post(title: 'Latihan ERD', description: '<p>Peserta diminta membuat ERD berdasarkan studi kasus sistem akademik.</p>', min_score: 70),
                $this->post(title: 'Normalisasi', description: '<p>Penjelasan mengenai proses normalisasi untuk menghindari redudansi data dan meningkatkan efisiensi penyimpanan.</p>', min_score: 0),
                $this->post(title: 'Tugas Normalisasi', description: '<p>Peserta melakukan normalisasi hingga bentuk ketiga dari tabel yang disediakan.</p>', min_score: 75),
                $this->post(title: 'Dasar SQL: SELECT dan JOIN', description: '<p>Membahas perintah dasar SQL untuk pengambilan data dan penggabungan tabel.</p>', min_score: 0),
                $this->post(title: 'Latihan Query SQL', description: '<p>Tugas ini berisi soal query SELECT, WHERE, JOIN dan GROUP BY untuk kasus toko buku.</p>', min_score: 75),
                $this->post(title: 'Transaksi dan Integritas Data', description: '<p>Menjelaskan konsep ACID, transaksi, dan pentingnya menjaga integritas data dalam basis data relasional.</p>', min_score: 0)
            ]
        );

        $this->addBatch(
            name: 'Pemrograman Berorientasi Objek (OOP)',
            price: 0,
            duration: 180,
            posts: [
                $this->post(title: 'Konsep Dasar OOP', description: '<p>Menjelaskan paradigma OOP dan perbedaan dengan pemrograman prosedural.</p>', min_score: 0),
                $this->post(title: 'Class dan Object', description: '<p>Pembahasan tentang class, object, property, dan method dalam OOP.</p>', min_score: 0),
                $this->post(title: 'Latihan Membuat Class', description: '<p>Peserta diminta membuat class dan object sederhana dari studi kasus sistem toko.</p>', min_score: 70),
                $this->post(title: 'Encapsulation dan Constructor', description: '<p>Materi ini membahas encapsulation untuk melindungi data dan penggunaan constructor dalam inisialisasi object.</p>', min_score: 0),
                $this->post(title: 'Tugas Enkapsulasi dan Constructor', description: '<p>Latihan membuat class dengan akses modifier dan constructor.</p>', min_score: 75),
                $this->post(title: 'Inheritance', description: '<p>Menjelaskan pewarisan antar class dan penggunaannya dalam kode reusable.</p>', min_score: 0),
                $this->post(title: 'Polymorphism dan Overriding', description: '<p>Membahas kemampuan objek untuk berperilaku berbeda dalam konteks berbeda.</p>', min_score: 0),
                $this->post(title: 'Tugas Inheritance dan Polymorphism', description: '<p>Peserta membuat class turunan dan mengimplementasikan metode override.</p>', min_score: 80),
                $this->post(title: 'Abstraction dan Interface', description: '<p>Penjelasan konsep abstract class dan interface dalam desain sistem OOP.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: Sistem Perpustakaan', description: '<p>Peserta membangun sistem OOP untuk pengelolaan buku dan peminjaman.</p>', min_score: 80)
            ]
        );

        $this->addBatch(
            name: 'Pemrograman Web Dasar',
            price: 0,
            duration: 150,
            posts: [
                $this->post(title: 'HTML: Struktur Dasar Halaman Web', description: '<p>Membahas struktur dasar HTML dan elemen penting seperti heading, paragraph, dan list.</p>', min_score: 0),
                $this->post(title: 'CSS: Styling Halaman', description: '<p>Menjelaskan cara menggunakan CSS untuk memperindah halaman web, baik inline maupun eksternal.</p>', min_score: 0),
                $this->post(title: 'Tugas Styling dengan CSS', description: '<p>Peserta membuat halaman profil dengan gaya CSS yang telah dipelajari.</p>', min_score: 70),
                $this->post(title: 'Layout dengan Flexbox dan Grid', description: '<p>Penjelasan tentang teknik tata letak modern menggunakan Flexbox dan Grid.</p>', min_score: 0),
                $this->post(title: 'Formulir dan Validasi Dasar', description: '<p>Membahas elemen form HTML dan validasi menggunakan atribut bawaan.</p>', min_score: 0),
                $this->post(title: 'Dasar JavaScript untuk Interaktivitas', description: '<p>Pengenalan JavaScript untuk manipulasi DOM dan event handling.</p>', min_score: 0),
                $this->post(title: 'Tugas Interaktivitas Web', description: '<p>Latihan membuat form interaktif dengan validasi menggunakan JavaScript.</p>', min_score: 75),
                $this->post(title: 'Proyek Mini: Landing Page Produk', description: '<p>Peserta diminta membangun landing page sederhana untuk produk fiktif.</p>', min_score: 80)
            ]
        );

        $this->addBatch(
            name: 'Basis Data Lanjutan',
            price: 100_000,
            duration: 180,
            posts: [
                $this->post(title: 'Relasi dan Foreign Key', description: '<p>Membahas konsep relasi antar tabel dan penggunaan foreign key untuk menjaga integritas referensial.</p>', min_score: 0),
                $this->post(title: 'View dan Stored Procedure', description: '<p>Penjelasan tentang view untuk abstraksi data dan stored procedure untuk logika bisnis di tingkat database.</p>', min_score: 0),
                $this->post(title: 'Latihan Stored Procedure', description: '<p>Tugas membuat prosedur untuk menghitung total transaksi dan insert otomatis.</p>', min_score: 75),
                $this->post(title: 'Indexing dan Optimisasi Query', description: '<p>Materi ini membahas strategi indexing dan teknik optimasi query untuk performa yang lebih baik.</p>', min_score: 0),
                $this->post(title: 'Tugas Indexing dan Query Optimization', description: '<p>Peserta diminta mengidentifikasi dan mempercepat query lambat menggunakan index.</p>', min_score: 80),
                $this->post(title: 'Database NoSQL dan Perbandingan', description: '<p>Pengantar ke MongoDB dan perbandingannya dengan basis data relasional.</p>', min_score: 0),
                $this->post(title: 'Replikasi dan Backup Database', description: '<p>Mengenal teknik replikasi dan strategi backup data untuk ketersediaan tinggi.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: Sistem Pemesanan Online', description: '<p>Peserta membangun database terstruktur dan stored procedure untuk sistem pemesanan restoran.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Jaringan Komputer',
            price: 120_000,
            duration: 200,
            posts: [
                $this->post(title: 'Dasar-Dasar Jaringan', description: '<p>Pengenalan jaringan komputer, perangkat dasar, dan konsep client-server.</p>', min_score: 0),
                $this->post(title: 'Model OSI dan TCP/IP', description: '<p>Penjelasan 7 lapisan model OSI dan bagaimana TCP/IP bekerja dalam dunia nyata.</p>', min_score: 0),
                $this->post(title: 'Pengalamatan IP dan Subnetting', description: '<p>Materi ini membahas IPv4, penghitungan subnet, dan pengalokasian IP address.</p>', min_score: 0),
                $this->post(title: 'Tugas Subnetting', description: '<p>Peserta diminta menyelesaikan kasus subnetting untuk jaringan skala kecil-menengah.</p>', min_score: 75),
                $this->post(title: 'Routing dan Switching', description: '<p>Menjelaskan mekanisme routing dan peran switch dalam LAN.</p>', min_score: 0),
                $this->post(title: 'Keamanan Jaringan', description: '<p>Pengenalan firewall, VPN, dan metode enkripsi dasar untuk keamanan jaringan.</p>', min_score: 0),
                $this->post(title: 'Simulasi Topologi dengan Cisco Packet Tracer', description: '<p>Tugas membuat topologi jaringan dan pengujian konektivitas antar host.</p>', min_score: 80),
                $this->post(title: 'Proyek: Desain Jaringan Kantor', description: '<p>Peserta merancang dan mengkonfigurasi topologi jaringan untuk kantor kecil menggunakan simulasi.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Sistem Operasi',
            price: 100_000,
            duration: 180,
            posts: [
                $this->post(title: 'Pengenalan Sistem Operasi', description: '<p>Menjelaskan fungsi utama sistem operasi sebagai pengelola sumber daya dan antarmuka pengguna.</p>', min_score: 0),
                $this->post(title: 'Manajemen Proses dan Thread', description: '<p>Membahas konsep proses, multithreading, dan penjadwalan CPU.</p>', min_score: 0),
                $this->post(title: 'Latihan Penjadwalan Proses', description: '<p>Tugas menghitung waktu rata-rata turnaround dan waiting time dari skenario proses.</p>', min_score: 70),
                $this->post(title: 'Manajemen Memori', description: '<p>Pembahasan paging, segmentation, dan alokasi memori dinamis.</p>', min_score: 0),
                $this->post(title: 'Tugas Memori Virtual', description: '<p>Peserta menyelesaikan soal simulasi manajemen memori dengan paging dan page replacement.</p>', min_score: 80),
                $this->post(title: 'Sistem File dan I/O', description: '<p>Materi sistem file, struktur direktori, dan manajemen I/O.</p>', min_score: 0),
                $this->post(title: 'Penggunaan Shell dan Perintah Linux', description: '<p>Latihan menggunakan perintah dasar Linux untuk navigasi dan manajemen file.</p>', min_score: 75),
                $this->post(title: 'Proyek Mini: Simulasi Penjadwalan', description: '<p>Peserta membuat program simulasi penjadwalan CPU menggunakan bahasa pemrograman tertentu.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Keamanan Siber',
            price: 150_000,
            duration: 200,
            posts: [
                $this->post(title: 'Ancaman dan Kerentanan Umum', description: '<p>Menjelaskan jenis-jenis ancaman cyber seperti malware, phishing, dan ransomware.</p>', min_score: 0),
                $this->post(title: 'Enkripsi dan Kriptografi Dasar', description: '<p>Membahas konsep enkripsi simetris dan asimetris, serta contoh penggunaannya.</p>', min_score: 0),
                $this->post(title: 'Tugas Implementasi Enkripsi', description: '<p>Peserta mengimplementasikan algoritma enkripsi Caesar dan RSA sederhana.</p>', min_score: 80),
                $this->post(title: 'Firewall dan IDS', description: '<p>Materi tentang peran firewall dan intrusion detection system dalam sistem pertahanan jaringan.</p>', min_score: 0),
                $this->post(title: 'Autentikasi dan Manajemen Akses', description: '<p>Menjelaskan konsep login, token, dan autentikasi dua faktor.</p>', min_score: 0),
                $this->post(title: 'Tugas Analisis Log Keamanan', description: '<p>Peserta menganalisis log sistem untuk mendeteksi aktivitas mencurigakan.</p>', min_score: 80),
                $this->post(title: 'Pengujian Keamanan Aplikasi (OWASP)', description: '<p>Menjelaskan 10 celah keamanan utama OWASP dan cara menghindarinya.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: Audit Keamanan Web', description: '<p>Peserta melakukan audit sederhana terhadap aplikasi web menggunakan tools open-source.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Pengantar Kecerdasan Buatan',
            price: 150_000,
            duration: 210,
            posts: [
                $this->post(title: 'Definisi dan Aplikasi AI', description: '<p>Pengenalan kecerdasan buatan dan penerapannya di berbagai bidang seperti kesehatan dan transportasi.</p>', min_score: 0),
                $this->post(title: 'Search Algorithm: DFS & BFS', description: '<p>Penjelasan algoritma pencarian dasar dalam pemecahan masalah.</p>', min_score: 0),
                $this->post(title: 'Tugas DFS & BFS', description: '<p>Implementasi DFS dan BFS dalam penyelesaian maze atau graf.</p>', min_score: 80),
                $this->post(title: 'Representasi Pengetahuan dan Inferensi', description: '<p>Materi tentang logika proposisional dan inference rule sederhana.</p>', min_score: 0),
                $this->post(title: 'Tugas Inferensi Logika', description: '<p>Peserta memformulasikan fakta dan aturan, lalu menyimpulkan informasi baru.</p>', min_score: 75),
                $this->post(title: 'Perkenalan Machine Learning', description: '<p>Gambaran supervised vs unsupervised learning, regresi linier, dan klasifikasi.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: Prediksi Harga Rumah', description: '<p>Peserta menerapkan regresi linier untuk memprediksi harga rumah berdasarkan dataset sederhana.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Pemrograman Mobile dengan Flutter',
            price: 200_000,
            duration: 240,
            posts: [
                $this->post(title: 'Pengenalan Flutter dan Dart', description: '<p>Dasar framework Flutter, struktur proyek, dan bahasa Dart.</p>', min_score: 0),
                $this->post(title: 'Widget Dasar dan Navigasi', description: '<p>Penggunaan widget dasar dan navigasi antar halaman di Flutter.</p>', min_score: 0),
                $this->post(title: 'Tugas UI Aplikasi Profil', description: '<p>Peserta membangun halaman profil statis menggunakan Flutter.</p>', min_score: 80),
                $this->post(title: 'State Management (setState, Provider)', description: '<p>Menjelaskan pengelolaan data antar komponen menggunakan state management.</p>', min_score: 0),
                $this->post(title: 'Koneksi API dan JSON Parsing', description: '<p>Materi ini membahas fetch data dari API dan parsing JSON ke dalam UI.</p>', min_score: 0),
                $this->post(title: 'Tugas Konsumsi API', description: '<p>Peserta membuat aplikasi katalog produk yang mengambil data dari API.</p>', min_score: 85),
                $this->post(title: 'Authentication dan Routing Dinamis', description: '<p>Pengenalan fitur login dan register serta routing berdasarkan autentikasi pengguna.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: Aplikasi Catatan Harian', description: '<p>Membangun aplikasi catatan harian dengan login dan penyimpanan lokal menggunakan Flutter.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Keamanan Informasi Dasar',
            price: 0,
            duration: 180,
            posts: [
                $this->post(title: 'Ancaman Umum dalam Dunia Digital', description: '<p>Virus, malware, phishing, dan serangan DoS/DDoS.</p>', min_score: 0),
                $this->post(title: 'Kriptografi Dasar', description: '<p>Pengenalan enkripsi simetris dan asimetris serta algoritma umum.</p>', min_score: 0),
                $this->post(title: 'Tugas Implementasi Enkripsi Sederhana', description: '<p>Peserta mengimplementasikan Caesar Cipher dan Vigenère Cipher.</p>', min_score: 80),
                $this->post(title: 'Konsep Authentication dan Authorization', description: '<p>Perbedaan autentikasi dan otorisasi serta penggunaannya dalam sistem.</p>', min_score: 0),
                $this->post(title: 'Keamanan Jaringan: Firewall dan VPN', description: '<p>Prinsip kerja firewall dan penggunaan VPN untuk koneksi aman.</p>', min_score: 0),
                $this->post(title: 'Tugas Konfigurasi Firewall Sederhana', description: '<p>Peserta mengatur aturan lalu lintas jaringan menggunakan iptables atau UFW.</p>', min_score: 80),
                $this->post(title: 'Pengamanan Web Application', description: '<p>Vulnerability umum seperti SQL Injection, XSS, dan CSRF.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: Audit Keamanan Sistem Sederhana', description: '<p>Peserta melakukan audit pada aplikasi web lokal menggunakan OWASP ZAP.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Pengembangan API dan Otentikasi',
            price: 125_000,
            duration: 200,
            posts: [
                $this->post(title: 'Pengenalan RESTful API', description: '<p>Penjelasan prinsip REST, endpoint, dan metode HTTP.</p>', min_score: 0),
                $this->post(title: 'Tugas Membuat API CRUD Produk', description: '<p>Peserta membangun API produk dengan metode GET, POST, PUT, DELETE.</p>', min_score: 85),
                $this->post(title: 'Validasi dan Error Handling', description: '<p>Menjelaskan pentingnya validasi input dan penanganan error yang baik.</p>', min_score: 0),
                $this->post(title: 'Otentikasi Menggunakan Token JWT', description: '<p>Materi membahas struktur JWT, implementasi login, dan proteksi endpoint.</p>', min_score: 0),
                $this->post(title: 'Tugas Implementasi JWT', description: '<p>Peserta membuat sistem login dengan validasi token JWT pada endpoint tertentu.</p>', min_score: 85),
                $this->post(title: 'Rate Limiting dan API Key', description: '<p>Strategi pengamanan API dengan pembatasan akses dan penggunaan API Key.</p>', min_score: 0),
                $this->post(title: 'Dokumentasi API dengan Swagger', description: '<p>Menjelaskan cara membuat dokumentasi interaktif untuk API menggunakan Swagger atau Postman.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: API Aplikasi Todo List dengan Login', description: '<p>Peserta membangun API lengkap termasuk fitur autentikasi, otorisasi, dan dokumentasi.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Desain UI/UX untuk Aplikasi Digital',
            price: 100_000,
            duration: 160,
            posts: [
                $this->post(title: 'Prinsip Desain UI dan UX', description: '<p>Perbedaan UI dan UX serta prinsip-prinsip desain seperti konsistensi dan hierarki visual.</p>', min_score: 0),
                $this->post(title: 'Wireframe dan Prototyping', description: '<p>Penggunaan tools seperti Figma untuk membuat sketsa dan prototipe aplikasi.</p>', min_score: 0),
                $this->post(title: 'Tugas Membuat Wireframe Aplikasi Kasir', description: '<p>Peserta membuat wireframe aplikasi kasir sederhana dengan Figma atau alat lain.</p>', min_score: 80),
                $this->post(title: 'User Flow dan Information Architecture', description: '<p>Menentukan jalur navigasi dan struktur informasi dalam aplikasi.</p>', min_score: 0),
                $this->post(title: 'Tugas Desain User Flow', description: '<p>Peserta menyusun user flow untuk aplikasi pemesanan makanan.</p>', min_score: 80),
                $this->post(title: 'Accessibility dan Inclusive Design', description: '<p>Desain yang mempertimbangkan pengguna dengan kebutuhan khusus.</p>', min_score: 0),
                $this->post(title: 'Design System dan Komponen UI', description: '<p>Pentingnya design system dan pembuatan komponen reusable.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: Desain Aplikasi Booking Hotel', description: '<p>Peserta mendesain UI dan UX aplikasi pemesanan hotel end-to-end.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'Pemrograman Paralel dan Multithreading',
            price: 150_000,
            duration: 200,
            posts: [
                $this->post(title: 'Konsep Paralelisme dan Konkurensi', description: '<p>Perbedaan antara eksekusi paralel dan konkuren dalam pemrograman.</p>', min_score: 0),
                $this->post(title: 'Thread dan Process', description: '<p>Pengenalan thread, proses, dan bagaimana sistem operasi mengelolanya.</p>', min_score: 0),
                $this->post(title: 'Tugas Implementasi Thread', description: '<p>Peserta membuat program multithread sederhana untuk menghitung angka secara paralel.</p>', min_score: 80),
                $this->post(title: 'Race Condition dan Deadlock', description: '<p>Menjelaskan masalah yang muncul akibat thread yang tidak disinkronkan.</p>', min_score: 0),
                $this->post(title: 'Sinkronisasi dan Mutex', description: '<p>Teknik untuk mencegah race condition menggunakan kunci (mutex/semaphore).</p>', min_score: 0),
                $this->post(title: 'Tugas Simulasi Deadlock dan Solusi', description: '<p>Peserta membuat simulasi deadlock dan memperbaikinya.</p>', min_score: 85),
                $this->post(title: 'Parallel Computing dan Task Pool', description: '<p>Pembagian beban kerja dan penggunaan thread pool dalam sistem besar.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: Multithreaded File Downloader', description: '<p>Peserta membuat aplikasi downloader file yang berjalan paralel.</p>', min_score: 85)
            ]
        );

        $this->addBatch(
            name: 'DevOps dan CI/CD Dasar',
            price: 175_000,
            duration: 220,
            posts: [
                $this->post(title: 'Pengenalan DevOps', description: '<p>Konsep DevOps, tujuan, dan praktik kolaborasi antara tim pengembang dan operasi.</p>', min_score: 0),
                $this->post(title: 'Continuous Integration (CI)', description: '<p>Pengenalan CI dan cara mengintegrasikan kode secara otomatis setiap saat ada perubahan.</p>', min_score: 0),
                $this->post(title: 'Tugas Setup GitHub Actions untuk CI', description: '<p>Peserta menyiapkan GitHub Actions untuk menjalankan tes otomatis setiap commit.</p>', min_score: 85),
                $this->post(title: 'Continuous Deployment (CD)', description: '<p>Konsep otomatisasi *deploy* aplikasi ke *server* produksi atau staging.</p>', min_score: 0),
                $this->post(title: 'Docker dan Containerization', description: '<p>Penggunaan Docker untuk membungkus aplikasi agar bisa dijalankan di berbagai lingkungan.</p>', min_score: 0),
                $this->post(title: 'Tugas Membuat Dockerfile untuk Aplikasi Web', description: '<p>Peserta membuat Dockerfile untuk aplikasi Express atau Laravel.</p>', min_score: 85),
                $this->post(title: 'Monitoring dan Logging', description: '<p>Pentingnya pencatatan log dan pemantauan aplikasi untuk menjaga stabilitas sistem.</p>', min_score: 0),
                $this->post(title: 'Proyek Mini: CI/CD Pipeline Sederhana', description: '<p>Peserta membangun pipeline CI/CD untuk aplikasi Node.js atau Python sederhana.</p>', min_score: 85)
            ]
        );

        Batch::query()->insert($this->batches);
        Post::query()->insert($this->posts);
    }

    protected function addBatch(string $name, int $price, int $duration, array $posts): void
    {
        $id = count($this->batches) + 1;
        $timestamp = now()
            ->toMutable()
            ->subMonths(16)
            ->setMonth($id)
            ->setHour(0)
            ->setMinute(0)
            ->setSeconds(fake()->randomFloat(0, 32400, 61200));

        $this->batches[] = [
            'id' => $id,
            'name' => $name,
            'slug' => $slug = str()->slug($name),
            'price' => $price,
            'duration' => $duration,
            'description' => "<p>Batch ini membahas tentang $name</p>",
            'thumbnail' => "thumbnails/batch/$slug.png",
            'created_at' => (string) $timestamp,
            'updated_at' => (string) $timestamp,
        ];

        $iteration = 1;
        foreach ($posts as &$post) {
            $post['batch_id'] = $id;
            $post['order'] = $iteration++;
            $post['slug'] = str()->slug($post['title']);
        }
        unset($post);

        foreach (Arr::shuffle($posts) as $post) {
            $timestamp
                ->addDays(fake()->randomFloat(0, 1, 3))
                ->setHour(0)
                ->setMinute(0)
                ->setSeconds(fake()->randomFloat(0, 32400, 61200));

            $post['created_at'] = (string) $timestamp;
            $post['updated_at'] = (string) $timestamp;

            $this->posts[] = $post;
        }
    }

    protected function post(string $title, string $description, int $min_score): array
    {
        return compact('title', 'description', 'min_score');
    }
}
