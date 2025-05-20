<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class BatchSeeder extends Seeder
{
    protected array $batches = [];

    protected array $posts = [];

    public function run(): void
    {
        Storage::disk('public')->makeDirectory("thumbnails/batch");

        $this->addBatch(
            name: 'Algoritma dan Struktur Data',
            price: 0,
            duration: 180,
            posts: [
                $this->post(title: 'Pengenalan Algoritma',
                    description: '<p>Materi ini membahas pengertian algoritma, karakteristik, serta pentingnya dalam pengembangan perangkat lunak.</p>',
                    content: '<p>Algoritma adalah langkah-langkah logis yang sistematis untuk menyelesaikan suatu permasalahan. Dalam pengembangan perangkat lunak, algoritma membantu merancang solusi yang efisien dan terstruktur.</p>',
                    min_score: null),

                $this->post(title: 'Struktur Data Dasar',
                    description: '<p>Membahas array, linked list, dan cara penggunaannya dalam berbagai kasus.</p>',
                    content: '<p>Struktur data dasar seperti array dan linked list digunakan untuk menyimpan dan mengelola data. Pemahaman terhadap keduanya penting untuk menyelesaikan berbagai masalah dalam pemrograman.</p>',
                    min_score: null),

                $this->post(title: 'Latihan Implementasi Array dan Linked List',
                    description: '<p>Tugas ini meminta peserta mengimplementasikan array dan linked list untuk menyelesaikan permasalahan sederhana.</p>',
                    content: '<p>Peserta diminta membuat program yang menggunakan array dan linked list untuk menyimpan dan memanipulasi data, seperti menambah, menghapus, atau mencari elemen.</p>',
                    min_score: 70),

                $this->post(title: 'Stack dan Queue',
                    description: '<p>Menjelaskan konsep stack dan queue serta penerapannya dalam pemrograman.</p>',
                    content: '<p>Stack (tumpukan) menggunakan prinsip LIFO (Last In, First Out), sedangkan Queue (antrian) menggunakan prinsip FIFO (First In, First Out). Keduanya banyak digunakan dalam pemrosesan data, seperti undo-redo atau simulasi antrean.</p>',
                    min_score: null),

                $this->post(title: 'Penerapan Stack dan Queue',
                    description: '<p>Latihan ini menantang peserta membuat program yang memanfaatkan stack dan queue untuk simulasi antrian.</p>',
                    content: '<p>Peserta membuat program untuk menyimulasikan skenario nyata seperti antrian bank atau pengelolaan data dengan stack. Fokus pada implementasi logika dasar struktur data tersebut.</p>',
                    min_score: 75),

                $this->post(title: 'Pengenalan Rekursi',
                    description: '<p>Materi ini menguraikan prinsip dasar rekursi dan contohnya pada perhitungan faktorial serta deret Fibonacci.</p>',
                    content: '<p>Rekursi adalah teknik pemrograman di mana fungsi memanggil dirinya sendiri. Cocok digunakan untuk masalah yang dapat dipecah menjadi sub-masalah yang serupa, seperti faktorial dan Fibonacci.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Rekursi',
                    description: '<p>Peserta diminta menyelesaikan beberapa masalah matematika sederhana dengan menggunakan rekursi.</p>',
                    content: '<p>Implementasikan fungsi rekursif untuk menyelesaikan masalah seperti faktorial, deret Fibonacci, dan pencarian nilai maksimum dalam array secara rekursif.</p>',
                    min_score: 70),

                $this->post(title: 'Sorting dan Searching',
                    description: '<p>Menjelaskan berbagai algoritma pengurutan dan pencarian seperti bubble sort, quicksort, dan binary search.</p>',
                    content: '<p>Materi mencakup pemahaman dan perbandingan algoritma pengurutan (sorting) dan pencarian (searching) yang sering digunakan, baik dari sisi efisiensi waktu maupun implementasi.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Pengurutan dan Pencarian',
                    description: '<p>Tugas ini berisi soal pemrograman untuk menguji pemahaman algoritma sorting dan searching.</p>',
                    content: '<p>Peserta mengimplementasikan berbagai algoritma sorting (bubble sort, insertion sort, quicksort) dan searching (linear search, binary search) untuk menyelesaikan permasalahan pada array.</p>',
                    min_score: 75),
            ]
        );

        $this->addBatch(
            name: 'Pengantar Basis Data',
            price: 0,
            duration: 150,
            posts: [
                $this->post(title: 'Konsep Dasar Basis Data',
                    description: '<p>Materi ini memperkenalkan definisi, tujuan, dan manfaat penggunaan basis data.</p>',
                    content: '<p>Basis data adalah kumpulan data yang terorganisir dan dapat diakses secara elektronik. Penggunaan basis data membantu dalam pengelolaan informasi yang lebih sistematis, aman, dan efisien dalam berbagai sistem informasi.</p>',
                    min_score: null),

                $this->post(title: 'Model Data dan ERD',
                    description: '<p>Membahas model data dan bagaimana membuat Entity Relationship Diagram (ERD) sebagai perancangan awal database.</p>',
                    content: '<p>Model data menjelaskan bagaimana data terstruktur dan saling berhubungan. ERD (Entity Relationship Diagram) digunakan untuk memodelkan entitas, atribut, dan relasi antar entitas sebelum implementasi basis data.</p>',
                    min_score: null),

                $this->post(title: 'Latihan ERD',
                    description: '<p>Peserta diminta membuat ERD berdasarkan studi kasus sistem akademik.</p>',
                    content: '<p>Buat ERD berdasarkan skenario sistem akademik yang mencakup entitas seperti mahasiswa, dosen, mata kuliah, dan jadwal. Identifikasi relasi dan tentukan atribut utama dari setiap entitas.</p>',
                    min_score: 70),

                $this->post(title: 'Normalisasi',
                    description: '<p>Penjelasan mengenai proses normalisasi untuk menghindari redudansi data dan meningkatkan efisiensi penyimpanan.</p>',
                    content: '<p>Normalisasi adalah proses pengorganisasian data dalam basis data untuk mengurangi duplikasi dan memastikan integritas data. Proses ini dilakukan melalui tahapan bentuk normal (normal forms).</p>',
                    min_score: null),

                $this->post(title: 'Tugas Normalisasi',
                    description: '<p>Peserta melakukan normalisasi hingga bentuk ketiga dari tabel yang disediakan.</p>',
                    content: '<p>Analisis tabel data yang diberikan dan lakukan normalisasi hingga mencapai bentuk normal ketiga (3NF) dengan mengidentifikasi kunci utama, dependensi fungsional, dan pemisahan tabel yang tepat.</p>',
                    min_score: 75),

                $this->post(title: 'Dasar SQL: SELECT dan JOIN',
                    description: '<p>Membahas perintah dasar SQL untuk pengambilan data dan penggabungan tabel.</p>',
                    content: '<p>SQL menyediakan perintah seperti <code>SELECT</code>, <code>WHERE</code>, dan <code>JOIN</code> untuk mengambil dan menggabungkan data dari beberapa tabel. Pemahaman dasar ini sangat penting dalam manipulasi data relasional.</p>',
                    min_score: null),

                $this->post(title: 'Latihan Query SQL',
                    description: '<p>Tugas ini berisi soal query SELECT, WHERE, JOIN dan GROUP BY untuk kasus toko buku.</p>',
                    content: '<p>Gunakan SQL untuk menulis query yang menampilkan data penjualan, stok buku, dan total transaksi. Tugas meliputi penggunaan <code>JOIN</code>, <code>GROUP BY</code>, dan <code>WHERE</code> dengan kondisi tertentu.</p>',
                    min_score: 75),

                $this->post(title: 'Transaksi dan Integritas Data',
                    description: '<p>Menjelaskan konsep ACID, transaksi, dan pentingnya menjaga integritas data dalam basis data relasional.</p>',
                    content: '<p>Transaksi dalam basis data harus memenuhi prinsip ACID (Atomicity, Consistency, Isolation, Durability) agar data tetap valid, utuh, dan bebas dari gangguan meskipun terjadi kegagalan sistem.</p>',
                    min_score: null),

            ]
        );

        $this->addBatch(
            name: 'Pemrograman Berorientasi Objek (OOP)',
            price: 0,
            duration: 180,
            posts: [
                $this->post(title: 'Konsep Dasar OOP',
                    description: '<p>Menjelaskan paradigma OOP dan perbedaan dengan pemrograman prosedural.</p>',
                    content: '<p>Object-Oriented Programming (OOP) merupakan paradigma pemrograman berbasis objek yang menggabungkan data dan fungsi dalam satu kesatuan. OOP berfokus pada pembuatan objek yang merepresentasikan entitas dunia nyata, berbeda dengan pemrograman prosedural yang berorientasi pada urutan instruksi.</p>',
                    min_score: null),

                $this->post(title: 'Class dan Object',
                    description: '<p>Pembahasan tentang class, object, property, dan method dalam OOP.</p>',
                    content: '<p>Class adalah cetak biru dari objek yang mendefinisikan properti (atribut) dan method (fungsi). Objek adalah instansiasi dari class yang memiliki nilai nyata. Pemahaman konsep ini merupakan dasar utama dalam OOP.</p>',
                    min_score: null),

                $this->post(title: 'Latihan Membuat Class',
                    description: '<p>Peserta diminta membuat class dan object sederhana dari studi kasus sistem toko.</p>',
                    content: '<p>Buatlah class bernama <code>Produk</code> dengan properti seperti nama, harga, dan stok. Kemudian, instansiasi beberapa objek dari class tersebut dan tampilkan datanya melalui method yang sesuai.</p>',
                    min_score: 70),

                $this->post(title: 'Encapsulation dan Constructor',
                    description: '<p>Materi ini membahas encapsulation untuk melindungi data dan penggunaan constructor dalam inisialisasi object.</p>',
                    content: '<p>Encapsulation digunakan untuk membatasi akses langsung ke properti melalui penggunaan akses modifier (private, protected, public). Constructor adalah method khusus yang dijalankan saat objek dibuat untuk menginisialisasi data awal.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Enkapsulasi dan Constructor',
                    description: '<p>Latihan membuat class dengan akses modifier dan constructor.</p>',
                    content: '<p>Implementasikan class dengan beberapa properti private dan method getter-setter. Gunakan constructor untuk memberi nilai awal pada saat pembuatan objek.</p>',
                    min_score: 75),

                $this->post(title: 'Inheritance',
                    description: '<p>Menjelaskan pewarisan antar class dan penggunaannya dalam kode reusable.</p>',
                    content: '<p>Inheritance (pewarisan) memungkinkan class turunan mewarisi atribut dan method dari class induk. Ini memungkinkan reuse kode dan mempermudah pemeliharaan serta pengembangan sistem.</p>',
                    min_score: null),

                $this->post(title: 'Polymorphism dan Overriding',
                    description: '<p>Membahas kemampuan objek untuk berperilaku berbeda dalam konteks berbeda.</p>',
                    content: '<p>Polymorphism memungkinkan objek yang sama diperlakukan berbeda tergantung konteksnya. Salah satu bentuknya adalah method overriding, yaitu ketika subclass mengganti implementasi method dari superclass.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Inheritance dan Polymorphism',
                    description: '<p>Peserta membuat class turunan dan mengimplementasikan metode override.</p>',
                    content: '<p>Buatlah class induk <code>Kendaraan</code> dan class turunan seperti <code>Mobil</code> dan <code>Motor</code>. Override method seperti <code>jalan()</code> di masing-masing class turunan untuk menunjukkan perilaku yang berbeda.</p>',
                    min_score: 80),

                $this->post(title: 'Abstraction dan Interface',
                    description: '<p>Penjelasan konsep abstract class dan interface dalam desain sistem OOP.</p>',
                    content: '<p>Abstraksi menyembunyikan detail implementasi dan hanya menampilkan fungsionalitas penting. Abstract class dan interface digunakan untuk mendefinisikan kontrak dalam sistem OOP yang harus diikuti oleh class turunan.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: Sistem Perpustakaan',
                    description: '<p>Peserta membangun sistem OOP untuk pengelolaan buku dan peminjaman.</p>',
                    content: '<p>Bangun sistem menggunakan konsep OOP lengkap: class, inheritance, polymorphism, encapsulation, dan abstraction. Sistem mencakup entitas Buku, Anggota, dan Transaksi Peminjaman, dengan fungsionalitas untuk menambahkan, meminjam, dan mengembalikan buku.</p>',
                    min_score: 80),
            ]
        );

        $this->addBatch(
            name: 'Pemrograman Web Dasar',
            price: 0,
            duration: 150,
            posts: [
                $this->post(title: 'HTML: Struktur Dasar Halaman Web',
                    description: '<p>Membahas struktur dasar HTML dan elemen penting seperti heading, paragraph, dan list.</p>',
                    content: '<p>HTML (HyperText Markup Language) adalah bahasa standar untuk membuat struktur halaman web. Elemen-elemen dasar seperti <code>&lt;h1&gt;</code> hingga <code>&lt;h6&gt;</code> digunakan untuk judul, <code>&lt;p&gt;</code> untuk paragraf, dan <code>&lt;ul&gt;</code>, <code>&lt;ol&gt;</code> serta <code>&lt;li&gt;</code> untuk daftar.</p>',
                    min_score: null),

                $this->post(title: 'CSS: Styling Halaman',
                    description: '<p>Menjelaskan cara menggunakan CSS untuk memperindah halaman web, baik inline maupun eksternal.</p>',
                    content: '<p>CSS (Cascading Style Sheets) digunakan untuk memperindah tampilan HTML. Terdapat tiga cara penerapan CSS: inline (langsung pada elemen), internal (dalam tag <code>&lt;style&gt;</code>), dan eksternal (menghubungkan file <code>.css</code> terpisah).</p>',
                    min_score: null),

                $this->post(title: 'Tugas Styling dengan CSS',
                    description: '<p>Peserta membuat halaman profil dengan gaya CSS yang telah dipelajari.</p>',
                    content: '<p>Bangun halaman profil pribadi yang berisi foto, nama, dan deskripsi singkat. Terapkan gaya CSS seperti warna latar, ukuran font, dan layout sederhana menggunakan selector dan properti CSS.</p>',
                    min_score: 70),

                $this->post(title: 'Layout dengan Flexbox dan Grid',
                    description: '<p>Penjelasan tentang teknik tata letak modern menggunakan Flexbox dan Grid.</p>',
                    content: '<p>Flexbox dan CSS Grid adalah dua teknik layout modern dalam CSS. Flexbox digunakan untuk tata letak satu dimensi (baris atau kolom), sedangkan Grid cocok untuk dua dimensi. Keduanya memudahkan penataan elemen dalam berbagai resolusi layar.</p>',
                    min_score: null),

                $this->post(title: 'Formulir dan Validasi Dasar',
                    description: '<p>Membahas elemen form HTML dan validasi menggunakan atribut bawaan.</p>',
                    content: '<p>Form HTML memungkinkan pengguna mengirimkan data. Elemen seperti <code>&lt;input&gt;</code>, <code>&lt;textarea&gt;</code>, dan <code>&lt;button&gt;</code> digunakan bersama atribut validasi seperti <code>required</code>, <code>type</code>, dan <code>pattern</code> untuk memverifikasi input.</p>',
                    min_score: null),

                $this->post(title: 'Dasar JavaScript untuk Interaktivitas',
                    description: '<p>Pengenalan JavaScript untuk manipulasi DOM dan event handling.</p>',
                    content: '<p>JavaScript memungkinkan halaman web menjadi interaktif. Melalui DOM (Document Object Model), JavaScript dapat memanipulasi elemen HTML. Event seperti klik atau input dapat dideteksi dan ditangani menggunakan <code>addEventListener</code>.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Interaktivitas Web',
                    description: '<p>Latihan membuat form interaktif dengan validasi menggunakan JavaScript.</p>',
                    content: '<p>Peserta membuat form pendaftaran yang memvalidasi input seperti email dan password secara real-time menggunakan JavaScript. Gunakan fungsi dan event untuk menampilkan pesan kesalahan yang sesuai.</p>',
                    min_score: 75),

                $this->post(title: 'Proyek Mini: Landing Page Produk',
                    description: '<p>Peserta diminta membangun landing page sederhana untuk produk fiktif.</p>',
                    content: '<p>Bangun landing page yang menarik dan responsif untuk sebuah produk fiktif. Gunakan HTML untuk struktur, CSS untuk desain, dan JavaScript untuk menambahkan sedikit interaktivitas, seperti tombol "Beli Sekarang".</p>',
                    min_score: 80),
            ]
        );

        $this->addBatch(
            name: 'Basis Data Lanjutan',
            price: 100_000,
            duration: 180,
            posts: [
                $this->post(title: 'Relasi dan Foreign Key',
                    description: '<p>Membahas konsep relasi antar tabel dan penggunaan foreign key untuk menjaga integritas referensial.</p>',
                    content: '<p>Relasi dalam database menggambarkan hubungan antara tabel, seperti one-to-many atau many-to-many. Foreign key digunakan untuk memastikan bahwa nilai pada suatu kolom terkait dengan nilai primer di tabel lain, menjaga konsistensi dan integritas data.</p>',
                    min_score: null),

                $this->post(title: 'View dan Stored Procedure',
                    description: '<p>Penjelasan tentang view untuk abstraksi data dan stored procedure untuk logika bisnis di tingkat database.</p>',
                    content: '<p>View adalah representasi virtual dari query SQL yang disimpan, berguna untuk menyederhanakan akses data. Stored procedure adalah blok perintah SQL yang disimpan di server, digunakan untuk menjalankan logika bisnis seperti perhitungan atau manipulasi data secara efisien.</p>',
                    min_score: null),

                $this->post(title: 'Latihan Stored Procedure',
                    description: '<p>Tugas membuat prosedur untuk menghitung total transaksi dan insert otomatis.</p>',
                    content: '<p>Buat stored procedure untuk menghitung total transaksi pelanggan berdasarkan ID. Tambahkan juga prosedur lain untuk memasukkan data pesanan baru secara otomatis ke tabel terkait, termasuk perhitungan otomatis nilai totalnya.</p>',
                    min_score: 75),

                $this->post(title: 'Indexing dan Optimisasi Query',
                    description: '<p>Materi ini membahas strategi indexing dan teknik optimasi query untuk performa yang lebih baik.</p>',
                    content: '<p>Index berfungsi mempercepat pencarian data dalam tabel. Optimisasi query mencakup pemilihan kolom yang tepat, menghindari SELECT *, serta memahami execution plan agar beban database dapat diminimalisir.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Indexing dan Query Optimization',
                    description: '<p>Peserta diminta mengidentifikasi dan mempercepat query lambat menggunakan index.</p>',
                    content: '<p>Analisis query lambat menggunakan <code>EXPLAIN</code> untuk menemukan bottleneck. Terapkan index pada kolom yang sering digunakan dalam klausa WHERE atau JOIN. Evaluasi kembali kecepatan eksekusi setelah pengindeksan.</p>',
                    min_score: 80),

                $this->post(title: 'Database NoSQL dan Perbandingan',
                    description: '<p>Pengantar ke MongoDB dan perbandingannya dengan basis data relasional.</p>',
                    content: '<p>NoSQL seperti MongoDB menyimpan data dalam format dokumen (JSON-like). Tidak menggunakan skema tetap, sehingga fleksibel untuk data tidak terstruktur. Dibandingkan dengan RDBMS, NoSQL unggul dalam skalabilitas horizontal dan performa baca/tulis tertentu.</p>',
                    min_score: null),

                $this->post(title: 'Replikasi dan Backup Database',
                    description: '<p>Mengenal teknik replikasi dan strategi backup data untuk ketersediaan tinggi.</p>',
                    content: '<p>Replikasi adalah proses menyalin data antar server database untuk meningkatkan ketersediaan dan toleransi kesalahan. Backup melibatkan penyimpanan salinan data agar dapat dipulihkan saat terjadi kerusakan. Strategi backup bisa berkala atau real-time.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: Sistem Pemesanan Online',
                    description: '<p>Peserta membangun database terstruktur dan stored procedure untuk sistem pemesanan restoran.</p>',
                    content: '<p>Rancang sistem pemesanan online dengan relasi antar tabel pelanggan, menu, dan transaksi. Gunakan stored procedure untuk otomatisasi proses pemesanan, perhitungan total, dan pelacakan status pesanan secara efisien.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Jaringan Komputer',
            price: 120_000,
            duration: 200,
            posts: [
                $this->post(title: 'Dasar-Dasar Jaringan',
                    description: '<p>Pengenalan jaringan komputer, perangkat dasar, dan konsep client-server.</p>',
                    content: '<p>Jaringan komputer adalah sistem yang menghubungkan dua atau lebih perangkat untuk berbagi sumber daya. Materi ini mencakup perangkat jaringan seperti switch, router, dan kabel, serta model client-server dan peer-to-peer dalam komunikasi data.</p>',
                    min_score: null),

                $this->post(title: 'Model OSI dan TCP/IP',
                    description: '<p>Penjelasan 7 lapisan model OSI dan bagaimana TCP/IP bekerja dalam dunia nyata.</p>',
                    content: '<p>Model OSI terdiri dari 7 lapisan yang menjelaskan alur komunikasi data secara konseptual. TCP/IP merupakan implementasi praktis yang hanya memiliki 4 lapisan utama. Pemahaman kedua model penting untuk menganalisis dan merancang komunikasi jaringan.</p>',
                    min_score: null),

                $this->post(title: 'Pengalamatan IP dan Subnetting',
                    description: '<p>Materi ini membahas IPv4, penghitungan subnet, dan pengalokasian IP address.</p>',
                    content: '<p>IPv4 menggunakan alamat 32-bit yang dibagi menjadi network dan host. Subnetting memungkinkan pembagian jaringan besar menjadi bagian-bagian kecil. Materi ini mencakup cara menghitung subnet mask, jumlah host, dan pengalokasian IP yang efisien.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Subnetting',
                    description: '<p>Peserta diminta menyelesaikan kasus subnetting untuk jaringan skala kecil-menengah.</p>',
                    content: '<p>Berikan solusi untuk pengalokasian IP dengan subnet mask yang sesuai untuk jaringan dengan beberapa departemen. Hitung jumlah subnet yang dibutuhkan dan sediakan range IP valid serta broadcast address untuk tiap subnet.</p>',
                    min_score: 75),

                $this->post(title: 'Routing dan Switching',
                    description: '<p>Menjelaskan mekanisme routing dan peran switch dalam LAN.</p>',
                    content: '<p>Routing adalah proses pengiriman data antar jaringan menggunakan router. Switching berfungsi menghubungkan perangkat dalam satu jaringan lokal (LAN). Materi ini menjelaskan peran tabel routing, protokol seperti RIP dan OSPF, serta jenis-jenis switch.</p>',
                    min_score: null),

                $this->post(title: 'Keamanan Jaringan',
                    description: '<p>Pengenalan firewall, VPN, dan metode enkripsi dasar untuk keamanan jaringan.</p>',
                    content: '<p>Keamanan jaringan meliputi perlindungan data dan akses melalui firewall, VPN untuk komunikasi aman, serta enkripsi seperti AES. Penting untuk mencegah serangan seperti sniffing, spoofing, dan DoS.</p>',
                    min_score: null),

                $this->post(title: 'Simulasi Topologi dengan Cisco Packet Tracer',
                    description: '<p>Tugas membuat topologi jaringan dan pengujian konektivitas antar host.</p>',
                    content: '<p>Gunakan Cisco Packet Tracer untuk merancang topologi jaringan dengan router, switch, dan PC. Lakukan konfigurasi IP, routing statis, dan pengujian konektivitas dengan <code>ping</code> atau <code>traceroute</code> antar host.</p>',
                    min_score: 80),

                $this->post(title: 'Proyek: Desain Jaringan Kantor',
                    description: '<p>Peserta merancang dan mengkonfigurasi topologi jaringan untuk kantor kecil menggunakan simulasi.</p>',
                    content: '<p>Buat desain jaringan kantor yang mencakup subnetting, pengaturan DHCP, konfigurasi switch dan router, serta pengamanan dasar. Proyek ini menguji pemahaman menyeluruh dalam implementasi jaringan lokal skala kecil.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Sistem Operasi',
            price: 100_000,
            duration: 180,
            posts: [
                $this->post(title: 'Pengenalan Sistem Operasi',
                    description: '<p>Menjelaskan fungsi utama sistem operasi sebagai pengelola sumber daya dan antarmuka pengguna.</p>',
                    content: '<p>Sistem Operasi (OS) adalah perangkat lunak yang mengelola perangkat keras komputer dan menyediakan layanan bagi program aplikasi. OS berfungsi sebagai perantara antara pengguna dan perangkat keras serta bertanggung jawab terhadap manajemen sumber daya seperti CPU, memori, penyimpanan, dan perangkat I/O.</p>',
                    min_score: null),

                $this->post(title: 'Manajemen Proses dan Thread',
                    description: '<p>Membahas konsep proses, multithreading, dan penjadwalan CPU.</p>',
                    content: '<p>Proses adalah program yang sedang dieksekusi, sedangkan thread adalah unit terkecil dalam eksekusi. Materi ini menjelaskan konsep proses, thread, konteks switching, serta algoritma penjadwalan seperti FCFS, SJF, dan Round Robin.</p>',
                    min_score: null),

                $this->post(title: 'Latihan Penjadwalan Proses',
                    description: '<p>Tugas menghitung waktu rata-rata turnaround dan waiting time dari skenario proses.</p>',
                    content: '<p>Peserta diminta menghitung average waiting time dan turnaround time dari beberapa proses dengan burst time dan arrival time tertentu menggunakan algoritma penjadwalan seperti FCFS atau SJF.</p>',
                    min_score: 70),

                $this->post(title: 'Manajemen Memori',
                    description: '<p>Pembahasan paging, segmentation, dan alokasi memori dinamis.</p>',
                    content: '<p>Manajemen memori bertugas mengalokasikan ruang memori untuk proses secara efisien. Topik ini mencakup teknik paging untuk membagi memori ke dalam frame, segmentation untuk manajemen logis, serta metode alokasi seperti first-fit dan best-fit.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Memori Virtual',
                    description: '<p>Peserta menyelesaikan soal simulasi manajemen memori dengan paging dan page replacement.</p>',
                    content: '<p>Latihan ini mengharuskan peserta melakukan simulasi sistem paging dan menerapkan algoritma page replacement seperti FIFO, LRU, atau Optimal untuk menentukan jumlah page fault pada sebuah skenario akses memori.</p>',
                    min_score: 80),

                $this->post(title: 'Sistem File dan I/O',
                    description: '<p>Materi sistem file, struktur direktori, dan manajemen I/O.</p>',
                    content: '<p>Sistem file mengatur penyimpanan dan pengambilan data. Materi ini mencakup struktur file, jenis sistem direktori (single-level, tree-structured), serta mekanisme manajemen I/O dan buffer untuk efisiensi operasi perangkat keras.</p>',
                    min_score: null),

                $this->post(title: 'Penggunaan Shell dan Perintah Linux',
                    description: '<p>Latihan menggunakan perintah dasar Linux untuk navigasi dan manajemen file.</p>',
                    content: '<p>Peserta dikenalkan dengan command line Linux melalui shell seperti bash. Latihan mencakup perintah dasar seperti <code>ls</code>, <code>cd</code>, <code>mkdir</code>, <code>cp</code>, <code>mv</code>, dan <code>chmod</code> untuk pengelolaan file dan direktori.</p>',
                    min_score: 75),

                $this->post(title: 'Proyek Mini: Simulasi Penjadwalan',
                    description: '<p>Peserta membuat program simulasi penjadwalan CPU menggunakan bahasa pemrograman tertentu.</p>',
                    content: '<p>Pada proyek ini, peserta membuat program simulasi penjadwalan proses (misalnya Round Robin atau Priority Scheduling) yang menghitung waktu tunggu, turnaround time, dan menampilkan Gantt Chart sebagai visualisasi proses.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Keamanan Siber',
            price: 150_000,
            duration: 200,
            posts: [
                $this->post(title: 'Ancaman dan Kerentanan Umum',
                    description: '<p>Menjelaskan jenis-jenis ancaman cyber seperti malware, phishing, dan ransomware.</p>',
                    content: '<p>Materi ini membahas berbagai jenis ancaman siber termasuk malware (virus, worm, trojan), serangan phishing yang memanipulasi pengguna untuk memberikan data sensitif, serta ransomware yang mengenkripsi data korban dan meminta tebusan.</p>',
                    min_score: null),

                $this->post(title: 'Enkripsi dan Kriptografi Dasar',
                    description: '<p>Membahas konsep enkripsi simetris dan asimetris, serta contoh penggunaannya.</p>',
                    content: '<p>Kriptografi adalah teknik pengamanan data dengan mengubah informasi menjadi format yang tidak bisa dibaca tanpa kunci tertentu. Enkripsi simetris menggunakan satu kunci, sedangkan enkripsi asimetris menggunakan sepasang kunci publik dan privat. Contohnya AES (simetris) dan RSA (asimetris).</p>',
                    min_score: null),

                $this->post(title: 'Tugas Implementasi Enkripsi',
                    description: '<p>Peserta mengimplementasikan algoritma enkripsi Caesar dan RSA sederhana.</p>',
                    content: '<p>Pada tugas ini, peserta diminta untuk menulis kode program sederhana untuk mengimplementasikan Caesar Cipher (penggeseran karakter) dan RSA (menggunakan bilangan prima untuk enkripsi asimetris).</p>',
                    min_score: 80),

                $this->post(title: 'Firewall dan IDS',
                    description: '<p>Materi tentang peran firewall dan intrusion detection system dalam sistem pertahanan jaringan.</p>',
                    content: '<p>Firewall adalah sistem keamanan jaringan yang memfilter lalu lintas berdasarkan aturan tertentu. IDS (Intrusion Detection System) digunakan untuk memonitor dan mendeteksi aktivitas mencurigakan di jaringan untuk mencegah ancaman keamanan.</p>',
                    min_score: null),

                $this->post(title: 'Autentikasi dan Manajemen Akses',
                    description: '<p>Menjelaskan konsep login, token, dan autentikasi dua faktor.</p>',
                    content: '<p>Autentikasi adalah proses memverifikasi identitas pengguna. Materi ini menjelaskan mekanisme login dasar, penggunaan token untuk sesi pengguna, dan penerapan autentikasi dua faktor (2FA) untuk meningkatkan keamanan akses.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Analisis Log Keamanan',
                    description: '<p>Peserta menganalisis log sistem untuk mendeteksi aktivitas mencurigakan.</p>',
                    content: '<p>Peserta diminta mengamati dan menganalisis log keamanan sistem (seperti log login, firewall, atau audit trail) untuk menemukan pola akses yang mencurigakan atau potensi serangan.</p>',
                    min_score: 80),

                $this->post(title: 'Pengujian Keamanan Aplikasi (OWASP)',
                    description: '<p>Menjelaskan 10 celah keamanan utama OWASP dan cara menghindarinya.</p>',
                    content: '<p>OWASP Top 10 adalah daftar sepuluh risiko keamanan aplikasi web paling kritis seperti SQL Injection, XSS, dan Broken Authentication. Materi ini menjelaskan masing-masing celah dan cara mitigasinya.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: Audit Keamanan Web',
                    description: '<p>Peserta melakukan audit sederhana terhadap aplikasi web menggunakan tools open-source.</p>',
                    content: '<p>Dalam proyek ini, peserta melakukan audit keamanan terhadap aplikasi web, misalnya dengan menggunakan tools seperti OWASP ZAP atau Burp Suite, untuk mengidentifikasi kelemahan umum seperti input validation, XSS, dan konfigurasi yang lemah.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Pengantar Kecerdasan Buatan',
            price: 150_000,
            duration: 210,
            posts: [
                $this->post(title: 'Definisi dan Aplikasi AI',
                    description: '<p>Pengenalan kecerdasan buatan dan penerapannya di berbagai bidang seperti kesehatan dan transportasi.</p>',
                    content: '<p>Kecerdasan Buatan (AI) adalah cabang ilmu komputer yang menekankan pada pembuatan sistem yang dapat meniru kemampuan manusia seperti belajar, bernalar, dan memecahkan masalah. Aplikasi AI meliputi bidang kesehatan (diagnosis otomatis), transportasi (mobil otonom), keuangan, pendidikan, dan lainnya.</p>',
                    min_score: null),

                $this->post(title: 'Search Algorithm: DFS & BFS',
                    description: '<p>Penjelasan algoritma pencarian dasar dalam pemecahan masalah.</p>',
                    content: '<p>Algoritma DFS (Depth-First Search) dan BFS (Breadth-First Search) digunakan untuk menelusuri struktur data seperti pohon atau graf. DFS menelusuri ke dalam hingga ke titik terdalam sebelum kembali, sedangkan BFS menjelajah tingkat per tingkat dari akar ke anak-anaknya.</p>',
                    min_score: null),

                $this->post(title: 'Tugas DFS & BFS',
                    description: '<p>Implementasi DFS dan BFS dalam penyelesaian maze atau graf.</p>',
                    content: '<p>Pada tugas ini, peserta diminta mengimplementasikan algoritma DFS dan BFS untuk menyelesaikan permasalahan seperti pencarian jalur dalam labirin atau graf tak berarah.</p>',
                    min_score: 80),

                $this->post(title: 'Representasi Pengetahuan dan Inferensi',
                    description: '<p>Materi tentang logika proposisional dan inference rule sederhana.</p>',
                    content: '<p>Representasi pengetahuan menggunakan logika proposisional memungkinkan sistem AI memahami fakta dan aturan. Inferensi logis seperti modus ponens digunakan untuk menarik kesimpulan baru dari fakta dan aturan yang tersedia.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Inferensi Logika',
                    description: '<p>Peserta memformulasikan fakta dan aturan, lalu menyimpulkan informasi baru.</p>',
                    content: '<p>Tugas ini meminta peserta untuk menyusun fakta dan aturan dalam bentuk logika proposisional, lalu menggunakan aturan inferensi seperti modus ponens untuk menarik kesimpulan logis.</p>',
                    min_score: 75),

                $this->post(title: 'Perkenalan Machine Learning',
                    description: '<p>Gambaran supervised vs unsupervised learning, regresi linier, dan klasifikasi.</p>',
                    content: '<p>Machine Learning adalah metode AI yang memungkinkan sistem belajar dari data. Supervised learning melibatkan data berlabel (seperti klasifikasi dan regresi), sedangkan unsupervised learning digunakan untuk pengelompokan tanpa label, seperti clustering. Regresi linier digunakan untuk prediksi nilai numerik.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: Prediksi Harga Rumah',
                    description: '<p>Peserta menerapkan regresi linier untuk memprediksi harga rumah berdasarkan dataset sederhana.</p>',
                    content: '<p>Pada proyek ini, peserta menggunakan regresi linier untuk memodelkan hubungan antara fitur-fitur seperti luas tanah, jumlah kamar, dan harga rumah, lalu membuat prediksi berdasarkan data baru.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Pemrograman Mobile dengan Flutter',
            price: 200_000,
            duration: 240,
            posts: [
                $this->post(title: 'Pengenalan Flutter dan Dart',
                    description: '<p>Dasar framework Flutter, struktur proyek, dan bahasa Dart.</p>',
                    content: '<p>Flutter adalah framework UI open-source dari Google untuk membuat aplikasi native di Android, iOS, dan web menggunakan satu basis kode. Bahasa pemrograman utama Flutter adalah Dart yang mudah dipelajari dan mendukung pemrograman asinkron.</p>',
                    min_score: null),

                $this->post(title: 'Widget Dasar dan Navigasi',
                    description: '<p>Penggunaan widget dasar dan navigasi antar halaman di Flutter.</p>',
                    content: '<p>Widget adalah elemen dasar tampilan di Flutter, seperti Text, Button, dan Container. Navigasi antar halaman menggunakan Navigator dan Route memungkinkan perpindahan layar dalam aplikasi.</p>',
                    min_score: null),

                $this->post(title: 'Tugas UI Aplikasi Profil',
                    description: '<p>Peserta membangun halaman profil statis menggunakan Flutter.</p>',
                    content: '<p>Tugas ini mengajak peserta membuat tampilan halaman profil sederhana dengan widget dasar Flutter seperti Column, Row, Image, dan Text, serta mengatur tata letak menggunakan widget layout.</p>',
                    min_score: 80),

                $this->post(title: 'State Management (setState, Provider)',
                    description: '<p>Menjelaskan pengelolaan data antar komponen menggunakan state management.</p>',
                    content: '<p>State management penting untuk menjaga konsistensi data di UI. setState adalah metode sederhana untuk memperbarui UI, sedangkan Provider adalah library populer untuk pengelolaan state yang lebih terstruktur dan scalable.</p>',
                    min_score: null),

                $this->post(title: 'Koneksi API dan JSON Parsing',
                    description: '<p>Materi ini membahas fetch data dari API dan parsing JSON ke dalam UI.</p>',
                    content: '<p>Peserta belajar cara mengambil data dari REST API menggunakan package http, kemudian mengubah data JSON menjadi objek Dart dan menampilkan hasilnya pada widget UI.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Konsumsi API',
                    description: '<p>Peserta membuat aplikasi katalog produk yang mengambil data dari API.</p>',
                    content: '<p>Tugas ini meminta peserta membangun aplikasi yang menampilkan daftar produk dengan data yang diambil secara dinamis dari API, menguji kemampuan parsing dan rendering data.</p>',
                    min_score: 85),

                $this->post(title: 'Authentication dan Routing Dinamis',
                    description: '<p>Pengenalan fitur login dan register serta routing berdasarkan autentikasi pengguna.</p>',
                    content: '<p>Materi mencakup implementasi login dan registrasi pengguna dengan validasi, serta pengaturan routing dinamis yang mengarahkan pengguna ke halaman berbeda berdasarkan status autentikasi.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: Aplikasi Catatan Harian',
                    description: '<p>Membangun aplikasi catatan harian dengan login dan penyimpanan lokal menggunakan Flutter.</p>',
                    content: '<p>Dalam proyek mini ini, peserta membuat aplikasi catatan harian yang mendukung autentikasi pengguna dan menyimpan data secara lokal menggunakan SQLite atau Shared Preferences.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Keamanan Informasi Dasar',
            price: 0,
            duration: 180,
            posts: [
                $this->post(title: 'Ancaman Umum dalam Dunia Digital',
                    description: '<p>Virus, malware, phishing, dan serangan DoS/DDoS.</p>',
                    content: '<p>Materi ini membahas berbagai ancaman digital yang umum dihadapi, mulai dari virus komputer, malware berbahaya, teknik phishing untuk mencuri data, hingga serangan Denial of Service (DoS) dan Distributed Denial of Service (DDoS) yang dapat melumpuhkan layanan online.</p>',
                    min_score: null),

                $this->post(title: 'Kriptografi Dasar',
                    description: '<p>Pengenalan enkripsi simetris dan asimetris serta algoritma umum.</p>',
                    content: '<p>Menjelaskan dasar-dasar kriptografi termasuk perbedaan enkripsi simetris dan asimetris, serta mengenalkan algoritma populer seperti AES, RSA, dan metode hashing untuk menjaga kerahasiaan dan integritas data.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Implementasi Enkripsi Sederhana',
                    description: '<p>Peserta mengimplementasikan Caesar Cipher dan Vigenère Cipher.</p>',
                    content: '<p>Latihan praktis di mana peserta membuat program yang menerapkan algoritma enkripsi klasik Caesar Cipher dan Vigenère Cipher untuk memahami konsep dasar pengamanan data.</p>',
                    min_score: 80),

                $this->post(title: 'Konsep Authentication dan Authorization',
                    description: '<p>Perbedaan autentikasi dan otorisasi serta penggunaannya dalam sistem.</p>',
                    content: '<p>Materi membahas perbedaan antara autentikasi (proses verifikasi identitas pengguna) dan otorisasi (penentuan hak akses), serta bagaimana keduanya diterapkan dalam pengelolaan keamanan sistem.</p>',
                    min_score: null),

                $this->post(title: 'Keamanan Jaringan: Firewall dan VPN',
                    description: '<p>Prinsip kerja firewall dan penggunaan VPN untuk koneksi aman.</p>',
                    content: '<p>Menjelaskan bagaimana firewall mengontrol lalu lintas jaringan untuk mencegah akses tidak sah, serta bagaimana VPN (Virtual Private Network) menyediakan koneksi terenkripsi untuk melindungi data selama transmisi.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Konfigurasi Firewall Sederhana',
                    description: '<p>Peserta mengatur aturan lalu lintas jaringan menggunakan iptables atau UFW.</p>',
                    content: '<p>Peserta melakukan konfigurasi firewall sederhana dengan tools seperti iptables atau UFW untuk mengatur dan membatasi akses jaringan demi meningkatkan keamanan sistem.</p>',
                    min_score: 80),

                $this->post(title: 'Pengamanan Web Application',
                    description: '<p>Vulnerability umum seperti SQL Injection, XSS, dan CSRF.</p>',
                    content: '<p>Materi tentang celah keamanan yang sering ditemukan di aplikasi web, termasuk SQL Injection untuk manipulasi database, Cross-Site Scripting (XSS) untuk penyisipan script berbahaya, dan Cross-Site Request Forgery (CSRF) yang dapat membajak sesi pengguna.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: Audit Keamanan Sistem Sederhana',
                    description: '<p>Peserta melakukan audit pada aplikasi web lokal menggunakan OWASP ZAP.</p>',
                    content: '<p>Proyek mini yang melatih peserta melakukan audit keamanan aplikasi web sederhana dengan memanfaatkan tools open-source seperti OWASP ZAP untuk menemukan dan menganalisis kerentanan.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Pengembangan API dan Otentikasi',
            price: 125_000,
            duration: 200,
            posts: [
                $this->post(title: 'Pengenalan RESTful API',
                    description: '<p>Penjelasan prinsip REST, endpoint, dan metode HTTP.</p>',
                    content: '<p>Materi ini membahas konsep dasar RESTful API, termasuk prinsip stateless, penggunaan endpoint untuk sumber daya, serta metode HTTP seperti GET, POST, PUT, dan DELETE untuk manipulasi data.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Membuat API CRUD Produk',
                    description: '<p>Peserta membangun API produk dengan metode GET, POST, PUT, DELETE.</p>',
                    content: '<p>Latihan praktis membuat API CRUD (Create, Read, Update, Delete) untuk entitas produk menggunakan HTTP methods sesuai standar REST, meliputi pengelolaan data produk secara lengkap.</p>',
                    min_score: 85),

                $this->post(title: 'Validasi dan Error Handling',
                    description: '<p>Menjelaskan pentingnya validasi input dan penanganan error yang baik.</p>',
                    content: '<p>Materi membahas teknik validasi input agar data yang masuk benar dan aman, serta cara menangani error agar API dapat merespon dengan pesan yang jelas dan sesuai standar HTTP.</p>',
                    min_score: null),

                $this->post(title: 'Otentikasi Menggunakan Token JWT',
                    description: '<p>Materi membahas struktur JWT, implementasi login, dan proteksi endpoint.</p>',
                    content: '<p>Menjelaskan konsep JSON Web Token (JWT) sebagai metode otentikasi yang aman dan stateless, termasuk struktur token, proses login, dan bagaimana melindungi endpoint API menggunakan JWT.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Implementasi JWT',
                    description: '<p>Peserta membuat sistem login dengan validasi token JWT pada endpoint tertentu.</p>',
                    content: '<p>Praktikum membangun sistem autentikasi berbasis JWT, dimana peserta membuat endpoint login yang menghasilkan token dan endpoint lain yang memerlukan validasi token untuk akses.</p>',
                    min_score: 85),

                $this->post(title: 'Rate Limiting dan API Key',
                    description: '<p>Strategi pengamanan API dengan pembatasan akses dan penggunaan API Key.</p>',
                    content: '<p>Materi membahas metode pengamanan API dengan membatasi jumlah request (rate limiting) dan penggunaan API Key untuk mengontrol serta mengidentifikasi pengguna API.</p>',
                    min_score: null),

                $this->post(title: 'Dokumentasi API dengan Swagger',
                    description: '<p>Menjelaskan cara membuat dokumentasi interaktif untuk API menggunakan Swagger atau Postman.</p>',
                    content: '<p>Peserta diajarkan membuat dokumentasi API yang interaktif dan mudah dipahami menggunakan Swagger UI dan Postman Collection, sehingga memudahkan pengembang lain dalam menggunakan API.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: API Aplikasi Todo List dengan Login',
                    description: '<p>Peserta membangun API lengkap termasuk fitur autentikasi, otorisasi, dan dokumentasi.</p>',
                    content: '<p>Proyek mini untuk mengintegrasikan semua konsep sebelumnya dengan membuat API Todo List yang memiliki fitur login, otorisasi akses data, serta dokumentasi lengkap menggunakan Swagger.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Desain UI/UX untuk Aplikasi Digital',
            price: 100_000,
            duration: 160,
            posts: [
                $this->post(title: 'Prinsip Desain UI dan UX',
                    description: '<p>Perbedaan UI dan UX serta prinsip-prinsip desain seperti konsistensi dan hierarki visual.</p>',
                    content: '<p>Materi ini menjelaskan perbedaan antara User Interface (UI) dan User Experience (UX), serta membahas prinsip-prinsip desain penting seperti konsistensi, hierarki visual, keseimbangan, dan keterbacaan untuk menciptakan antarmuka yang intuitif dan menyenangkan.</p>',
                    min_score: null),

                $this->post(title: 'Wireframe dan Prototyping',
                    description: '<p>Penggunaan tools seperti Figma untuk membuat sketsa dan prototipe aplikasi.</p>',
                    content: '<p>Peserta diperkenalkan pada proses wireframing dan prototyping menggunakan tools populer seperti Figma, untuk membuat sketsa kasar dan prototipe interaktif yang dapat diuji sebelum pengembangan aplikasi.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Membuat Wireframe Aplikasi Kasir',
                    description: '<p>Peserta membuat wireframe aplikasi kasir sederhana dengan Figma atau alat lain.</p>',
                    content: '<p>Latihan praktis membuat wireframe untuk aplikasi kasir sederhana, fokus pada tata letak antarmuka, penempatan elemen utama, dan alur pengguna yang efisien menggunakan Figma atau alat wireframing lain.</p>',
                    min_score: 80),

                $this->post(title: 'User Flow dan Information Architecture',
                    description: '<p>Menentukan jalur navigasi dan struktur informasi dalam aplikasi.</p>',
                    content: '<p>Materi membahas cara menyusun user flow yang efektif dan membangun arsitektur informasi yang logis untuk memudahkan pengguna dalam menavigasi aplikasi dengan lancar.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Desain User Flow',
                    description: '<p>Peserta menyusun user flow untuk aplikasi pemesanan makanan.</p>',
                    content: '<p>Peserta merancang user flow lengkap untuk aplikasi pemesanan makanan, mencakup langkah-langkah mulai dari pemilihan menu, pembayaran, hingga konfirmasi pesanan, dengan fokus pada pengalaman pengguna yang mulus.</p>',
                    min_score: 80),

                $this->post(title: 'Accessibility dan Inclusive Design',
                    description: '<p>Desain yang mempertimbangkan pengguna dengan kebutuhan khusus.</p>',
                    content: '<p>Penjelasan tentang pentingnya aksesibilitas dan desain inklusif, termasuk prinsip dan teknik untuk membuat aplikasi dapat digunakan oleh semua kalangan, termasuk pengguna dengan disabilitas.</p>',
                    min_score: null),

                $this->post(title: 'Design System dan Komponen UI',
                    description: '<p>Pentingnya design system dan pembuatan komponen reusable.</p>',
                    content: '<p>Materi tentang pembuatan design system yang konsisten dan komponen UI yang dapat digunakan ulang, sehingga mempercepat pengembangan dan memastikan konsistensi desain di seluruh aplikasi.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: Desain Aplikasi Booking Hotel',
                    description: '<p>Peserta mendesain UI dan UX aplikasi pemesanan hotel end-to-end.</p>',
                    content: '<p>Proyek mini yang menuntut peserta merancang desain UI dan UX secara menyeluruh untuk aplikasi booking hotel, mulai dari wireframe, user flow, prototyping, hingga dokumentasi desain.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'Pemrograman Paralel dan Multithreading',
            price: 150_000,
            duration: 200,
            posts: [
                $this->post(title: 'Konsep Paralelisme dan Konkurensi',
                    description: '<p>Perbedaan antara eksekusi paralel dan konkuren dalam pemrograman.</p>',
                    content: '<p>Materi ini membahas konsep dasar paralelisme dan konkurensi, termasuk perbedaan antara keduanya serta manfaat dan tantangan dalam penerapannya pada pengembangan perangkat lunak.</p>',
                    min_score: null),

                $this->post(title: 'Thread dan Process',
                    description: '<p>Pengenalan thread, proses, dan bagaimana sistem operasi mengelolanya.</p>',
                    content: '<p>Penjelasan tentang apa itu thread dan proses, serta bagaimana sistem operasi mengelola keduanya untuk menjalankan aplikasi secara efisien dan terisolasi.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Implementasi Thread',
                    description: '<p>Peserta membuat program multithread sederhana untuk menghitung angka secara paralel.</p>',
                    content: '<p>Latihan praktis mengimplementasikan program multithread yang menjalankan perhitungan angka secara paralel untuk memahami konsep eksekusi bersamaan.</p>',
                    min_score: 80),

                $this->post(title: 'Race Condition dan Deadlock',
                    description: '<p>Menjelaskan masalah yang muncul akibat thread yang tidak disinkronkan.</p>',
                    content: '<p>Materi ini membahas risiko race condition dan deadlock yang terjadi ketika beberapa thread mengakses sumber daya bersama tanpa mekanisme sinkronisasi yang tepat.</p>',
                    min_score: null),

                $this->post(title: 'Sinkronisasi dan Mutex',
                    description: '<p>Teknik untuk mencegah race condition menggunakan kunci (mutex/semaphore).</p>',
                    content: '<p>Penjelasan teknik sinkronisasi menggunakan mutex dan semaphore untuk mengontrol akses thread ke sumber daya bersama dan mencegah konflik.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Simulasi Deadlock dan Solusi',
                    description: '<p>Peserta membuat simulasi deadlock dan memperbaikinya.</p>',
                    content: '<p>Latihan membuat simulasi deadlock dalam program multithread dan menerapkan solusi untuk menghindari kondisi tersebut agar program berjalan stabil.</p>',
                    min_score: 85),

                $this->post(title: 'Parallel Computing dan Task Pool',
                    description: '<p>Pembagian beban kerja dan penggunaan thread pool dalam sistem besar.</p>',
                    content: '<p>Materi membahas bagaimana membagi beban kerja dalam komputasi paralel dan penggunaan thread pool untuk efisiensi manajemen thread dalam aplikasi berskala besar.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: Multithreaded File Downloader',
                    description: '<p>Peserta membuat aplikasi downloader file yang berjalan paralel.</p>',
                    content: '<p>Proyek mini membuat aplikasi downloader file yang menggunakan multithreading untuk mengunduh beberapa file secara bersamaan sehingga mempercepat proses download.</p>',
                    min_score: 85),
            ]
        );

        $this->addBatch(
            name: 'DevOps dan CI/CD Dasar',
            price: 175_000,
            duration: 220,
            posts: [
                $this->post(title: 'Pengenalan DevOps',
                    description: '<p>Konsep DevOps, tujuan, dan praktik kolaborasi antara tim pengembang dan operasi.</p>',
                    content: '<p>DevOps menggabungkan praktik dan alat yang meningkatkan kemampuan organisasi dalam menyediakan layanan dan aplikasi dengan kecepatan tinggi. Fokus utamanya adalah kolaborasi antara tim developer dan tim operasi.</p>',
                    min_score: null),

                $this->post(title: 'Continuous Integration (CI)',
                    description: '<p>Pengenalan CI dan cara mengintegrasikan kode secara otomatis setiap saat ada perubahan.</p>',
                    content: '<p>Continuous Integration adalah praktik mengintegrasikan perubahan kode ke repositori utama secara berkala. Hal ini dilakukan untuk mendeteksi kesalahan lebih awal dan mempercepat proses pengembangan.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Setup GitHub Actions untuk CI',
                    description: '<p>Peserta menyiapkan GitHub Actions untuk menjalankan tes otomatis setiap commit.</p>',
                    content: '<p>Gunakan GitHub Actions untuk membuat workflow yang akan menjalankan script testing saat ada commit ke branch tertentu. Pastikan file <code>.github/workflows/ci.yml</code> sudah dikonfigurasi dengan benar.</p>',
                    min_score: 85),

                $this->post(title: 'Continuous Deployment (CD)',
                    description: '<p>Konsep otomatisasi *deploy* aplikasi ke *server* produksi atau staging.</p>',
                    content: '<p>CD memungkinkan pengiriman aplikasi ke server secara otomatis setelah lolos pengujian. Ini meminimalisir intervensi manual dan mempercepat siklus rilis perangkat lunak.</p>',
                    min_score: null),

                $this->post(title: 'Docker dan Containerization',
                    description: '<p>Penggunaan Docker untuk membungkus aplikasi agar bisa dijalankan di berbagai lingkungan.</p>',
                    content: '<p>Docker memungkinkan aplikasi dan dependensinya dibungkus dalam satu kontainer. Ini memastikan konsistensi lintas lingkungan dan mempermudah deployment.</p>',
                    min_score: null),

                $this->post(title: 'Tugas Membuat Dockerfile untuk Aplikasi Web',
                    description: '<p>Peserta membuat Dockerfile untuk aplikasi Express atau Laravel.</p>',
                    content: '<p>Buat file <code>Dockerfile</code> yang mendefinisikan environment aplikasi Anda. Gunakan base image yang sesuai, salin source code, instal dependensi, dan tentukan perintah untuk menjalankan aplikasi.</p>',
                    min_score: 85),

                $this->post(title: 'Monitoring dan Logging',
                    description: '<p>Pentingnya pencatatan log dan pemantauan aplikasi untuk menjaga stabilitas sistem.</p>',
                    content: '<p>Monitoring membantu tim mendeteksi dan menangani isu secara proaktif. Logging menyediakan informasi penting untuk analisis dan debugging saat terjadi error.</p>',
                    min_score: null),

                $this->post(title: 'Proyek Mini: CI/CD Pipeline Sederhana',
                    description: '<p>Peserta membangun pipeline CI/CD untuk aplikasi Node.js atau Python sederhana.</p>',
                    content: '<p>Bangun pipeline CI/CD yang mencakup proses build, test, dan deployment otomatis menggunakan GitHub Actions dan Docker. Dokumentasikan langkah-langkah yang dilakukan.</p>',
                    min_score: 85),

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
            'thumbnail' => $thumbnail = "thumbnails/batch/$slug.png",
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

        copy(
            storage_path("seeder/$thumbnail"),
            Storage::disk('public')->path($thumbnail),
        );
    }

    protected function post(string $title, string $description, string $content, ?int $min_score): array
    {
        return compact('title', 'description', 'content', 'min_score');
    }
}
